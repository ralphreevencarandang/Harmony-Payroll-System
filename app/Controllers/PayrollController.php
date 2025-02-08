<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use App\Models\UserModel;
use App\Models\AttendanceModel;
use App\Models\EmployeeModel;
use App\Models\EmployeePayheadModel;
use App\Models\EmployeeManualPayheadModel;
use App\Models\ManualPayheadModel;
use App\Models\ContributionTypeListModel;
use App\Models\PayheadModel;
use App\Models\PayrollModel;
use App\Models\HolidayModel;
use Config\Services;
use Dompdf\Dompdf;
use Dompdf\Options;


class PayrollController extends BaseController
{
    public function index()
    {
        try {
            $session = session();
            $userModel = new UserModel();
            $userId = $session->get('id');
            $data['user'] = $userModel->find($userId);
            $payrollModel = new PayrollModel();
            $data['payrolls'] = $payrollModel->select('reference_number, MIN(pay_period_start) as date_from, MAX(pay_period_end) as date_to, payroll_id')
                ->where('is_archive', 0)
                ->groupBy('reference_number')
                ->findAll();

            return View('common/header', $data)
                . View('payroll');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }

    }

    public function generate()
    {
        log_message('info', 'Generate payroll function triggered.');

        // Step 1: Validation
        $validation = \Config\Services::validation();
        $validation->setRules([
            'dateFrom' => 'required|valid_date',
            'dateTo' => 'required|valid_date',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            log_message('error', 'Validation errors: ' . json_encode($validation->getErrors()));
            return redirect()->back()->with('error', 'Validation failed.')->withInput();
        }

        log_message('info', 'Validation passed.');

        $dateFrom = $this->request->getPost('dateFrom');
        $dateTo = $this->request->getPost('dateTo');

        // Step 2: Date Validation
        if ($dateTo < $dateFrom) {
            log_message('error', 'Date validation failed: Date To is before Date From.');
            return redirect()->back()->with('error', 'The "Date To" must be after or equal to "Date From".')->withInput();
        }

        log_message('info', 'Date range is valid.');

        $referenceNumber = $this->generateUniqueReferenceNumber();

        // Step 3: Fetch Employees
        try {
            $employeeModel = new EmployeeModel();
            $employees = $employeeModel->findAll();

            log_message('info', 'Employees fetched: ' . count($employees));
            log_message('info', 'Employee data: ' . json_encode($employees));

            // Step 4: Generate Payroll for Each Employee
            foreach ($employees as $employee) {
                if (!isset($employee['employee_id'])) {
                    log_message('error', "Employee data missing 'employee_id': " . json_encode($employee));
                    continue;
                }

                log_message('info', "Processing Employee ID: {$employee['employee_id']}");
                $this->computePayroll($employee['employee_id'], $dateFrom, $dateTo, $referenceNumber);
            }

            log_message('info', 'Payroll generation completed.');
            return redirect()->to('/payroll')->with('success', 'Payroll generated successfully.');
        } catch (\Exception $e) {
            log_message('error', 'Error occurred: ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }



    private function computePayroll($employeeId, $dateFrom, $dateTo, $referenceNumber)
    {
        log_message('info', "Computing payroll for Employee ID: $employeeId");

        $attendanceModel = new AttendanceModel();
        $contributionModel = new ContributionTypeListModel();
        $manualPayheadModel = new EmployeeManualPayheadModel();
        $payrollModel = new PayrollModel();
        $payheadModel = new PayheadModel();
        $employeeModel = new EmployeeModel();
        $holidayModel = new HolidayModel();  // Add Holiday model

        // Step 1: Fetch Attendance Data
        $attendance = $attendanceModel->select('holiday_rate, SUM(work_hours) as total_hours, SUM(late_hours) as total_late, SUM(undertime_hours) as total_undertime, SUM(overtime_hours) as total_overtime, SUM(is_holiday) as total_holidays')
            ->where('employee_id', $employeeId)
            ->where('date >=', $dateFrom)
            ->where('date <=', $dateTo)
            ->first();

        log_message('info', 'Attendance data: ' . json_encode($attendance));

        // Step 3: Count Total Days Worked
        $attendanceDays = $attendanceModel->where('employee_id', $employeeId)
            ->where('date >=', $dateFrom)
            ->where('date <=', $dateTo)
            ->countAllResults();  // This counts the distinct days the employee worked

        log_message('info', "Attendance days counted: $attendanceDays");

        // Step 4: Fetch Employee Data
        $employee = $employeeModel
            ->where('employee_id', $employeeId)
            ->where('is_archive', 0)
            ->first();
        if (!$employee) {
            log_message('error', "No employee found for Employee ID: $employeeId");
            return; // Exit if employee not found
        }

        log_message('info', 'Employee data fetched: ' . json_encode($employee));

        // Step 5: Calculate Daily Rate and Basic Salary
        $dailyRate = $employee['daily_rate'];  // Assuming this is stored in the employee table
        $basicSalary = $attendanceDays * $dailyRate;  // Calculate based on days worked


        // Fetch holidays within the range
        $holidays = $holidayModel->where('holiday_date >=', $dateFrom)
            ->where('holiday_date <=', $dateTo)
            ->where('is_archive', 0)
            ->findAll();

        log_message('info', 'Holidays fetched: ' . json_encode($holidays));
        // Step 2: Calculate Holiday Pay
        $holidayPremium = 0;

        if ($attendance['total_holidays'] > 0) {
            // I-query ang attendance para sa bawat araw na holiday
            $attendanceData = $attendanceModel->where('employee_id', $employeeId)
                ->where('is_holiday', 1)  // Check if holiday
                ->where('date >=', $dateFrom)
                ->where('date <=', $dateTo)
                ->findAll();

            log_message('info', 'Attendance data for holidays: ' . json_encode($attendanceData));

            // Loop sa bawat holiday attendance record at compute ang premium base sa holiday_rate
            foreach ($attendanceData as $attendanceRecord) {
                $holidayRate = $attendanceRecord['holiday_rate'] ?? 0;  // Default to 0 if holiday_rate is missing

                // Compute ang holiday premium base sa dailyRate at holidayRate
                if ($holidayRate > 0) {
                    $holidayPremium += ($dailyRate * $holidayRate) - $dailyRate;
                }
            }
        }

        log_message('info', "Holiday Premium: $holidayPremium");

        log_message('info', "Holiday Premium: $holidayPremium");

        // Step 7: Calculate Overtime Pay and Late Amount
        $undertimePayhead = $payheadModel->where('payhead_name', 'Overtime')->first();
        $undertimeRate = $undertimePayhead['amount'] ?? 0;

        $overtimePayhead = $payheadModel->where('payhead_name', 'Overtime')->first();
        $overtimeRate = $overtimePayhead['amount'] ?? 0;

        $latetimePayhead = $payheadModel->where('payhead_name', 'Late')->first();
        $latetimeRate = $latetimePayhead['amount'] ?? 0;


        $total_overtime_hours = $attendance['total_overtime'] ?? 0;
        $total_late_hours = $attendance['total_late'] ?? 0;
        $total_undertime_hours = $attendance['total_undertime'] ?? 0;


        $overtimePay = $attendance['total_overtime'] * $overtimeRate;
        $lateAmount = $attendance['total_late'] * $latetimeRate;
        $undertimeAmount = $attendance['total_undertime'] * $undertimeRate;

        log_message('info', 'Overtime Pay: ' . $overtimePay);

        log_message('info', 'Late Amount: ' . $lateAmount);
        log_message('info', 'Undertime Amount: ' . $lateAmount);

        // Step 6: Fetch Contributions and Manual Payheads
        $contributions = $contributionModel->where('employee_id', $employeeId)->findAll();
        $manualPayheads = $manualPayheadModel
            ->select('manual_payhead.*, tbl_employee_manual_payhead.amount')
            ->join('manual_payhead', 'manual_payhead.manual_payhead_id = tbl_employee_manual_payhead.manual_payhead_id')
            ->where('tbl_employee_manual_payhead.employee_id', $employeeId)
            ->findAll();

        $totalEarnings = 0;
        $totalDeductions = array_sum(array_column($contributions, 'contribution_amount')) + $lateAmount;

        // Classify manual payheads as earnings or deductions
        foreach ($manualPayheads as $manualPayhead) {
            if ($manualPayhead['head_type'] === 'Earnings') {
                $totalEarnings += $manualPayhead['amount'];
            } else {
                $totalDeductions += $manualPayhead['amount'];
            }
        }

        log_message('info', 'Total Earnings: ' . $totalEarnings);
        log_message('info', 'Total Deductions: ' . $totalDeductions);

        // Step: Fetch Rest Day Earnings
        $restdayAttendance = $attendanceModel->where('employee_id', $employeeId)
            ->where('is_restday', 1)
            ->where('date >=', $dateFrom)
            ->where('date <=', $dateTo)
            ->findAll();

        $restdayEarnings = 0;
        foreach ($restdayAttendance as $attendanceRecord) {
            $dailyRate = $employee['daily_rate'];
            $restdayEarnings += ($dailyRate * 1.3) - $dailyRate; // Compute the 30% increase
        }

        // Add Rest Day Earnings to Total Earnings
        $totalEarnings += $restdayEarnings;

        // Step 8: Calculate Net Pay
        if ($attendanceDays == 0) {
            $netPay = 0;
            $totalDeductions = 0;
            $totalEarnings = 0;
            $final_netpay = 0;
        } else {
            $netPay = $basicSalary + $overtimePay + $holidayPremium + $totalEarnings;
            $final_netpay = $netPay - $totalDeductions;
            // If final_netpay is negative, set it to basic_salary
            if ($final_netpay < 0) {
                log_message('warning', "Final Net Pay for Employee ID $employeeId is negative. Using Basic Salary instead.");
                $final_netpay = $basicSalary;
            }

        }

        log_message('info', "Net Pay for Employee ID $employeeId: $netPay");

        // Step 9: Save Payroll Data
        $payrollData = [
            'reference_number' => $referenceNumber,
            'employee_id' => $employeeId,
            'pay_period_start' => $dateFrom,
            'pay_period_end' => $dateTo,
            'total_days' => $attendanceDays,
            'basic_salary' => $basicSalary,
            'holiday_premium' => $holidayPremium,
            'overtime_amount' => $overtimePay,
            'total_undertime_hours' => $total_undertime_hours,
            'total_overtime_hours' => $total_overtime_hours,
            'total_late_hours' => $total_late_hours,
            'restday_amount' => $restdayEarnings,

            'late_amount' => $lateAmount,
            'undertime_amount' => $undertimeAmount,
            'earnings' => $totalEarnings, // Store earnings here
            'final_netpay' => $final_netpay, // Store earnings here
            'deductions' => $totalDeductions, // Store deductions here
            'net_pay' => $netPay,
            'date_issued' => date('Y-m-d'),
        ];

        log_message('info', 'Payroll Data: ' . json_encode($payrollData));

        $payrollModel->save($payrollData);
    }







    private function generateUniqueReferenceNumber()
    {
        $payrollModel = new PayrollModel();
        $year = date('Y');

        do {
            $randomNumber = random_int(100000, 999999);
            $referenceNumber = "$year-$randomNumber";
            $exists = $payrollModel->where('reference_number', $referenceNumber)->first();
        } while ($exists);

        return $referenceNumber;
    }


    public function view($referenceNumber)
    {

        try {
            $session = session();
            $userModel = new UserModel();
            $userId = $session->get('id');
            $data['user'] = $userModel->find($userId);


            $payrollModel = new PayrollModel();
            $payroll = $payrollModel
                ->select('tbl_payroll.*, tbl_employee.firstname, tbl_employee.middlename, tbl_employee.lastname')
                ->join('tbl_employee', 'tbl_employee.employee_id = tbl_payroll.employee_id')
                ->where('reference_number', $referenceNumber)->findAll();

            if (!$payroll) {
                return redirect()->back()->with('error', 'Payroll not found.');
            }

            // Get payroll range
            $dateFrom = $payrollModel
                ->select('MIN(pay_period_start) as date_from')
                ->where('reference_number', $referenceNumber)
                ->first()['date_from'];

            $dateTo = $payrollModel
                ->select('MAX(pay_period_end) as date_to')
                ->where('reference_number', $referenceNumber)
                ->first()['date_to'];

            // Format dates (e.g., Sep 16, 2020 - Sep 30, 2020)
            $payrollRange = date('M d, Y', strtotime($dateFrom)) . ' - ' . date('M d, Y', strtotime($dateTo));

            $data['referenceNumber'] = $referenceNumber;
            $data['payrollRange'] = $payrollRange;
            $data['payrolls'] = $payroll;
            return View('common/header', $data)
                . View('payeesList');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }

    }


    public function paysumarry($employeeId, $referenceNumber)
    {
        try {


            $session = session();
            $userModel = new UserModel();
            $userId = $session->get('id');
            $data['user'] = $userModel->find($userId);
            $payrollModel = new PayrollModel();
            $contributionModel = new ContributionTypeListModel();
            $manualPayheadsModel = new EmployeeManualPayheadModel();

            $payroll = $payrollModel
                ->select('tbl_payroll.*, tbl_employee.firstname, tbl_employee.middlename, tbl_employee.lastname, tbl_employee.monthly_rate,tbl_employee.daily_rate, tbl_department.department_name, tbl_position.position_name, tbl_employee.employee_id,tbl_employee.department_id,tbl_employee.position_id,tbl_employee.sick_leave_balance, tbl_employee.vacation_leave_balance ,tbl_department.department_id,tbl_position.position_id,tbl_contribution_type.*')
                ->join('tbl_employee', 'tbl_employee.employee_id = tbl_payroll.employee_id')
                ->join('tbl_department', 'tbl_department.department_id = tbl_employee.department_id')
                ->join('tbl_position', 'tbl_position.position_id = tbl_employee.position_id')
                ->join('tbl_contribution_type', 'tbl_contribution_type.employee_id = tbl_employee.employee_id')
                ->where('tbl_payroll.employee_id', $employeeId)
                ->where('tbl_payroll.reference_number', $referenceNumber) // Ensure employee_id is treated as a string
                // Ensure employee_id is treated as a string
                ->first(); // Use `first()` to get a single record

            if (!$payroll) {
                return redirect()->back()->with('error', 'Payroll not found.');
            }

            $contributions = $contributionModel
                ->select('contribution_name, contribution_amount')
                ->where('employee_id', $employeeId)
                ->findAll();

            $data['contributions'] = [];
            foreach ($contributions as $contribution) {
                $data['contributions'][$contribution['contribution_name']] = $contribution['contribution_amount'];
            }



            $manualPayheads = $manualPayheadsModel
                ->select('manual_payhead.payhead_name, tbl_employee_manual_payhead.amount, manual_payhead.head_type')
                ->join('manual_payhead', 'manual_payhead.manual_payhead_id = tbl_employee_manual_payhead.manual_payhead_id')
                ->where('tbl_employee_manual_payhead.employee_id', $employeeId)
                ->findAll();

            $data['manualPayheads'] = $manualPayheads;

            // Get payroll range (optional, if needed)
            $dateFrom = date('M d, Y', strtotime($payroll['pay_period_start']));
            $dateTo = date('M d, Y', strtotime($payroll['pay_period_end']));

            $payrollRange = $dateFrom . ' - ' . $dateTo;


            $data['payrollRange'] = $payrollRange;
            $data['payroll'] = $payroll; // Single payroll data

            return View('common/header', $data)
                . View('paysummary');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function downloadPaysummary($employeeId, $referenceNumber)
    {
        try {
            // Retrieve payroll and related data (reuse your logic from paysumarry function)
            $payrollModel = new PayrollModel();
            $contributionModel = new ContributionTypeListModel();
            $manualPayheadsModel = new EmployeeManualPayheadModel();

            $payroll = $payrollModel
                ->select('tbl_payroll.*, tbl_employee.firstname, tbl_employee.middlename, tbl_employee.lastname, tbl_employee.monthly_rate,tbl_employee.daily_rate, tbl_department.department_name, tbl_position.position_name, tbl_employee.employee_id,tbl_employee.department_id,tbl_employee.position_id,tbl_department.department_id,tbl_position.position_id,tbl_contribution_type.*')
                ->join('tbl_employee', 'tbl_employee.employee_id = tbl_payroll.employee_id')
                ->join('tbl_department', 'tbl_department.department_id = tbl_employee.department_id')
                ->join('tbl_position', 'tbl_position.position_id = tbl_employee.position_id')
                ->join('tbl_contribution_type', 'tbl_contribution_type.employee_id = tbl_employee.employee_id')
                ->where('tbl_payroll.employee_id', $employeeId)
                ->where('tbl_payroll.reference_number', $referenceNumber) // Ensure employee_id is treated as a string
                // Ensure employee_id is treated as a string
                ->first(); // Use `first()` to get a single record

            if (!$payroll) {
                return redirect()->back()->with('error', 'Payroll not found.');
            }

            $contributions = $contributionModel
                ->select('contribution_name, contribution_amount')
                ->where('employee_id', $employeeId)
                ->findAll();

            $data['contributions'] = [];
            foreach ($contributions as $contribution) {
                $data['contributions'][$contribution['contribution_name']] = $contribution['contribution_amount'];
            }


            $manualPayheads = $manualPayheadsModel
                ->select('manual_payhead.payhead_name, tbl_employee_manual_payhead.amount, manual_payhead.head_type')
                ->join('manual_payhead', 'manual_payhead.manual_payhead_id = tbl_employee_manual_payhead.manual_payhead_id')
                ->where('tbl_employee_manual_payhead.employee_id', $employeeId)
                ->findAll();

            // Get payroll range (optional, if needed)
            $dateFrom = date('M d, Y', strtotime($payroll['pay_period_start']));
            $dateTo = date('M d, Y', strtotime($payroll['pay_period_end']));
            $payrollRange = $dateFrom . ' - ' . $dateTo;
            $data['manualPayheads'] = $manualPayheads;
            $data['payrollRange'] = $payrollRange;
            $data['payroll'] = $payroll; // Single payroll data


            // Load the view for the PDF content
            $html = view('paysummary_pdf', $data);

            // Configure Dompdf
            $options = new Options();
            $options->set('defaultFont', 'DejaVu Sans');
            $dompdf = new Dompdf($options);
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'landscape  ');
            $dompdf->render();

            // Stream the PDF to the browser for download
            $dompdf->stream('Paysummary_' . $employeeId . '.pdf', ['Attachment' => true]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function viewPayslip()
    {
        $session = session();
        $userModel = new UserModel();
        $payrollModel = new PayrollModel();
        $userId = $session->get('id');
        $data['user'] = $userModel->find($userId);

        $data['payrolls'] = $payrollModel->select('tbl_payroll.*, tbl_employee.firstname, tbl_employee.middlename, tbl_employee.lastname, tbl_employee.employee_id')
            ->where('tbl_payroll.employee_id', 'tbl_employee.employee_id')
            ->findAll();
        return View('common/header', $data)
            . View('payslip');
    }

    public function archive($reference_number)
    {
        try {
            $payrollModel = new PayrollModel();

            log_message('info', 'Reference Number Received: ' . $reference_number);

            // Check if the payroll reference exists
            $payroll_reference = $payrollModel->where('reference_number', $reference_number)->first();

            if (!$payroll_reference) {
                return redirect()->back()->with('error', 'Payroll not found.');
            }

            // Check if already archived
            if ($payroll_reference['is_archive'] == 1) {
                return redirect()->back()->with('message', 'Payroll is already archived.');
            }

            

            // Update the is_archive flag to 1
            $payrollModel->where('reference_number', $reference_number)
                ->set(['is_archive' => 1])
                ->update();

            // Log activity
            $currentDate = date('D M j, Y');
            $currentTime = date('H:i A');
            log_activity("Admin archived a Payroll with ID: $reference_number on Date: $currentDate $currentTime", session()->get('id'));

            return redirect()->to('payroll')->with('message', 'Payroll archived successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }










}
