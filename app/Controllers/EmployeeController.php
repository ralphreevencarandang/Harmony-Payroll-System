<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\RegionModel;
use App\Models\ProvinceModel;
use App\Models\MunicipalityModel;
use App\Models\BarangayModel;
use App\Models\EmployeeModel;
use App\Models\PositionModel;
use App\Models\DepartmentModel;
use App\Models\UserModel;
use App\Models\ContributionTypeListModel;
use App\Models\SSSModel;
use App\Models\PagibigModel;
use App\Models\PayheadModel;
use App\Models\PhilhealthModel;
use App\Models\EmployeePayheadModel;




class EmployeeController extends BaseController
{
    public function index()
    {

        try {
            $session = session();
            $model = new UserModel();

            if (!$session->get('logged_in')) {
                // If not logged in, redirect to the login page
                return redirect()->to('/login');
            }
            $userId = $session->get('id');
            $data['user'] = $model->find($userId);

            $regionModel = new RegionModel();
            $departmentModel = new DepartmentModel();
            $data['departments'] = $departmentModel->where('is_archive', 0)->findAll();
            $data['regions'] = $regionModel->findAll();

            return view('common/header', $data)
                . view('employeeForm', $data);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();

        }


    }

    public function payEmployee()
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

            $model = new EmployeeModel();
            $data['employees'] = $model
                ->select('tbl_employee.*, tbl_department.department_name, tbl_position.position_name')
                ->join('tbl_department', 'tbl_department.department_id = tbl_employee.department_id')
                ->join('tbl_position', 'tbl_position.position_id = tbl_employee.position_id')
                ->where('tbl_employee.is_archive', 0)
                ->findAll();

            return view('common/header', $data)
                . view('pay_employee', $data);



        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();

        }

    }

    public function manageEmployee()
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

            $model = new EmployeeModel();
            $data['employees'] = $model
                ->select('tbl_employee.*, tbl_department.department_name, tbl_position.position_name')
                ->join('tbl_department', 'tbl_department.department_id = tbl_employee.department_id')
                ->join('tbl_position', 'tbl_position.position_id = tbl_employee.position_id')
                ->where('tbl_employee.is_archive', 0)
                ->findAll();

            return view('common/header', $data)
                . view('manageEmployee', $data);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();

        }

    }

    public function viewEmployee($id)
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

            $model = new EmployeeModel();
            $data['employee'] = $model
                ->select('tbl_employee.*, tbl_department.department_name, tbl_position.position_name, refregion.regDesc, refprovince.provDesc, refcitymun.citymunDesc, refbrgy.brgyDesc')
                ->join('tbl_department', 'tbl_department.department_id = tbl_employee.department_id')
                ->join('tbl_position', 'tbl_position.position_id = tbl_employee.position_id')
                ->join('refregion', 'refregion.regCode = tbl_employee.region_id')
                ->join('refprovince', 'refprovince.provCode = tbl_employee.province_id')
                ->join('refcitymun', 'refcitymun.citymunCode = tbl_employee.municipality_id')
                ->join('refbrgy', 'refbrgy.id = tbl_employee.barangay_id')
                ->find(id: $id);
            return view('common/header', $data)
                . view('viewEmployee', $data);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();

        }


    }

    public function getProvinces()
    {
        $provinceModel = new ProvinceModel();
        $regCode = $this->request->getVar('regCode');
        $provinces = $provinceModel->where('regCode', $regCode)->findAll();
        return $this->response->setJSON($provinces);

    }

    public function getMunicipalities()
    {
        $municipalityModel = new MunicipalityModel();
        $provCode = $this->request->getVar('provCode');
        $municipalities = $municipalityModel->where('provCode', $provCode)->findAll();
        return $this->response->setJSON($municipalities);
    }

    public function getBarangays()
    {
        $barangayModel = new BarangayModel();
        $citymunCode = $this->request->getVar('citymunCode');
        $barangays = $barangayModel->where('citymunCode', $citymunCode)->findAll();
        return $this->response->setJSON($barangays);
    }

    public function getPosition()
    {
        $positionModel = new PositionModel();
        $department_id = $this->request->getVar('department_id');
        $positions = $positionModel->where('department_id', $department_id)
            ->where('is_archive', 0)
            ->findAll();
        return $this->response->setJSON($positions);
    }

    public function addEmployee()
    {

        try {
            $profileImage = $this->request->getFile('profileImage');
            if ($profileImage->isValid() && !$profileImage->hasMoved()) {
                $imageName = $profileImage->getRandomName();
                $profileImage->move('uploads/', $imageName);
            }
            $model = new EmployeeModel();
            $year = date('Y');
            $randomNumber = random_int(100000, 999999);
            $employeeId = "$year-$randomNumber";

            $data = array(
                'employee_id' => $employeeId,
                'rfid_uid' => esc($this->request->getPost('rfid_uid')),
                'firstname' => esc($this->request->getPost('firstname')),
                'middlename' => esc($this->request->getPost('middlename')),
                'lastname' => esc($this->request->getPost(index: 'lastname')),
                'email' => esc($this->request->getPost('email')),
                'sex' => esc($this->request->getPost('sex')),
                'birthdate' => esc($this->request->getPost('birthdate')),
                'region_id' => esc($this->request->getPost('region')),
                'province_id' => esc($this->request->getPost('province')),
                'municipality_id' => esc($this->request->getPost('municipality')),
                'barangay_id' => esc($this->request->getPost('barangay')),
                'street' => esc($this->request->getPost('street')),
                'phonenumber' => esc($this->request->getPost('phonenumber')),
                'department_id' => esc($this->request->getPost('department')),
                'position_id' => esc($this->request->getPost('position')),
                'daily_rate' => esc($this->request->getPost('daily_rate')),
                'monthly_rate' => esc($this->request->getPost('monthly_rate')),
                'date_hired' => esc($this->request->getPost('date_hired')),
                'restday' => esc($this->request->getPost('restday')),
                'time_in' => esc($this->request->getPost('time_in')),
                'time_out' => esc($this->request->getPost('time_out')),
                'status' => esc($this->request->getPost('status')),
                'pagibig_account_number' => esc($this->request->getPost('pagibig')),
                'sss_account_number' => esc($this->request->getPost('sss')),
                'philhealth_account_number' => esc($this->request->getPost('philhealth')),
                'image' => $imageName,
            );
            $model->save($data);

            // SAVING THE SSS DATA IN CONTRIBUTION
            $this->addSSSContribution($employeeId, $data['monthly_rate'], 'SSS');
            $this->addPagibigContribution($employeeId, $data['monthly_rate'], 'Pag Ibig');
            $this->addPhilhealthContribution($employeeId, $data['monthly_rate'], 'Philhealth');

            // Assign default payheads to the new employee
            $this->assignPayheadsToEmployee($employeeId);




            $currentDate = date('D M j, Y');
            $currentTime = date('H:i A');
            log_activity("Admin added a employee on Date: $currentDate $currentTime", session()->get('id'));
            return redirect()->to('/manageEmployee')->with('message', 'Employee added successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function deleteEmployee($id)
    {
        try {

            $model = new EmployeeModel();



            $employee = $model->find($id);

            // Check if the employee exists
            if ($employee) {
                // Get the employee's employee_id
                $employeeId = $employee['employee_id']; // Assuming 'employee_id' is the column name in the DB
            } else {
                return redirect()->back()->with('error', 'Employee not found.');
            }

            $model->delete($id);


            $currentDate = date('D M j, Y');
            $currentTime = date('H:i A');
            log_activity("Admin deleted a employee with ID: $employeeId on Date: $currentDate $currentTime", session()->get('id'));

            return redirect()->to('manageEmployee')->with('message', 'Employee deleted successully.');



        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function editEmployee($id)
    {
        try {
            $session = session();
            $model = new EmployeeModel();
            $regionModel = new RegionModel();
            $provinceModel = new ProvinceModel();
            $municipalityModel = new MunicipalityModel();
            $barangayModel = new BarangayModel();
            $departmentModel = new DepartmentModel();
            $postionModel = new PositionModel();

            $employee = $model->find($id);

            $userModel = new UserModel();

            $userId = $session->get('id');
            $data['user'] = $userModel->find($userId);

            // Fetch region, department and other required data
            $data['departments'] = $departmentModel->findAll();
            $data['positions'] = $postionModel->findAll();
            $data['regions'] = $regionModel->findAll();
            $data['employee'] = $employee;

            // Fetch provinces, municipalities, and barangays based on the employee's saved data
            $data['provinces'] = $provinceModel->where('regCode', $employee['region_id'])->findAll();
            $data['municipalities'] = $municipalityModel->where('provCode', $employee['province_id'])->findAll();
            $data['barangays'] = $barangayModel->where('citymunCode', $employee['municipality_id'])->findAll();



            return view('common/header', $data)
                . view('editEmployee', $data);


        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function updateEmployee($id)
    {

        try {
            $model = new EmployeeModel();

            $employeeId = $this->request->getPost('employee_id');
            $monthlyRate = esc($this->request->getPost('monthly_rate'));
            $employee = $model->find($id);
            // Check if the employee exists
            if ($employee) {
                // Get the employee's employee_id
                $employeeId = $employee['employee_id']; // Assuming 'employee_id' is the column name in the DB
            } else {
                return redirect()->back()->with('error', 'Employee not found.');
            }


            $profileImage = $this->request->getFile('profileImage');

            if ($profileImage && $profileImage->isValid() && !$profileImage->hasMoved()) {
                $imageName = $profileImage->getRandomName();
                $profileImage->move('uploads/', $imageName);
            } else {
                $imageName = $employee['image']; // Retain the existing image if no new upload
            }


            $data = array(
                'firstname' => esc($this->request->getPost('firstname')),
                'middlename' => esc($this->request->getPost('middlename')),
                'lastname' => esc($this->request->getPost('lastname')),
                'email' => esc($this->request->getPost('email')),
                'sex' => esc($this->request->getPost('sex')),
                'birthdate' => esc($this->request->getPost('birthdate')),
                'region_id' => esc($this->request->getPost('region')),
                'province_id' => esc($this->request->getPost('province')),
                'municipality_id' => esc($this->request->getPost('municipality')),
                'barangay_id' => esc($this->request->getPost('barangay')),
                'street' => esc($this->request->getPost('street')),
                'phonenumber' => esc($this->request->getPost('phonenumber')),
                'department_id' => esc($this->request->getPost('department')),
                'position_id' => esc($this->request->getPost('position')),
                'daily_rate' => esc($this->request->getPost('daily_rate')),
                'monthly_rate' => esc($this->request->getPost('monthly_rate')),
                'date_hired' => esc($this->request->getPost('date_hired')),
                'restday' => esc($this->request->getPost('restday')),
                'time_in' => esc($this->request->getPost('time_in')),
                'time_out' => esc($this->request->getPost('time_out')),
                'status' => esc($this->request->getPost('status')),
                'pagibig_account_number' => esc($this->request->getPost('pagibig')),
                'sss_account_number' => esc($this->request->getPost('sss')),
                'philhealth_account_number' => esc($this->request->getPost('philhealth')),
                'rfid_uid' => esc($this->request->getPost('rfuid')),
                'image' => $imageName,  // Update image field with new image name

            );





            $model->update($id, $data);

            $this->updateEmployeeContributions($employeeId, $monthlyRate);


            $currentDate = date('D M j, Y');
            $currentTime = date('H:i A');
            log_activity("Admin updated a employee with ID: $employeeId on Date: $currentDate $currentTime", session()->get('id'));

            return redirect()->to('manageEmployee')->with('message', 'Employee updated successully.');



        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }

    }

    public function archive($id)
    {
        $employeeModel = new EmployeeModel();
        // Update the is_archive flag to 1
        $employeeModel->update($id, ['is_archive' => 1]);

        $employee = $employeeModel->find($id);
        $employee_id = $employee['employee_id'];
        $currentDate = date('D M j, Y');
        $currentTime = date('H:i A');
        log_activity("Admin archive a Employee with ID: $employee_id on Date: $currentDate $currentTime", session()->get('id'));

        return redirect()->to('manageEmployee')->with('message', 'Employee archived successfully.');
    }

    // ADDING A DATA IN CONTRIBUTION TABLE

    private function addSSSContribution($employeeId, $monthlyRate, $contributionName)
    {
        $sssModel = new SSSModel();
        $contributionModel = new ContributionTypeListModel();

        // Find the SSS contribution range based on the monthly rate
        $sssRange = $sssModel
            ->where('salary_range_start <=', $monthlyRate)
            ->where('salary_range_end >=', $monthlyRate)
            ->first();

        if ($sssRange) {
            $employeeShare = $sssRange['employee_share'];

            $existingContribution = $contributionModel->where('employee_id', $employeeId)
                ->where('contribution_name', $contributionName)
                ->first();


            // Save to tbl_contribution
            $contributionData = [
                'employee_id' => $employeeId,
                'contribution_name' => $contributionName,
                'contribution_amount' => $employeeShare,
                'date' => date('Y-m-d'),
            ];

            if ($existingContribution) {
                // Update existing record
                $contributionModel->update($existingContribution['id'], $contributionData);
            } else {
                // Insert new record
                $contributionModel->save($contributionData);
            }
        }
    }
    private function addPagibigContribution($employeeId, $monthlyRate, $contributionName)
    {
        $pagibigModel = new PagibigModel();
        $contributionModel = new ContributionTypeListModel();

        // Find the SSS contribution range based on the monthly rate
        $pagibigRange = $pagibigModel
            ->where('salary_range_start <=', $monthlyRate)
            ->where('salary_range_end >=', $monthlyRate)
            ->first();

        if ($pagibigRange) {
            // Calculate employee and employer shares
            $employeeShare = $monthlyRate * $pagibigRange['employee_share'];
            $employerShare = $monthlyRate * $pagibigRange['employer_share'];

            // Apply maximum contribution limits
            $employeeShare = min($employeeShare, $pagibigRange['employee_max_contribution']);
            $employerShare = min($employerShare, $pagibigRange['employer_max_contribution']);



            // Combine employee and employer shares for total contribution
            $totalContribution = $employeeShare;

            $existingContribution = $contributionModel->where('employee_id', $employeeId)
                ->where('contribution_name', $contributionName)
                ->first();

            // Save to tbl_contribution
            $contributionData = [
                'employee_id' => $employeeId,
                'contribution_name' => $contributionName,
                'contribution_amount' => $totalContribution,
                'date' => date('Y-m-d'),
            ];

            if ($existingContribution) {
                // Update existing record
                $contributionModel->update($existingContribution['id'], $contributionData);
            } else {
                // Insert new record
                $contributionModel->save($contributionData);
            }
        }
    }
    private function addPhilhealthContribution($employeeId, $monthlyRate, $contributionName)
    {
        $philhealthModel = new PhilhealthModel();
        $contributionModel = new ContributionTypeListModel();

        // Define the caps for contribution
        $lowSalaryCap = 500;  // For salaries <= 10,000
        $highSalaryCap = 5000; // For salaries > 100,000

        // Calculate contribution based on salary range
        if ($monthlyRate <= 10000) {
            $totalContribution = $lowSalaryCap / 2;  // Fixed contribution for salary <= 10,000
        } elseif ($monthlyRate > 100000) {
            $totalContribution = $highSalaryCap / 2;  // Fixed contribution for salary > 100,000
        } else {
            // Find the PhilHealth contribution range based on the monthly rate
            $philhealthRange = $philhealthModel
                ->where('salary_range_start <=', $monthlyRate)
                ->where('salary_range_end >=', $monthlyRate)
                ->first();

            if ($philhealthRange) {
                // Calculate the total contribution using the rate from the range
                $rate = $philhealthRange['rate'];

                // Split the contribution between employee and employer
                $totalContribution = ($monthlyRate * $rate) / 2;
            }
        }
        $existingContribution = $contributionModel->where('employee_id', $employeeId)
            ->where('contribution_name', $contributionName)
            ->first();

        // Save to tbl_contribution
        $contributionData = [
            'employee_id' => $employeeId,
            'contribution_name' => $contributionName,
            'contribution_amount' => $totalContribution,
            'date' => date('Y-m-d'),
        ];

        if ($existingContribution) {
            // Update existing record
            $contributionModel->update($existingContribution['id'], $contributionData);
        } else {
            // Insert new record
            $contributionModel->save($contributionData);
        }
    }

    private function updateEmployeeContributions($employeeId, $monthlyRate)
    {
        // Call the contribution update functions (SSS, Pag-IBIG, PhilHealth)
        $this->addSSSContribution($employeeId, $monthlyRate, 'SSS');   // Update SSS contribution
        $this->addPagibigContribution($employeeId, $monthlyRate, 'Pag Ibig'); // Update Pag-IBIG contribution
        $this->addPhilhealthContribution($employeeId, $monthlyRate, 'Philhealth'); // Update PhilHealth contribution
    }

    protected function assignPayheadsToEmployee($employeeId)
    {
        $payheadModel = new PayheadModel();
        $employeePayheadModel = new EmployeePayheadModel(); // Load your EmployeePayheadModel

        // Fetch all active payheads dynamically from the database
        $defaultPayheads = $payheadModel->where('is_archive', 0)->findAll(); // Only non-archived payheads

        foreach ($defaultPayheads as $payhead) {
            $payheadData = [
                'employee_id' => $employeeId,
                'payhead_id' => $payhead['payhead_id'],
            ];
            $employeePayheadModel->insert($payheadData);
        }
    }




}
