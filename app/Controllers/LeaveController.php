<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\LeaveModel;
use App\Models\UserModel;

use App\Models\DepartmentModel;
use App\Models\EmployeeModel;

class LeaveController extends BaseController
{
    public function index()
    {
        try {

            $session = session();

            if (!$session->get('logged_in')) {
                // If not logged in, redirect to the login page
                return redirect()->to('/login');
            }

            $employeeModel = new EmployeeModel();
            $departmentModel = new DepartmentModel();

            $data['departments'] = $departmentModel->findAll();



            $userModel = new UserModel();
            $userId = $session->get('id');
            $data['user'] = $userModel->find($userId);

            $leaveModel = new LeaveModel();

            $data['leaves'] = $leaveModel
                ->select('tbl_leave.*, tbl_employee.firstname,tbl_employee.middlename,tbl_employee.lastname')
                ->join('tbl_employee', 'tbl_employee.employee_id = tbl_leave.employee_id')
                ->where('tbl_leave.is_archive', 0)
                ->findAll();

            return view('common/header', $data)
                . view('leave', $data);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();

        }
    }

    public function getEmployees()
    {
        $departmentId = $this->request->getVar('department_id');

        $employeeModel = new EmployeeModel();
        $employees = $employeeModel->where('department_id', $departmentId)
            ->where('is_archive', 0)
            ->findAll();



        return $this->response->setJSON($employees);
    }


    public function addLeave()
    {
        try {

            $leaveModel = new LeaveModel();
            $employeeModel = new EmployeeModel();
            $employeeId = esc($this->request->getPost('employee_id'));
            $leaveType = esc($this->request->getPost('leave_type'));

            $startDate = esc($this->request->getPost('start_date'));
            $endDate = esc($this->request->getPost('end_date'));

            $start = new \DateTime($startDate);
            $end = new \DateTime($endDate);
            $days = $start->diff($end)->days + 1; // +1 para isama ang parehong araw

            if ($end < $start) {
                return redirect()->back()->with('error', 'End Date cannot be earlier than Start Date.')->withInput();
            }

            // Kunin ang employee data
            $employee = $employeeModel->where('employee_id', $employeeId)->first();
            if (!$employee) {
                return redirect()->back()->with('error', 'Employee not found.')->withInput();
            }

            // I-check kung sapat ang leave balance
            if ($leaveType === 'Sick Leave' && $employee['sick_leave_balance'] < $days) {
                return redirect()->back()->with('error', 'Not enough sick leave balance.')->withInput();
            }
            if ($leaveType === 'Vacation Leave' && $employee['vacation_leave_balance'] < $days) {
                return redirect()->back()->with('error', 'Not enough vacation leave balance.')->withInput();
            }

            // I-update ang leave balance
            if ($leaveType === 'Sick Leave') {
                $employeeModel->update($employee['id'], [
                    'sick_leave_balance' => $employee['sick_leave_balance'] - $days
                ]);
            } elseif ($leaveType === 'Vacation Leave') {
                $employeeModel->update($employee['id'], [
                    'vacation_leave_balance' => $employee['vacation_leave_balance'] - $days
                ]);
            }


            $data = array(
                'employee_id' => esc($this->request->getPost('employee_id')),
                'leave_type' => esc($this->request->getPost('leave_type')),
                'leave_start_date' => $startDate,
                'leave_end_date' => $endDate,
                'reason' => esc($this->request->getPost('reason')),
                'number_of_days' => $days
            );
            

            $leaveModel->save($data);

            $currentDate = date('D M j, Y');
            $currentTime = date('H:i A');
            log_activity("Admin added a Leave on Date: $currentDate $currentTime", session()->get('id'));

            return redirect()->to('/leave')->with('message', 'Leave added successfully.');


        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();

        }
    }

    public function deleteLeave($id)
    {

        try {
            $modal = new LeaveModel();
            $modal->delete($id);

            $currentDate = date('D M j, Y');
            $currentTime = date('H:i A');
            log_activity("Admin deleted a Leave with ID: $id on Date: $currentDate $currentTime", session()->get('id'));

            return redirect()->to('/leave')->with('message', 'Leave deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();

        }


    }

    public function editLeave($id)
    {
        try {

            $session = session();

            $departmentModel = new DepartmentModel();

            $data['departments'] = $departmentModel->findAll();


            $modal = new LeaveModel();
            $data['leave_column'] = $modal
                ->select('tbl_leave.*, tbl_employee.employee_id, tbl_employee.firstname, tbl_employee.middlename, tbl_employee.lastname, tbl_employee.department_id, tbl_department.department_name')
                ->join('tbl_employee', 'tbl_employee.employee_id = tbl_leave.employee_id')
                ->join('tbl_department', 'tbl_department.department_id = tbl_employee.department_id')
                ->where('tbl_leave.is_archive', 0)
                ->find($id);

            $data['leaves'] = $modal
                ->select('tbl_leave.*, tbl_employee.firstname,tbl_employee.middlename,tbl_employee.lastname,tbl_employee.department_id')
                ->join('tbl_employee', 'tbl_employee.employee_id = tbl_leave.employee_id')
                ->where('tbl_leave.is_archive', 0)
                ->findAll();


            $userModel = new UserModel();
            $userId = $session->get('id');
            $data['user'] = $userModel->find($userId);

            return view('common/header', $data)
                . view('leave', $data);



        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();

        }
    }

    public function updateLeave($id)
    {
        try {

            $model = new LeaveModel();

            $startDate = esc($this->request->getPost('start_date'));
            $endDate = esc($this->request->getPost('end_date'));

            $start = new \DateTime($startDate);
            $end = new \DateTime($endDate);
            $days = $start->diff($end)->days + 1; // +1 para isama ang parehong araw

            if ($end < $start) {
                return redirect()->back()->with('error', 'End Date cannot be earlier than Start Date.')->withInput();
            }

            $data = array(
                'leave_type' => esc($this->request->getPost('leave_type')),
                'leave_start_date' => $startDate,
                'leave_end_date' => $endDate,
                'reason' => esc($this->request->getPost('reason')),
                'number_of_days' => $days
            );

            $model->update($id, $data);

            $currentDate = date('D M j, Y');
            $currentTime = date('H:i A');
            log_activity("Admin updated a a leave with ID: $id on Date: $currentDate $currentTime", session()->get('id'));
            return redirect()->to('/leave')->with('message', 'Leave updated successfully.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();

        }
    }

    public function archive($id)
    {
        try {
            $model = new LeaveModel();

            // I-check kung umiiral ang record
            $leave = $model->find($id);
            if (!$leave) {
                return redirect()->back()->with('error', 'Leave record not found.');
            }

            // I-check kung naka-archive na
            if ($leave['is_archive'] == 1) {
                return redirect()->back()->with('message', 'This leave is already archived.');
            }



            // I-update ang is_archive field
            $model->update($id, ['is_archive' => 1]);

            $currentDate = date('D M j, Y');
            $currentTime = date('H:i A');
            log_activity("Admin archived a leave with ID: $id on Date: $currentDate $currentTime", session()->get('id'));

            return redirect()->to('leave')->with('message', 'Leave archived successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

}
