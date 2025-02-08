<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DepartmentModel;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;
use App\Models\EmployeeModel;
use App\Models\PositionModel;
use App\Models\HolidayModel;
use App\Models\AttendanceModel;

class UserController extends BaseController
{
    public function index()
    {
        try {
            date_default_timezone_set('Asia/Manila');


            $model = new UserModel();
            $employeeModel = new EmployeeModel();
            $departmentModel = new DepartmentModel();
            $positionModel = new PositionModel();
            $holidayModel = new HolidayModel();
            $attendanceModel = new AttendanceModel();
            $session = session();

            if (!$session->get('logged_in')) {
                // If not logged in, redirect to the login page
                return redirect()->to('/login');
            }
            $userId = $session->get('id');
            $data['user'] = $model->find($userId);
            $data['employee'] = $employeeModel->countAll();
            $data['deparment'] = $departmentModel->countAll();
            $data['position'] = $positionModel->countAll();
            $data['holiday'] = $holidayModel->countAll();

            // Get today's date
            $today = date('Y-m-d');

            // Query to count attendance records for today
            $totalAttendance = $attendanceModel->where('date', $today)->countAllResults();

            // Query to count the number of employees who are late today
            $data['late_today'] = $attendanceModel->where('date', $today)
                ->where('late_hours >', 0)
                ->countAllResults();

            $data['ontime_today'] = $attendanceModel->where('date', $today)
                ->where('late_hours <=', 0)
                ->countAllResults();
                
            $lateCount = $data['late_today'];
            $onTimeCount = $data['ontime_today'];

            // Calculate percentages safely to avoid division by zero
            $data['late_percentage'] = ($totalAttendance > 0) ? ($lateCount / $totalAttendance) * 100 : 0;
            $data['ontime_percentage'] = ($totalAttendance > 0) ? ($onTimeCount / $totalAttendance) * 100 : 0;





            return View('common/header', $data)
                . view('dashboard', $data);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();

        }
    }








    public function payslip()
    {
        $session = session();
        $userModel = new UserModel();
        $userId = $session->get('id');
        $data['user'] = $userModel->find($userId);
        return View('common/header', $data)
            . View('payslip');
    }
    public function addLoan()
    {
        $session = session();


        $model = new UserModel();

        $userId = $session->get('id');
        $data['user'] = $model->find($userId);
        return View('common/header', $data)
            . View('addLoan');
    }
    public function activityLog()
    {
        return View('common/header')
            . View('activityLog');
    }

    public function payeesList()
    {
        $session = session();
        $model = new UserModel();

        $userId = $session->get('id');
        $data['user'] = $model->find($userId);
        return View('common/header', $data)
            . View('payeesList', $data);
    }
    public function paysummary()
    {

        $session = session();
        $model = new UserModel();

        $userId = $session->get('id');
        $data['user'] = $model->find($userId);
        return View('common/header', $data)
            . View('paysummary', $data);
    }

    public function contributionForm()
    {

        $session = session();
        $userModel = new UserModel();
        $userId = $session->get('id');
        $data['user'] = $userModel->find($userId);
        return View('common/header', $data)
            . View('contributionForm');
    }

}
