<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\PayheadModel;
use App\Models\ManualPayheadModel;

use App\Models\UserModel;
use App\Models\EmployeeModel;
use App\Models\EmployeePayheadModel;
use App\Models\EmployeeManualPayheadModel;
use App\Models\ContributionTypeListModel;
class PayheadController extends BaseController
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

            $model = new PayheadModel();
            $data['payheads'] = $model->where('is_archive', 0)->findAll();

            return view('common/header', $data)
                . view('payhead', $data);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();

        }

    }


    public function addPayhead()
    {
        try {
            $model = new PayheadModel();
            $data = array(
                'payhead_name' => esc($this->request->getPost('payheadName')),
                'description' => esc($this->request->getPost('payheadDescription')),
                'amount' => esc($this->request->getPost('payheadAmount')),
                'payhead_type' => esc($this->request->getPost('payheadType'))
            );

            $model->save($data);


            $newPayheadId = $model->insertID(); // Get the ID of the newly added payhead

            // Assign the new payhead to all employees
            $this->assignNewPayheadToAllEmployees($newPayheadId);

            $currentDate = date('D M j, Y');
            $currentTime = date('H:i A');
            log_activity("Admin added a Automatic payhead on Date: $currentDate $currentTime", session()->get('id'));

            return redirect()->to('/payhead')->with('message', 'Payhead added successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();

        }

    }

    public function deletePayhead($id)
    {

        try {
            $payheadModel = new PayheadModel();
            $employeePayheadModel = new EmployeePayheadModel();

            // Check if the payhead exists
            $payhead = $payheadModel->find($id);
            if (!$payhead) {
                return redirect()->back()->with('error', 'Payhead not found.');
            }

            // Delete associated records in tbl_employee_payhead
            $employeePayheadModel->where('payhead_id', $id)->delete();

            $payheadModel->delete($id);

            $currentDate = date('D M j, Y');
            $currentTime = date('H:i A');
            log_activity("Admin deleted a payhead with ID: $id on Date: $currentDate $currentTime", session()->get('id'));

            return redirect()->to('/payhead')->with('message', 'Payhead deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();

        }


    }

    public function editPayhead($id)
    {

        try {
            $session = session();
            $model = new PayheadModel();
            $data['payheads'] = $model->where('is_archive', 0)->findAll();
            $data['payhead_column'] = $model->find($id);


            $userModel = new UserModel();
            $userId = $session->get('id');
            $data['user'] = $userModel->find($userId);

            return view('common/header', $data)
                . view('payhead', $data);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();

        }

    }

    public function updatePayhead($id)
    {
        try {
            $model = new PayheadModel();
            $data = array(
                'payhead_name' => esc($this->request->getPost('payheadName')),
                'description' => esc($this->request->getPost('payheadDescription')),
                'amount' => esc($this->request->getPost('payheadAmount')),
                'payhead_type' => esc($this->request->getPost('payheadType'))
            );



            $model->update($id, $data);

            $currentDate = date('D M j, Y');
            $currentTime = date('H:i A');
            log_activity("Admin updated a payhead with ID: $id on Date: $currentDate $currentTime", session()->get('id'));
            return redirect()->to('/payhead')->with('message', 'Payhead updated successfully.');



        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();

        }
    }

    public function archive($id)
    {
        try {
            $payheadModel = new PayheadModel();
            // Update the is_archive flag to 1
            $payheadModel->update($id, ['is_archive' => 1]);

            $currentDate = date('D M j, Y');
            $currentTime = date('H:i A');
            log_activity("Admin Payhead a Department with ID: $id on Date: $currentDate $currentTime", session()->get('id'));

            return redirect()->to('payhead')->with('message', 'Payhead archived successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();

        }
    }

    public function assignPayhead()
    {
        try {

            $session = session();

            if (!$session->get('logged_in')) {
                // If not logged in, redirect to the login page
                return redirect()->to('/login');
            }


            $userModel = new UserModel();
            $payheadModel = new PayheadModel();
            $manualPayheadModel = new ManualPayheadModel();
            $employeeModel = new EmployeeModel();


            $userId = $session->get('id');
            $data['user'] = $userModel->find($userId);

            $data['employees'] = $employeeModel
                ->select('tbl_employee.*, tbl_department.department_name, tbl_position.position_name')
                ->join('tbl_department', 'tbl_department.department_id = tbl_employee.department_id')
                ->join('tbl_position', 'tbl_position.position_id = tbl_employee.position_id')
                ->where('tbl_employee.is_archive', 0)
                ->findAll();

            $data['payheads'] = $payheadModel->where('is_archive', 0)->findAll();
            $data['manual_payheads'] = $manualPayheadModel->where('is_archive', 0)->findAll();



            return view('common/header', $data)
                . view('assign_payhead', $data);



        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();

        }
    }


    public function setPayhead($id)
    {
        try {
            $userModel = new UserModel();
            $employeeModel = new EmployeeModel();
            $payheadModel = new PayheadModel();
            $manualPayheadModel = new ManualPayheadModel();
            $employeeManualPayheadModel = new EmployeeManualPayheadModel();
            $contributionModel = new ContributionTypeListModel();
            $session = session();


            if (!$session->get('logged_in')) {
                // If not logged in, redirect to the login page
                return redirect()->to('/login');
            }

            $userId = $session->get('id');
            $data['user'] = $userModel->find($userId);
            $data['payheads'] = $payheadModel->where('is_archive', 0)->findAll();
            $data['manual_payheads'] = $manualPayheadModel->where('is_archive', 0)->findAll();
            $data['employees'] = $employeeModel
                ->select('tbl_employee.*, tbl_department.department_name, tbl_position.position_name')
                ->join('tbl_department', 'tbl_department.department_id = tbl_employee.department_id')
                ->join('tbl_position', 'tbl_position.position_id = tbl_employee.position_id')
                ->where('tbl_employee.is_archive', 0)
                ->findAll();


            // Fetch specific employee based on employee_id
            $data['employees_column'] = $employeeModel
                ->select('tbl_employee.*, tbl_department.department_name, tbl_position.position_name')
                ->join('tbl_department', 'tbl_department.department_id = tbl_employee.department_id')
                ->join('tbl_position', 'tbl_position.position_id = tbl_employee.position_id')
                ->where('tbl_employee.employee_id', $id) // Match employee_id column
                ->first();

            if (!$data['employees_column']) {
                return redirect()->to('/assign_payhead')->with('error', 'Employee not found.');
            }

            $data['assigned_payheads'] = $employeeManualPayheadModel
                ->select('tbl_employee_manual_payhead.*, manual_payhead.payhead_name, manual_payhead.head_type')
                ->join('manual_payhead', 'manual_payhead.manual_payhead_id = tbl_employee_manual_payhead.manual_payhead_id')
                ->where('tbl_employee_manual_payhead.employee_id', $id)
                ->findAll();

            $data['contributions'] = $contributionModel->where('employee_id', $id)->findAll();

            return view('common/header', $data)
                . view('assign_payhead', $data);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }


    public function saveManualPayheads($employeeId)
    {
        try {
            $employeeManualPayheadModel = new EmployeeManualPayheadModel();
            $manualPayheadModel = new ManualPayheadModel();

            $payheadIds = $this->request->getPost('payhead');  // Array of payhead IDs
            $payheadAmounts = $this->request->getPost('payhead_amount');  // Array of amounts

            // Check if there are payheads selected
            if (empty($payheadIds)) {
                return redirect()->back()->with('error', 'No payheads selected.');
            }

            // Ensure amounts are provided and valid
            foreach ($payheadAmounts as $amount) {
                if (trim($amount) === '' || !is_numeric($amount)) {
                    return redirect()->back()->with('error', 'All payhead amounts must be filled in and valid.');
                }
            }

            // Ensure amounts are provided for all selected payheads
            if (!is_array($payheadAmounts) || count($payheadAmounts) !== count($payheadIds)) {
                return redirect()->back()->with('error', 'Please provide amounts for all selected payheads.');
            }

            // Iterate over selected payheads and handle insert/update
            foreach ($payheadIds as $index => $payheadId) {
                $payhead = $manualPayheadModel->find($payheadId);
                if ($payhead) {
                    // Check if the record already exists
                    $existingRecord = $employeeManualPayheadModel
                        ->where('employee_id', $employeeId)
                        ->where('manual_payhead_id', $payheadId)
                        ->first();

                    $data = [
                        'employee_id' => $employeeId,   // Employee ID
                        'manual_payhead_id' => $payheadId, // Manual payhead ID
                        'amount' => $payheadAmounts[$index], // Amount entered
                    ];

                    if ($existingRecord) {
                        // Update the existing record
                        $employeeManualPayheadModel->update($existingRecord['id'], $data);
                    } else {
                        // Insert new record
                        $employeeManualPayheadModel->save($data);
                    }
                }
            }

            // Log activity
            $currentDate = date('D M j, Y');
            $currentTime = date('H:i A');
            log_activity("Admin assigned/updated manual payheads to employee with ID: $employeeId on Date: $currentDate $currentTime", session()->get('id'));

            return redirect()->to('/assignPayhead')->with('message', 'Manual payheads assigned/updated successfully.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }




    // Assigning Default Payhead to All Employee
    protected function assignNewPayheadToAllEmployees($payheadId)
    {
        $employeeModel = new EmployeeModel();
        $employeePayheadModel = new EmployeePayheadModel();

        // Get all employees
        $employees = $employeeModel->findAll();

        foreach ($employees as $employee) {
            $data = [
                'employee_id' => $employee['employee_id'],
                'payhead_id' => $payheadId,
            ];
            $employeePayheadModel->insert($data);
        }
    }


    public function deleteManualPayheadInList($employee_id,$manualPayheadId)
    {
        try {

            // Debugging the request method
            log_message('debug', 'Request Method: ' . $this->request->getMethod());

            // if ($this->request->getMethod() !== 'delete') {
            //     return $this->response->setJSON([
            //         'status' => 'error',
            //         'message' => 'Invalid request method.'
            //     ]);
            // }
            $model = new EmployeeManualPayheadModel();
            $result = $model->delete($manualPayheadId);

            if ($result) {
                log_message('info', "Deleted manual payhead with ID: {$manualPayheadId}");
                return $this->response->setJSON(['status' => 'success', 'message' => 'Payhead deleted successfully.']);
            } else {
                log_message('error', "Failed to delete manual payhead with ID: {$manualPayheadId}");
                return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to delete payhead.']);
            }
            

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();

        }

    }












}
