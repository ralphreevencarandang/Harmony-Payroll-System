<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\HolidayModel;
use App\Models\UserModel;

class HolidayController extends BaseController
{
    public function index()
    {

        try {

            $session = session();

            if (!$session->get('logged_in')) {
                // If not logged in, redirect to the login page
                return redirect()->to('/login');
            }

            $model = new HolidayModel;
            $data['holidays'] = $model->where('is_archive',0)->findAll();

            $userModel = new UserModel();
            $userId = $session->get('id');
            $data['user'] = $userModel->find($userId);

            return View('common/header', $data)
                . View('holiday', $data);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();

        }

    }


    public function addHoliday()
    {

        try {
            $model = new HolidayModel;

            
            $data = array(
                // DATABASE TABLE                           TEXTFIELD FIELD
                'holiday_title' => esc($this->request->getPost('holidayTitle')),
                'holiday_description' => esc($this->request->getPost('holidayDescription')),

                'holiday_date' => esc($this->request->getPost('holidayDate')),
                'holiday_type' => esc($this->request->getPost('holidayType')),
                'holiday_rate' => esc($this->request->getPost('holiday_rate')),

            );
            $model->save($data);
            $data['holidays'] = $model->findAll();

            $currentDate = date('D M j, Y');
            $currentTime = date('H:i A');

            log_activity("Admin added a holiday on Date: $currentDate $currentTime", session()->get('id'));

            
            return redirect()->to('/holiday')->with('message', 'Holiday added successfully.');

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
            return redirect()->to('/holiday')->with('message', 'Holiday deleted successfully');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }

    }

    public function editHoliday($id)
    {

        try {

            $session = session();
            $model = new HolidayModel;
            $userModel = new UserModel();

            $data['holidays'] = $model->where('is_archive',0)->findAll();

            $data['holiday_column'] = $model->find($id);

            
            $userId = $session->get('id');
            $data['user'] = $userModel->find($userId);

            return View('common/header', $data)
                . View('holiday', $data);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }

    }

    public function updateHoliday($id)
    {

        try {
            $model = new HolidayModel;
            
            $data = [
                'holiday_title' => esc($this->request->getPost('holidayTitle')),
                'holiday_description' => esc($this->request->getPost('holidayDescription')),
                'holiday_date' => esc($this->request->getPost('holidayDate')),
                'holiday_type' => esc($this->request->getPost('holidayType')),
                'holiday_rate' => esc($this->request->getPost('holiday_rate')),
            ];

            $model->update($id, $data);

            $currentDate = date('D M j, Y');
            $currentTime = date('H:i A');
            log_activity("Admin updated a holiday with ID: $id on Date: $currentDate $currentTime", session()->get('id'));


            return redirect()->to('holiday')->with('message', 'Updated Successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }

    }

    public function archive($id)
    {
        try{
            $holidayModel = new HolidayModel();
        // Update the is_archive flag to 1
        $holidayModel->update($id, ['is_archive' => 1]);

        $currentDate = date('D M j, Y');
        $currentTime = date('H:i A');
        log_activity("Admin archive a Holiday with ID: $id on Date: $currentDate $currentTime", session()->get('id'));

        return redirect()->to('holiday')->with('message', 'Holiday archived successfully.');

        }catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();

        }
        
    }

}
