<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;

class SettingsController extends BaseController
{
    public function index()
    {


        $session = session();

        if (!$session->get('logged_in')) {
            // If not logged in, redirect to the login page
            return redirect()->to('/login');
        }

        $model = new UserModel();
        $userId = $session->get('id');
        $data['user'] = $model->find($userId);
        return view('common/header', $data)
            . view('settings', $data);
    }

    public function updateProfile()
    {

        try {
            $session = session();
            $userId = $session->get('id');

            $model = new UserModel();

            $profileImage = $this->request->getFile('profileImage');

           
            if ($profileImage->isValid() && !$profileImage->hasMoved()) {
                $imageName = $profileImage->getRandomName();
                $profileImage->move('uploads/', $imageName);
            }


            $data = array(
                'image' => $imageName,
            );

            $model->update($userId, $data);
            return redirect()->to('settings')->with('message', 'Image Updated Successfully!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', "Please select an Image")->withInput();
        }

    }

    public function updateAccount()
    {
        try {
            $model = new UserModel();
            $session = session();
            $userId = $session->get('id');
            $user = $model->find($userId);

            $confirm_password = $this->request->getPost('confirm_password');
            $new_password = $this->request->getPost('new_password');
            $current_password = $this->request->getPost('current_password');
            $userId = $session->get('id');
            $username = $this->request->getPost('username');
            
            if(empty($username)){
                return redirect()->to('settings')->with('error', 'Username should not be empty!');

            }else if(empty($current_password)){
                return redirect()->to('settings')->with('error', 'Current password should not be empty!');

            }else if(empty($new_password)){
                return redirect()->to('settings')->with('error', 'New password should not be empty!');

            }else if(empty($confirm_password)){
                return redirect()->to('settings')->with('error', 'Please Confirm your password!');

            }
            else if ($confirm_password != $new_password) {
                return redirect()->to('settings')->with('error', 'Password does not match!');
            } else if (!password_verify($current_password, $user['password'])) {
               
                return redirect()->back()->with('error', 'Current password is incorrect.');
            } else {
                $hashedPassword = password_hash($new_password, PASSWORD_DEFAULT);
                $data = array(
                    'password' => $hashedPassword,
                    'username' => $this->request->getPost('username'),
                );

                $model->update($userId, $data);

                $currentDate = date('D M j, Y');
                $currentTime = date('H:i A');
                log_activity("Admin update account on Date: $currentDate $currentTime", session()->get('id'));
                return redirect()->to('settings')->with('message', 'Account Updated Successfully!');

            }



        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }
}
