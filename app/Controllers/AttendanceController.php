<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\EmployeeModel;
use App\Models\AttendanceModel;
use App\Models\HolidayModel;

use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;
use TCPDF;

class AttendanceController extends BaseController
{
    public function index()
    {

        $employee_id = $this->request->getGet('employee_id');

        $date = date('Y-m-d');

        $model = new UserModel();
        $employeeModel = new EmployeeModel();
        $session = session();

        if (!$session->get('logged_in')) {
            // If not logged in, redirect to the login page
            return redirect()->to('/login');
        }
        $userId = $session->get('id');
        $data['user'] = $model->find($userId);


        $date = date('Y-m-d');

        $attendanceModel = new AttendanceModel();

        $data['employees'] = $attendanceModel
            ->select('
            tbl_employee.employee_id, 
            tbl_employee.firstname, 
            tbl_employee.middlename, 
            tbl_employee.lastname, 
            tbl_employee.time_in AS emp_time_in, 
            tbl_employee.time_out AS emp_time_out, 
            tbl_attendance.date, 
            tbl_attendance.time_in AS att_time_in, 
            tbl_attendance.time_out AS att_time_out, 
            tbl_attendance.work_hours,
            tbl_attendance.late_hours,
            tbl_attendance.undertime_hours,
            tbl_department.department_name,
            tbl_department.department_id,
        ')
            ->join('tbl_employee', 'tbl_attendance.employee_id = tbl_employee.employee_id')
            ->join('tbl_department', 'tbl_employee.department_id = tbl_department.department_id')
            ->where('tbl_attendance.date', $date)
            ->findAll();

        $data['selected_date'] = $date;
        $data['employee_id'] = $employee_id; // Pass employee_id to view





        $data['employeesmodel'] = $employeeModel->findAll();


        return View('common/header', $data)
            . View('attendance', $data);
    }

    public function filterAttendance()
    {
        $model = new UserModel();
        $employeeModel = new EmployeeModel();
        $session = session();

        if (!$session->get('logged_in')) {
            // If not logged in, redirect to the login page
            return redirect()->to('/login');
        }
        $userId = $session->get('id');
        $data['user'] = $model->find($userId);
        $employee_id = $this->request->getGet('employee_id');

        $date = $this->request->getGet('date') ?? date('Y-m-d');
        $attendanceModel = new AttendanceModel();

        $data['employees'] = $attendanceModel
            ->select('
            tbl_employee.employee_id, 
            tbl_employee.firstname, 
            tbl_employee.middlename, 
            tbl_employee.lastname, 
            tbl_employee.time_in AS emp_time_in, 
            tbl_employee.time_out AS emp_time_out, 
            tbl_attendance.date, 
            tbl_attendance.time_in AS att_time_in, 
            tbl_attendance.time_out AS att_time_out, 
            tbl_attendance.work_hours,
            tbl_attendance.late_hours,
            tbl_attendance.undertime_hours,
            tbl_department.department_name,
            tbl_department.department_id,
        ')
            ->join('tbl_employee', 'tbl_attendance.employee_id = tbl_employee.employee_id')
            ->join('tbl_department', 'tbl_employee.department_id = tbl_department.department_id')
            ->where('tbl_attendance.date', $date)
            ->findAll();

        $data['selected_date'] = $date;
        $data['employee_id'] = $employee_id; // Pass employee_id to view


        $data['employeesmodel'] = $employeeModel->findAll();


        return View('common/header', $data)
            . View('attendance', $data);
    }

    public function employeeAttendance()
    {

        $model = new UserModel();
        $employeeModel = new EmployeeModel();
        $session = session();

        if (!$session->get('logged_in')) {
            // If not logged in, redirect to the login page
            return redirect()->to('/login');
        }
        $userId = $session->get('id');
        $data['user'] = $model->find($userId);

        $date = $this->request->getGet('date') ?? date('Y-m-d');
        $employee_id = $this->request->getGet('employee_id');

        // Debugging: Check if employee_id is passed
        // var_dump($employee_id); // Add this to check if employee_id is received
        // die(); // Stop execution to see the result
        $attendanceModel = new AttendanceModel();

        $data['employees'] = $attendanceModel
            ->select('
            tbl_employee.employee_id, 
            tbl_employee.firstname, 
            tbl_employee.middlename, 
            tbl_employee.lastname, 
            tbl_employee.time_in AS emp_time_in, 
            tbl_employee.time_out AS emp_time_out, 
            tbl_attendance.employee_id, 
            tbl_attendance.date, 
            tbl_attendance.time_in AS att_time_in, 
            tbl_attendance.time_out AS att_time_out, 
            tbl_attendance.work_hours,
            tbl_attendance.late_hours,
            tbl_attendance.undertime_hours,
            tbl_department.department_name,
            tbl_department.department_id,
        ')
            ->join('tbl_employee', 'tbl_attendance.employee_id = tbl_employee.employee_id')
            ->join('tbl_department', 'tbl_employee.department_id = tbl_department.department_id')
            ->where('tbl_attendance.employee_id', $employee_id)
            ->findAll();

        $data['selected_date'] = $date;
        $data['employee_id'] = $employee_id; // Pass employee_id to view

        $data['employeesmodel'] = $employeeModel->findAll();


        return View('common/header', $data)
            . View('attendance', $data);

    }





    public function downloadPDF()
    {
        $date = $this->request->getGet('date');  // Get the selected date
        $employeeId = $this->request->getGet('employee_id');  // Get employee_id



        // Check if employee_id is valid (exists in the database)
        if ($employeeId) {
            $employeeModel = new EmployeeModel();
            $employee = $employeeModel
                ->where('employee_id', $employeeId)
                ->findAll();

            if (!$employee) {
                // Invalid employee_id, handle error or return
                return redirect()->back()->with('error', 'Invalid employee selected.');
            }
        }

        // Attendance model
        $attendanceModel = new AttendanceModel();

        // Start the query and join necessary tables
        $query = $attendanceModel
            ->select('
            tbl_employee.employee_id, 
            tbl_employee.firstname, 
            tbl_employee.middlename, 
            tbl_employee.lastname, 
            tbl_employee.time_in AS shift_in, 
            tbl_employee.time_out AS shift_out, 
            tbl_attendance.date, 
            tbl_attendance.time_in AS att_time_in, 
            tbl_attendance.time_out AS att_time_out, 
            tbl_attendance.work_hours,
            tbl_attendance.late_hours,
            tbl_attendance.undertime_hours,
            tbl_department.department_name
        ')
            ->join('tbl_employee', 'tbl_attendance.employee_id = tbl_employee.employee_id')
            ->join('tbl_department', 'tbl_employee.department_id = tbl_department.department_id')
            ->where('tbl_attendance.date', $date);



        // Get the filtered data
        $data['employees'] = $query->findAll();

        // Generate the PDF
        $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator('CodeIgniter 4');
        $pdf->SetAuthor('Your Company');
        $pdf->SetTitle('Attendance Report');
        $pdf->SetSubject('Attendance PDF');

        $pdf->AddPage();
        $pdf->SetFont('helvetica', '', 10);

        $html = '<h1>Attendance Report</h1><table border="1" cellpadding="5">
        <thead>
            <tr>
                <th>Date</th><th>Employee ID</th><th>Name</th><th>Department</th>
                <th>Shift In</th><th>Shift Out</th><th>Actual In</th><th>Actual Out</th>
                <th>Work Hours</th><th>Late</th><th>Undertime</th>
            </tr>
        </thead><tbody>';

        foreach ($data['employees'] as $employee) {
            $html .= '<tr>
            <td>' . $employee['date'] . '</td>
            <td>' . $employee['employee_id'] . '</td>
            <td>' . $employee['firstname'] . ' ' . $employee['middlename'] . ' ' . $employee['lastname'] . '</td>
            <td>' . $employee['shift_in'] . '</td>
            <td>' . $employee['shift_out'] . '</td>

            <td>' . $employee['department_name'] . '</td>
            <td>' . $employee['att_time_in'] . '</td>
            <td>' . $employee['att_time_out'] . '</td>
            <td>' . $employee['work_hours'] . '</td>
            <td>' . $employee['late_hours'] . '</td>
            <td>' . $employee['undertime_hours'] . '</td>
        </tr>';
        }

        $html .= '</tbody></table>';
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output('attendance_report.pdf', 'D');



    }

    public function downloadPDFEmployee()
    {
        $date = $this->request->getGet('date');  // Get the selected date
        $employeeId = $this->request->getGet('employee_id');  // Get employee_id



        // Check if employee_id is valid (exists in the database)
        if ($employeeId) {
            $employeeModel = new EmployeeModel();
            $employee = $employeeModel
                ->where('employee_id', $employeeId)
                ->findAll();

            if (!$employee) {
                // Invalid employee_id, handle error or return
                return redirect()->back()->with('error', 'Invalid employee selected.');
            }
        }

        // Attendance model
        $attendanceModel = new AttendanceModel();

        // Start the query and join necessary tables
        $query = $attendanceModel
            ->select('
            tbl_employee.employee_id, 
            tbl_employee.firstname, 
            tbl_employee.middlename, 
            tbl_employee.lastname, 
               tbl_employee.time_in AS shift_in, 
            tbl_employee.time_out AS shift_out, 
            tbl_attendance.date, 
            tbl_attendance.time_in AS att_time_in, 
            tbl_attendance.time_out AS att_time_out, 
            tbl_attendance.work_hours,
            tbl_attendance.late_hours,
            tbl_attendance.undertime_hours,
            tbl_department.department_name
        ')
            ->join('tbl_employee', 'tbl_attendance.employee_id = tbl_employee.employee_id')
            ->join('tbl_department', 'tbl_employee.department_id = tbl_department.department_id')
            ->where('tbl_attendance.employee_id', $employeeId);



        // // Apply date filter if provided
        // if ($date) {
        //     $query->where('tbl_attendance.date', $date);
        // }else if ($employeeId) {
        //     $query->where('tbl_attendance.employee_id', $employeeId);

        // }



        // Get the filtered data
        $data['employees'] = $query->findAll();

        // Generate the PDF
        $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator('CodeIgniter 4');
        $pdf->SetAuthor('Your Company');
        $pdf->SetTitle('Attendance Report');
        $pdf->SetSubject('Attendance PDF');

        $pdf->AddPage();
        $pdf->SetFont('helvetica', '', 11);

        $html = '<h1>Attendance Report</h1><table border="1" cellpadding="5">
        <thead>
            <tr>
                <th>Date</th><th>Employee ID</th><th>Name</th><th>Department</th>
                <th>Shift In</th><th>Shift Out</th><th>Actual In</th><th>Actual Out</th>
                <th>Work Hours</th><th>Late</th><th>Undertime</th>
            </tr>
        </thead><tbody>';

        foreach ($data['employees'] as $employee) {
            $html .= '<tr>
            <td>' . $employee['date'] . '</td>
            <td>' . $employee['employee_id'] . '</td>
            <td>' . $employee['firstname'] . ' ' . $employee['middlename'] . ' ' . $employee['lastname'] . '</td>
             <td>' . $employee['shift_in'] . '</td>
            <td>' . $employee['shift_out'] . '</td>

            <td>' . $employee['department_name'] . '</td>
            <td>' . $employee['att_time_in'] . '</td>
            <td>' . $employee['att_time_out'] . '</td>
            <td>' . $employee['work_hours'] . '</td>
            <td>' . $employee['late_hours'] . '</td>
            <td>' . $employee['undertime_hours'] . '</td>
        </tr>';
        }

        $html .= '</tbody></table>';
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output('attendance_report.pdf', 'D');



    }

    public function downloadCSV()
    {
        // Get the selected date from the request
        $date = $this->request->getGet('date') ?? date('Y-m-d');

        // Fetch attendance data from the database
        $attendanceModel = new AttendanceModel();
        $attendanceData = $attendanceModel
            ->select('
            tbl_attendance.date, 
            tbl_employee.employee_id, 
            CONCAT(tbl_employee.firstname, " ", tbl_employee.middlename, " ", tbl_employee.lastname) AS personnel,
            tbl_department.department_name, 
            tbl_employee.time_in AS shift_in, 
            tbl_employee.time_out AS shift_out, 
            tbl_attendance.time_in AS actual_in, 
            tbl_attendance.time_out AS actual_out, 
            tbl_attendance.work_hours, 
            tbl_attendance.late_hours, 
            tbl_attendance.undertime_hours
        ')
            ->join('tbl_employee', 'tbl_attendance.employee_id = tbl_employee.employee_id')
            ->join('tbl_department', 'tbl_employee.department_id = tbl_department.department_id')
            ->where('tbl_attendance.date', $date)
            ->findAll();

        // Prepare CSV headers
        $csvHeader = ['Date', 'Employee ID', 'Personnel', 'Department', 'Shift-In', 'Shift-Out', 'Actual-In', 'Actual-Out', 'Work Hours', 'Late Hours', 'Undertime Hours'];

        // Set file headers
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="attendance_' . date('Ymd') . '.csv"');

        $output = fopen('php://output', 'w');
        echo "\xEF\xBB\xBF"; // Add UTF-8 BOM for proper encoding

        // Write header row to CSV
        fputcsv($output, $csvHeader);

        // Write rows to CSV
        if (!empty($attendanceData)) {
            foreach ($attendanceData as $row) {
                fputcsv($output, [
                    $row['date'],
                    $row['employee_id'],
                    $row['personnel'],
                    $row['department_name'],
                    $row['shift_in'],
                    $row['shift_out'],
                    $row['actual_in'],
                    $row['actual_out'],
                    $row['work_hours'],
                    $row['late_hours'],
                    $row['undertime_hours']
                ]);
            }
        } else {
            fputcsv($output, ['No data available for the selected date.']);
        }

        fclose($output);
        exit;
    }

    public function downloadCSVEmployee()
    {
        // Get the selected date from the request

        $employeeId = $this->request->getGet('employee_id');  // Get employee_id


        // Fetch attendance data from the database
        $attendanceModel = new AttendanceModel();
        $attendanceData = $attendanceModel
            ->select('
            tbl_attendance.date, 
            tbl_employee.employee_id, 
            CONCAT(tbl_employee.firstname, " ", tbl_employee.middlename, " ", tbl_employee.lastname) AS personnel,
            tbl_department.department_name, 
            tbl_employee.time_in AS shift_in, 
            tbl_employee.time_out AS shift_out, 
            tbl_attendance.time_in AS actual_in, 
            tbl_attendance.time_out AS actual_out, 
            tbl_attendance.work_hours, 
            tbl_attendance.late_hours, 
            tbl_attendance.undertime_hours
        ')
            ->join('tbl_employee', 'tbl_attendance.employee_id = tbl_employee.employee_id')
            ->join('tbl_department', 'tbl_employee.department_id = tbl_department.department_id')
            ->where('tbl_attendance.employee_id', $employeeId)
            ->findAll();

        // Prepare CSV headers
        $csvHeader = ['Date', 'Employee ID', 'Personnel', 'Department', 'Shift-In', 'Shift-Out', 'Actual-In', 'Actual-Out', 'Work Hours', 'Late Hours', 'Undertime Hours'];

        // Set file headers
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="attendance_' . date('Ymd') . '.csv"');

        $output = fopen('php://output', 'w');
        echo "\xEF\xBB\xBF"; // Add UTF-8 BOM for proper encoding

        // Write header row to CSV
        fputcsv($output, $csvHeader);

        // Write rows to CSV
        if (!empty($attendanceData)) {
            foreach ($attendanceData as $row) {
                fputcsv($output, [
                    $row['date'],
                    $row['employee_id'],
                    $row['personnel'],
                    $row['department_name'],
                    $row['shift_in'],
                    $row['shift_out'],
                    $row['actual_in'],
                    $row['actual_out'],
                    $row['work_hours'],
                    $row['late_hours'],
                    $row['undertime_hours']
                ]);
            }
        } else {
            fputcsv($output, ['No data available for the selected date.']);
        }

        fclose($output);
        exit;
    }







    public function logAttendance()
    {
        date_default_timezone_set('Asia/Manila');

        $uid = $this->request->getPost('uid');
        if (!$uid) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'UID is required']);
        }
        log_message('info', 'UID received: ' . $uid);

        $employeeModel = new EmployeeModel();
        $attendanceModel = new AttendanceModel();
        $holidayModel = new HolidayModel(); // Load holiday model

        // Find employee by UID
        $employee = $employeeModel->where('rfid_uid', $uid)->first();
        if (!$employee) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'UID not found']);
        }

        // Log attendance actions
        log_message('info', 'Employee found: ' . json_encode($employee));
        $employeeId = $employee['employee_id'];
        $scheduledTimeIn = $employee['time_in']; // Scheduled time-in
        $scheduledTimeOut = $employee['time_out']; // Scheduled time-out

        $todayAttendance = $attendanceModel
            ->where('employee_id', $employeeId)
            ->where('date', date('Y-m-d'))
            ->first();

        // Check if today is a holiday
        $holiday = $holidayModel->where('holiday_date', date('Y-m-d'))->first();
        $isHoliday = 0;
        $holidayRate = 0;

        if ($holiday) {
            $isHoliday = 1;
            $holidayRate = $holiday['holiday_rate']; // Assuming this column exists
        }

        // Check if today is the employee's rest day
        $todayDayName = strtolower(date('l')); // Get day name in lowercase (e.g., "saturday")
        $isRestday = ($todayDayName === strtolower($employee['restday'])) ? 1 : 0;

        if (!$todayAttendance) {
            // Calculate late hours if this is the first time-in
            $actualTimeIn = new \DateTime(date('H:i:s'));
            $expectedTimeIn = new \DateTime($scheduledTimeIn);
            $lateHours = 0;

            if ($actualTimeIn > $expectedTimeIn) {
                $lateDiff = $actualTimeIn->diff($expectedTimeIn);
                $lateHours = $lateDiff->h + ($lateDiff->i / 60); // Convert minutes to decimal
            }

            // Record time_in and late hours if no attendance for today
            $attendanceModel->insert([
                'employee_id' => $employeeId,
                'rfid_uid' => $uid,
                'date' => date('Y-m-d'),
                'time_in' => date('H:i:s'),
                'late_hours' => $lateHours,
                'is_holiday' => $isHoliday,
                'holiday_rate' => $holidayRate,
                'is_restday' => $isRestday, // Save rest day flag

            ]);

            log_message('info', 'Attendance successfully logged for employee: ' . $employee['employee_id']);
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Time In recorded',
                'late_hours' => $lateHours,
                'is_holiday' => $isHoliday,
                'holiday_rate' => $holidayRate,
                'is_restday' => $isRestday,
            ]);
        } elseif (empty($todayAttendance['time_out'])) {
            // Calculate work hours
            $timeIn = new \DateTime($todayAttendance['time_in']);
            $timeOut = new \DateTime(date('H:i:s'));
            $workDiff = $timeOut->diff($timeIn);
            $workHours = $workDiff->h + ($workDiff->i / 60); // Convert minutes to decimal

            // Calculate undertime if actual time-out is earlier than scheduled
            $scheduledTimeOutObj = new \DateTime($scheduledTimeOut);
            $undertime = 0;
            if ($timeOut < $scheduledTimeOutObj) {
                $undertimeDiff = $scheduledTimeOutObj->diff($timeOut);
                $undertime = $undertimeDiff->h + ($undertimeDiff->i / 60); // Convert minutes to decimal
            }

            // Calculate overtime if actual time-out is later than scheduled
            $overtime = 0;
            if ($timeOut > $scheduledTimeOutObj) {
                $overtimeDiff = $timeOut->diff($scheduledTimeOutObj);
                $overtime = $overtimeDiff->h + ($overtimeDiff->i / 60); // Convert minutes to decimal
            }

            // Record time_out and work hours
            $attendanceModel->where('employee_id', $employeeId)
                ->where('date', date('Y-m-d'))
                ->set([
                    'time_out' => date('H:i:s'),
                    'work_hours' => $workHours,
                    'undertime_hours' => $undertime,
                    'overtime_hours' => $overtime,
                ])
                ->update();

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Time Out recorded',
                'work_hours' => $workHours,
                'undertime_hours' => $undertime,
                'overtime_hours' => $overtime
            ]);
        } else {
            // Already logged both time_in and time_out
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Attendance already complete for today'
            ]);
        }



    }









}
