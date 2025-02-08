<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;
class LoginController extends BaseController
{
    
    public function index()
    {
        return View('/login');
    }

    public function authenticate()
    {
        
        try {
            date_default_timezone_set('Asia/Manila');
            $session = session();
            $userModel = new UserModel();

            $username = esc($this->request->getPost('username'));
            $password = esc($this->request->getPost('password'));

            $user = $userModel->getUserByUsername($username);

            if ($user) {
                if (password_verify($password, $user['password'])) {
                    // Get the user's IP address
                    $ipAddress = $this->request->getIPAddress();

                    // Update last login time and store IP address
                    $userModel->update($user['id'], [
                        'last_login' => date('Y-m-d H:i:s'),
                        'ipaddress' => $ipAddress  // Store IP address
                    ]);

                    // Set session data
                    $sessionData = [
                        'id' => $user['id'],
                        'username' => $user['username'],
                        'logged_in' => true,
                    ];
                    $session->set($sessionData);

                    return redirect()->to('/dashboard')->with('message', $user['username']);
                } else {
                    $session->setFlashdata('error', 'Invalid Password');
                    return redirect()->to('/login');
                }
            } else {
                $session->setFlashdata('error', 'User not found');
                return redirect()->to('/login');
            }

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/login');

    }
}
