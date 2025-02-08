<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\DepartmentModel;
use App\Models\PositionModel;
use App\Models\UserModel;

class PositionController extends BaseController
{
    public function index()
    {
        try {

            $session = session();

            if (!$session->get('logged_in')) {
                // If not logged in, redirect to the login page
                return redirect()->to('/login');
            }

            $positionModel = new PositionModel();
            $departmentModel = new DepartmentModel();
            $userModel = new UserModel();
            $userId = $session->get('id');
            $data['user'] = $userModel->find($userId);

            $data['departments'] = $departmentModel->where('is_archive', 0)->findAll();

            $data['positions'] = $positionModel
                ->select('tbl_position.*, tbl_department.department_name')
                ->join('tbl_department', 'tbl_department.department_id = tbl_position.department_id')
                ->where('tbl_position.is_archive', 0)
                ->findAll();

            return view('common/header', $data)
                . view('position', $data);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }

    }

    public function addPosition()
    {

        try {
            $model = new PositionModel();
            $departmentModel = new DepartmentModel();

            $data = array(
                'position_name' => esc($this->request->getPost('position_name')),
                'position_description' => esc($this->request->getPost('position_description')),
                'department_id' => esc($this->request->getPost('department'))
            );

            $model->save($data);
            $data['departments'] = $departmentModel->findAll();
            $data['positions'] = $model->findAll();


            $currentDate = date('D M j, Y');
            $currentTime = date('H:i A');
            log_activity("Admin added a position on Date: $currentDate $currentTime", session()->get('id'));

            return redirect()->to('/position')->with('message', 'Position inserted successfully!');


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

            return redirect()->to('/position')->with('message', 'Position deleted successfully!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }


    }

    public function editPosition($id)
    {
        try {
            $departmentModel = new DepartmentModel();
            $positionModel = new PositionModel();
            $data['departments'] = $departmentModel->findAll();
            $data['position_column'] = $positionModel->find($id);
            $data['positions'] = $positionModel
                ->select('tbl_position.*, tbl_department.department_name')
                ->join('tbl_department', 'tbl_department.department_id = tbl_position.department_id')
                ->where('tbl_position.is_archive', 0)
                ->findAll();


            $session = session();
            $userModel = new UserModel();
            $userId = $session->get('id');
            $data['user'] = $userModel->find($userId);

            return view('common/header', $data)
                . view('position', $data);


        } catch (\Exception $e) {

            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function updatePosition($id)
    {

        try {
            $departmentModel = new DepartmentModel();
            $positionModel = new PositionModel();

            $data = array(
                'position_name' => esc($this->request->getPost('position_name')),
                'position_description' => esc($this->request->getPost('position_description')),
                'department_id' => esc($this->request->getPost('department'))
            );

            $positionModel->update($id, $data);

            $currentDate = date('D M j, Y');
            $currentTime = date('H:i A');
            log_activity("Admin updated a position with ID: $id on Date: $currentDate $currentTime", session()->get('id'));

            return redirect()->to('/position')->with('message', 'Position updated successfully!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();

        }

    }

    public function archive($id)
    {
        try {
            $positionModel = new PositionModel();
            // Update the is_archive flag to 1
            $positionModel->update($id, ['is_archive' => 1]);

            $currentDate = date('D M j, Y');
            $currentTime = date('H:i A');
            log_activity("Admin archive a Position with ID: $id on Date: $currentDate $currentTime", session()->get('id'));

            return redirect()->to('position')->with('message', 'Position archived successfully.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();

        }

    }


}
