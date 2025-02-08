<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ActivityLogModel;
use App\Models\UserModel;

class ActivityLogController extends BaseController
{
    public function index()
    {

        try{
            $session = session();

            if (!$session->get('logged_in')) {
                // If not logged in, redirect to the login page
                return redirect()->to('/login');
            }
            $activityLogModel = new ActivityLogModel();
            $data['logs'] = $activityLogModel->orderBy('created_at', 'DESC')->findAll();

            $userModel = new UserModel();
            $userId = $session->get('id');
            $data['user'] = $userModel->find($userId);
    
            return view('common/header', $data)
            . view('activityLog', $data);

        }catch (\Exception $e) {

            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
       

    }
}
