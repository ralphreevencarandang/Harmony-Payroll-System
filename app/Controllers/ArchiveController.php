<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;
use App\Models\DepartmentModel;
use App\Models\PositionModel;
use App\Models\EmployeeModel;
use App\Models\PayheadModel;
use App\Models\HolidayModel;
use App\Models\ManualPayheadModel;
use App\Models\LeaveModel;
use App\Models\PayrollModel;

class ArchiveController extends BaseController
{

    
   

    public function index()
    {

        try {

            $session = session();
            if (!$session->get('logged_in')) {
                // If not logged in, redirect to the login page
                return redirect()->to('/login');
            }

            $departmentModel = new DepartmentModel();
            $positionModel = new PositionModel();
            $emplolyeeModel = new EmployeeModel();
            $payheadModel = new PayheadModel();
            $manualPayheadModel = new ManualPayheadModel();
            $holidayModel = new HolidayModel();
            $leaveModel = new LeaveModel();
            $userModel = new UserModel();
            $payrollModel = new PayrollModel();

            // Fetch departments where is_archive is 1
            $data['archivedDepartments'] = $departmentModel->where('is_archive', 1)->findAll();
            $data['archivedPositions'] = $positionModel
                ->select('tbl_position.*, tbl_department.department_name')
                ->join('tbl_department', 'tbl_department.department_id = tbl_position.department_id')
                ->where('tbl_position.is_archive', 1)->findAll();

            $data['archivedEmployees'] = $emplolyeeModel
                ->select('tbl_employee.*, tbl_department.department_name, tbl_position.position_name')
                ->join('tbl_department', 'tbl_department.department_id = tbl_employee.department_id')
                ->join('tbl_position', 'tbl_position.position_id = tbl_employee.position_id')
                ->where('tbl_employee.is_archive', 1)
                ->findAll();

            $data['archivePayheads'] = $payheadModel->where('is_archive', 1)->findAll();
            $data['archiveHolidays'] = $holidayModel->where('is_archive',1)->findAll();
            $data['archiveManualPayheads'] = $manualPayheadModel->where('is_archive',1)->findAll();

            $data['archivedLeaves'] = $leaveModel
            ->select('tbl_leave.*, tbl_employee.employee_id, tbl_employee.firstname, tbl_employee.middlename, tbl_employee.lastname')
            ->join('tbl_employee', 'tbl_employee.employee_id = tbl_leave.employee_id')
            ->where('tbl_leave.is_archive', 1)->findAll();

       
            $data['archivePayrolls'] = $payrollModel->select('reference_number, MIN(pay_period_start) as date_from, MAX(pay_period_end) as date_to, payroll_id')
                ->where('is_archive', 1)
                ->groupBy('reference_number')
                ->findAll();



           
            $userId = $session->get('id');
            $data['user'] = $userModel->find($userId);


            return view('common/header', $data)
                . view('archive', $data);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }

    }

   

    public function unarchiveDepartment($id)
    {

        try {

            $departmentModel = new DepartmentModel();

            // Update the is_archive flag to 0
            $departmentModel->update($id, ['is_archive' => 0]);

            
           
            $currentDate = date('D M j, Y');
            $currentTime = date('H:i A');
            log_activity("Admin unarchive a department with ID: $id on Date: $currentDate $currentTime", session()->get('id'));

            return redirect()->to('archive')->with('message', 'Department restored successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }


    }


    public function unarchivePosition($id)
    {
        try {
            $positionModel = new PositionModel();

            // Update the is_archive flag to 0
            $positionModel->update($id, ['is_archive' => 0]);

          

            $currentDate = date('D M j, Y');
            $currentTime = date('H:i A');
            log_activity("Admin unarchive a Position with ID: $id on Date: $currentDate $currentTime", session()->get('id'));

            return redirect()->to('archive')->with('message', 'Position restored successfully.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }

    }




    public function unarchiveEmployee($id)
    {

        try {
            $employeeModel = new EmployeeModel();

            // Update the is_archive flag to 0
            $employeeModel->update($id, ['is_archive' => 0]);

            $employee = $employeeModel->find($id);
            $employee_id = $employee['employee_id'];

            $currentDate = date('D M j, Y');
            $currentTime = date('H:i A');
            log_activity("Admin unarchive a Employee with ID: $employee_id on Date: $currentDate $currentTime", session()->get('id'));

            return redirect()->to('archive')->with('message', 'Employee restored successfully.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }

    }
    public function unarchivePayhead($id)
    {
        try {
            $payheadModel = new PayheadModel();

            // Update the is_archive flag to 0
            $payheadModel->update($id, ['is_archive' => 0]);

            $currentDate = date('D M j, Y');
            $currentTime = date('H:i A');
            log_activity("Admin unarchive a Payhead with ID: $id on Date: $currentDate $currentTime", session()->get('id'));

            return redirect()->to('archive')->with('message', 'Payhead restored successfully.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }

    }
    public function unarchiveManualPayhead($id)
    {
        try {
            $manualPayheadModel = new ManualPayheadModel();

            // Update the is_archive flag to 0
            $manualPayheadModel->update($id, ['is_archive' => 0]);

            $currentDate = date('D M j, Y');
            $currentTime = date('H:i A');
            log_activity("Admin unarchive a manual payhead with ID: $id on Date: $currentDate $currentTime", session()->get('id'));

            return redirect()->to('archive')->with('message', 'Manual payhead restored successfully.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }

    }
    public function unarchiveHoliday($id)
    {
        try {
            $holidayModel = new HolidayModel();

            // Update the is_archive flag to 0
            $holidayModel->update($id, ['is_archive' => 0]);

            $currentDate = date('D M j, Y');
            $currentTime = date('H:i A');
            log_activity("Admin unarchive a Holiday with ID: $id on Date: $currentDate $currentTime", session()->get('id'));
            return redirect()->to('archive')->with('message', 'Holiday restored successfully.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }

    }
    public function unarchiveLeave($id)
    {
        try {
            $leaveModel = new LeaveModel();

            // Update the is_archive flag to 0
            $leaveModel->update($id, ['is_archive' => 0]);

            $currentDate = date('D M j, Y');
            $currentTime = date('H:i A');
            log_activity("Admin unarchive a Leave    with ID: $id on Date: $currentDate $currentTime", session()->get('id'));
            return redirect()->to('archive')->with('message', 'Archive restored successfully.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }


    }

    public function unarchivePayroll($reference_number)
    {
        try {
            $payrollModel = new PayrollModel();

            // Update the is_archive flag to 0
            $payrollModel->where('reference_number', $reference_number)
            ->set(['is_archive' => 0])
            ->update();

            $currentDate = date('D M j, Y');
            $currentTime = date('H:i A');
            log_activity("Admin unarchive a Leave    with ID: $reference_number on Date: $currentDate $currentTime", session()->get('id'));
            return redirect()->to('archive')->with('message', 'Archive restored successfully.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }

    }

    public function deleteHoliday($id)
    {

        try {
            $model = new HolidayModel;
            $model->delete($id);

            $currentDate = date('D M j, Y');
            $currentTime = date('H:i A');
            log_activity("Admin deleted a holiday with ID: $id on Date: $currentDate $currentTime", session()->get('id'));
            return redirect()->to('/archive')->with('message', 'Holiday deleted successfully');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }

    }

    public function deletePayhead($id)
    {

        try {
            $model = new PayheadModel();
            $model->delete($id);

            $currentDate = date('D M j, Y');
            $currentTime = date('H:i A');
            log_activity("Admin deleted a automatic payhead with ID: $id on Date: $currentDate $currentTime", session()->get('id'));

            return redirect()->to('/archive')->with('message', 'Payhead deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();

        }


    }
    public function deleteManualPayhead($id)
    {

        try {
            $model = new ManualPayheadModel();
            $model->delete($id);

            $currentDate = date('D M j, Y');
            $currentTime = date('H:i A');
            log_activity("Admin deleted a manual payhead with ID: $id on Date: $currentDate $currentTime", session()->get('id'));

            return redirect()->to('/archive')->with('message', 'Payhead deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();

        }


    }

    public function deletePosition($id)
    {

        try {
            $model = new PositionModel();
            $departmentModel = new DepartmentModel();
            $model->delete($id);
            $data['departments'] = $departmentModel->findAll();
            $data['positions'] = $model->findAll();


            $currentDate = date('D M j, Y');
            $currentTime = date('H:i A');
            log_activity("Admin deleted a position with ID: $id on Date: $currentDate $currentTime", session()->get('id'));

            return redirect()->to('/archive')->with('message', 'Position deleted successfully!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }


    }

    public function deleteDepartment($id)
    {

        try {
            $model = new DepartmentModel;
            $model->delete($id);


            $currentDate = date('D M j, Y');
            $currentTime = date('H:i A');
            log_activity("Admin deleted a department with ID: $id on Date: $currentDate $currentTime", session()->get('id'));

            return redirect()->to('/archive')->with('message', 'Department deleted successfully!');


        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }

    }

    public function deleteEmployee($id)
    {
        try {

            $model = new EmployeeModel();

           

            $employee = $model->find($id);

            // Check if the employee exists
            if ($employee) {
                // Get the employee's employee_id
                $employeeId = $employee['employee_id']; // Assuming 'employee_id' is the column name in the DB
            } else {
                return redirect()->back()->with('error', 'Employee not found.');
            }

            $model->delete($id);


            $currentDate = date('D M j, Y');
            $currentTime = date('H:i A');
            log_activity("Admin deleted a employee with ID: $employeeId on Date: $currentDate $currentTime", session()->get('id'));

            return redirect()->to('archive')->with('message', 'Employee deleted successully.');



        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }


}
