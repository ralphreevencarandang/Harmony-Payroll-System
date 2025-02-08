<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ManualPayheadModel;
use App\Models\UserModel;

class ManualPayheadController extends BaseController
{
    public function index()
    {
        try {

            $session = session();

            if (!$session->get('logged_in')) {
                // If not logged in, redirect to the login page
                return redirect()->to('/login');
            }


            $userModel = new UserModel();
            $userId = $session->get('id');
            $data['user'] = $userModel->find($userId);

            $model = new ManualPayheadModel();
            $data['payheads'] = $model->where('is_archive', 0)->findAll();

            return view('common/header', $data)
                . view('manual_payhead', $data);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();

        }

    }

    public function addManualPayhead()
    {
        try {

            $model = new ManualPayheadModel();

            $data = array(
                'payhead_name' => esc($this->request->getPost('payheadName')),
                'head_type' => esc($this->request->getPost('payheadType')),
            );

            $model->save($data);
            $currentDate = date('D M j, Y');
            $currentTime = date('H:i A');
            log_activity("Admin added a manual payhead on Date: $currentDate $currentTime", session()->get('id'));
            return redirect()->to('/manual_payhead')->with('message', 'Payhead updated successfully.');

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
            log_activity("Admin deleted a manual payhead on Date: $currentDate $currentTime", session()->get('id'));
            return redirect()->to('/manual_payhead')->with('message', 'Payhead deleted successfully.');


        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();

        }
    }

    public function editManualPayhead($id){

        try{
            $model = new ManualPayheadModel();

            $session = session();

            if (!$session->get('logged_in')) {
                // If not logged in, redirect to the login page
                return redirect()->to('/login');
            }


            $userModel = new UserModel();
            $userId = $session->get('id');
            $data['user'] = $userModel->find($userId);

            $model = new ManualPayheadModel();
            $data['payheads'] = $model->where('is_archive', 0)->findAll();
            $data['payhead_column'] = $model->find($id);

            return view('common/header',$data)
            . view('manual_payhead');

        }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage())->withInput();

        }

    }

    public function updateManualPayhead($id){

        try{

            $model = new ManualPayheadModel();

            $data = array(
                'payhead_name' => esc($this->request->getPost('payheadName')),
                'head_type' => esc($this->request->getPost('payheadType')),
            );

            $model->update($id,$data);

            $currentDate = date('D M j, Y');
            $currentTime = date('H:i A');
            log_activity("Admin updated a payhead with ID: $id on Date: $currentDate $currentTime", session()->get('id'));
            return redirect()->to('/manual_payhead')->with('message', 'Payhead updated successfully');

        }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function archive($id)
    {
        try {
            $model = new ManualPayheadModel();
            // Update the is_archive flag to 1
            $model->update($id, ['is_archive' => 1]);

            $currentDate = date('D M j, Y');
            $currentTime = date('H:i A');
            log_activity("Admin Payhead a Department with ID: $id on Date: $currentDate $currentTime", session()->get('id'));

            return redirect()->to('manual_payhead')->with('message', 'Payhead archived successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();

        }
    }


}
