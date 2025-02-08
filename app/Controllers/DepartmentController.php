<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\DepartmentModel;
use \App\Models\ActivityLogModel;
use \App\Models\UserModel;

class DepartmentController extends BaseController
{
    public function index()
    {

        try {

            $session = session();

            if (!$session->get('logged_in')) {
                // If not logged in, redirect to the login page
                return redirect()->to('/login');
            }

            $model = new DepartmentModel;
           
            $data['departments'] = $model->where('is_archive', 0)->findAll();

            $userModel = new UserModel();
            $userId = $session->get('id');
            $data['user'] = $userModel->find($userId);

            return View('common/header', $data)
                . View('department', $data);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();

        }

    }

    public function addDepartment()
    {

        try {
            $model = new DepartmentModel;
            $data = array(
                // DATABASE TABLE                           TEXTFIELD FIELD
                'department_name' => esc($this->request->getPost('department_name')),
                'description' => esc($this->request->getPost('department_description'))

            );

            $model->save($data);
            $currentDate = date('D M j, Y');
            $currentTime = date('H:i A');


            $data['departments'] = $model->findAll();

            log_activity("Admin added a department on Date: $currentDate $currentTime", session()->get('id'));


            return redirect()->to('/department')->with('message', 'Department added successfully!');

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

            return redirect()->to('/department')->with('message', 'Department deleted successfully!');


        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }

    }

    public function editDepartment($id)
    {

        try {

           
            $model = new DepartmentModel;
            $data['departments'] = $model->findAll();

            $data['department_column'] = $model->find($id);

            $session = session();
            $userModel = new UserModel();
            $userId = $session->get('id');
            $data['user'] = $userModel->find($userId);

            return View('common/header', $data)
                . View('department', $data);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }

    }

    public function updateDepartment($id)
    {

        try {
            $model = new DepartmentModel;
            $data = array(
                // DATABASE TABLE                           TEXTFIELD FIELD
                'department_name' => esc($this->request->getPost('department_name')),
                'description' => esc($this->request->getPost('department_description'))

            );

            $model->update($id, $data);

            $currentDate = date('D M j, Y');
            $currentTime = date('H:i A');
            log_activity("Admin updated a department with ID: $id on Date: $currentDate $currentTime", session()->get('id'));
            return redirect()->to('department')->with('message', 'Departement Updated Successfully');


        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function archive($id)
    {

        try{

            $departmentModel = new DepartmentModel();
            // Update the is_archive flag to 1
            $departmentModel->update($id, ['is_archive' => 1]);
    
             $currentDate = date('D M j, Y');
            $currentTime = date('H:i A');
            log_activity("Admin archive a Department with ID: $id on Date: $currentDate $currentTime", session()->get('id'));
            return redirect()->to('department')->with('message', 'Department archived successfully.');

        }catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
       
    }






}
