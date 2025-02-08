<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ContributionTypeListModel;
use App\Models\EmployeeModel;
use App\Models\UserModel;
use App\Models\SssModel;

class ContributionTypeController extends BaseController
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
            $model = new ContributionTypeListModel;
            $employeeModel = new EmployeeModel();
            $data['employees'] = $employeeModel->findAll();


            $userId = $session->get('id');
            $data['user'] = $userModel->find($userId);



            $data['contributions'] = $model->findAll();
            return View('common/header', $data)
                . View('contributionList', $data);

        } catch (\Exception $e) {

            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }

    }

    public function addContributionList()
    {

        try {
            $model = new ContributionTypeListModel;
            $data = array(
                // DATABASE TABLE                           TEXTFIELD FIELD
                'contribution_name' => $this->request->getPost('contributionName'),

            );


            $model->save($data);
            $data['contributions'] = $model->findAll();

            $currentDate = date('D M j, Y');
            $currentTime = date('H:i a');
            log_activity("Admin added a Contribution List on Date: $currentDate $currentTime", session()->get('id'));
            return redirect()->to('/contributionList')->with('message', 'Contribution added Successfully');

        } catch (\Exception $e) {

            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }

    }

    public function deleteContributionList($id)
    {

        try {
            $model = new ContributionTypeListModel;
            $model->delete($id);

            $currentDate = date('D M j, Y');
            $currentTime = date('H:i A');
            log_activity("Admin deleted a Contribution List with ID: $id on Date: $currentDate $currentTime", session()->get('id'));

            return redirect()->to('/contributionList')->with('message', 'Contribution deleted Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();

        }

    }

    public function editContributionList($id)
    {

        try {

            $session = session();
            $model = new ContributionTypeListModel;
            $data['contribution_column'] = $model->find($id);
            $data['contributions'] = $model->findAll();

            $userModel = new UserModel();
            $userId = $session->get('id');
            $data['user'] = $userModel->find($userId);

            return View('common/header', $data)
                . View('contributionList', $data);


        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();

        }

    }

    public function updateContributionList($id)
    {

        try {
            $model = new ContributionTypeListModel;
            $data = array(
                // DATABASE TABLE                           TEXTFIELD FIELD
                'contribution_name' => $this->request->getPost('contributionName'),

            );

            $model->update($id, $data);

            $currentDate = date('D M j, Y');
            $currentTime = date('H:i A');
            log_activity("Admin updated a Contribution List with ID: $id on Date: $currentDate $currentTime", session()->get('id'));
            return redirect()->to('/contributionList')->with('message', 'Contribution updated Successfully');


        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();

        }


    }

    public function SSSList()
    {

        try {

            $session = session();
            if (!$session->get('logged_in')) {
                // If not logged in, redirect to the login page
                return redirect()->to('/login');
            }

            $userModel = new UserModel();
            $model = new ContributionTypeListModel;
            $employeeModel = new EmployeeModel();

            $data['employees'] = $employeeModel
                ->select('tbl_employee.employee_id,tbl_employee.firstname,tbl_employee.lastname, tbl_employee.middlename,tbl_employee.monthly_rate, tbl_contribution_type.*, tbl_sss.salary_range_start, tbl_sss.salary_range_end,tbl_sss.employer_share, tbl_sss.employee_share')

                ->join('tbl_contribution_type', 'tbl_contribution_type.employee_id = tbl_employee.employee_id')
                ->join('tbl_sss', 'tbl_employee.monthly_rate >= tbl_sss.salary_range_start AND tbl_employee.monthly_rate <= tbl_sss.salary_range_end')
                ->where('tbl_contribution_type.contribution_name', 'SSS')
                ->findAll();



            $userId = $session->get('id');
            $data['user'] = $userModel->find($userId);



            $data['contributions'] = $model->findAll();
            return View('common/header', $data)
                . View('SSSList', $data);

        } catch (\Exception $e) {

            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }

    }
    public function editSSS($id)
    {
        try {

            $session = session();
            if (!$session->get('logged_in')) {
                // If not logged in, redirect to the login page
                return redirect()->to('/login');
            }

            $userModel = new UserModel();
            $model = new ContributionTypeListModel;
            $employeeModel = new EmployeeModel();



            $data['employees'] = $employeeModel
                ->select('tbl_employee.employee_id,tbl_employee.firstname,tbl_employee.lastname, tbl_employee.middlename,tbl_employee.monthly_rate, tbl_contribution_type.*, tbl_sss.salary_range_start, tbl_sss.salary_range_end,tbl_sss.employer_share, tbl_sss.employee_share')

                ->join('tbl_contribution_type', 'tbl_contribution_type.employee_id = tbl_employee.employee_id')
                ->join('tbl_sss', 'tbl_employee.monthly_rate >= tbl_sss.salary_range_start AND tbl_employee.monthly_rate <= tbl_sss.salary_range_end')
                ->where('tbl_contribution_type.contribution_name', 'SSS')
                ->findAll();

            $data['sss_column'] = $model
                ->select('tbl_contribution_type.*, tbl_employee.monthly_rate, tbl_employee.employee_id, tbl_employee.monthly_rate')
                ->join('tbl_employee', 'tbl_employee.employee_id = tbl_contribution_type.employee_id')
                ->find($id);



            $userId = $session->get('id');
            $data['user'] = $userModel->find($userId);



            $data['contributions'] = $model->findAll();
            return View('common/header', $data)
                . View('SSSList', $data);
        } catch (\Exception $e) {

            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    function updateSSS($id)
    {
        try {

            $model = new ContributionTypeListModel;
            $data = array(
                // DATABASE TABLE                           TEXTFIELD FIELD
                'contribution_amount' => $this->request->getPost('employee_share'),

            );

            $model->update($id, $data);

            $currentDate = date('D M j, Y');
            $currentTime = date('H:i A');
            log_activity("Admin updated a SSS Contribution with ID: $id on Date: $currentDate $currentTime", session()->get('id'));
            return redirect()->to('/SSSList')->with('message', 'Contribution updated Successfully');


        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function pagibigList()
    {

        try {

            $session = session();
            if (!$session->get('logged_in')) {
                // If not logged in, redirect to the login page
                return redirect()->to('/login');
            }

            $userModel = new UserModel();
            $model = new ContributionTypeListModel;
            $employeeModel = new EmployeeModel();



            $data['employees'] = $employeeModel
                ->select('tbl_employee.employee_id,tbl_employee.firstname,tbl_employee.lastname, tbl_employee.middlename,tbl_employee.monthly_rate, tbl_contribution_type.*, tbl_pagibig.salary_range_start, tbl_pagibig.salary_range_end,tbl_pagibig.employer_share, tbl_pagibig.employee_share, tbl_pagibig.employer_max_contribution')

                ->join('tbl_contribution_type', 'tbl_contribution_type.employee_id = tbl_employee.employee_id')
                ->join('tbl_pagibig', 'tbl_employee.monthly_rate >= tbl_pagibig.salary_range_start AND tbl_employee.monthly_rate <= tbl_pagibig.salary_range_end')
                ->where('tbl_contribution_type.contribution_name', 'Pag Ibig')
                ->findAll();





            $userId = $session->get('id');
            $data['user'] = $userModel->find($userId);



            $data['contributions'] = $model->findAll();
            return View('common/header', $data)
                . View('pagibigList', $data);

        } catch (\Exception $e) {

            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }

    }

    public function editPagibig($id)
    {
        try {

            $session = session();
            if (!$session->get('logged_in')) {
                // If not logged in, redirect to the login page
                return redirect()->to('/login');
            }

            $userModel = new UserModel();
            $model = new ContributionTypeListModel;
            $employeeModel = new EmployeeModel();



            $data['employees'] = $employeeModel
                ->select('tbl_employee.employee_id,tbl_employee.firstname,tbl_employee.lastname, tbl_employee.middlename,tbl_employee.monthly_rate, tbl_contribution_type.*, tbl_pagibig.salary_range_start, tbl_pagibig.salary_range_end,tbl_pagibig.employer_share, tbl_pagibig.employee_share, tbl_pagibig.employer_max_contribution')

                ->join('tbl_contribution_type', 'tbl_contribution_type.employee_id = tbl_employee.employee_id')
                ->join('tbl_pagibig', 'tbl_employee.monthly_rate >= tbl_pagibig.salary_range_start AND tbl_employee.monthly_rate <= tbl_pagibig.salary_range_end')
                ->where('tbl_contribution_type.contribution_name', 'Pag Ibig')
                ->findAll();

            $data['pagibig_column'] = $model
                ->select('tbl_contribution_type.id as contrib_id, tbl_contribution_type.contribution_amount, tbl_employee.monthly_rate, tbl_employee.employee_id, tbl_employee.monthly_rate')
                ->join('tbl_employee', 'tbl_employee.employee_id = tbl_contribution_type.employee_id')
                ->find($id);



            $userId = $session->get('id');
            $data['user'] = $userModel->find($userId);



            $data['contributions'] = $model->findAll();
            return View('common/header', $data)
                . View('pagibigList', $data);

        } catch (\Exception $e) {

            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }


    }
    function updatePagibig($id)
    {
        try {

            $model = new ContributionTypeListModel;
            $data = array(
                // DATABASE TABLE                           TEXTFIELD FIELD
                'contribution_amount' => $this->request->getPost('employee_share'),

            );

            $model->update($id, $data);

            $currentDate = date('D M j, Y');
            $currentTime = date('H:i A');
            log_activity("Admin updated a Pagibg Contribution with ID: $id on Date: $currentDate $currentTime", session()->get('id'));
            return redirect()->to('/pagibigList')->with('message', 'Contribution updated Successfully');


        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function philhealthList()
    {

        try {

            $session = session();
            if (!$session->get('logged_in')) {
                // If not logged in, redirect to the login page
                return redirect()->to('/login');
            }

            $userModel = new UserModel();
            $model = new ContributionTypeListModel;
            $employeeModel = new EmployeeModel();

            $data['employees'] = $employeeModel
                ->select('tbl_employee.employee_id,tbl_employee.firstname,tbl_employee.lastname, tbl_employee.middlename,tbl_employee.monthly_rate, tbl_contribution_type.*, tbl_philhealth.salary_range_start, tbl_philhealth.salary_range_end')

                ->join('tbl_contribution_type', 'tbl_contribution_type.employee_id = tbl_employee.employee_id')
                ->join('tbl_philhealth', 'tbl_employee.monthly_rate >= tbl_philhealth.salary_range_start AND tbl_employee.monthly_rate <= tbl_philhealth.salary_range_end')
                ->where('tbl_contribution_type.contribution_name', 'Philhealth')
                ->findAll();





            $userId = $session->get('id');
            $data['user'] = $userModel->find($userId);



            $data['contributions'] = $model->findAll();
            return View('common/header', $data)
                . View('philhealthList', $data);

        } catch (\Exception $e) {

            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }

    }

    public function editPhilhealth($id)
    {
        try {

            $session = session();
            if (!$session->get('logged_in')) {
                // If not logged in, redirect to the login page
                return redirect()->to('/login');
            }

            $userModel = new UserModel();
            $model = new ContributionTypeListModel;
            $employeeModel = new EmployeeModel();

            $data['employees'] = $employeeModel
                ->select('tbl_employee.employee_id,tbl_employee.firstname,tbl_employee.lastname, tbl_employee.middlename,tbl_employee.monthly_rate, tbl_contribution_type.*, tbl_philhealth.salary_range_start, tbl_philhealth.salary_range_end')

                ->join('tbl_contribution_type', 'tbl_contribution_type.employee_id = tbl_employee.employee_id')
                ->join('tbl_philhealth', 'tbl_employee.monthly_rate >= tbl_philhealth.salary_range_start AND tbl_employee.monthly_rate <= tbl_philhealth.salary_range_end')
                ->where('tbl_contribution_type.contribution_name', 'Philhealth')
                ->findAll();

            $data['philhealth_column'] = $model
                ->select('tbl_contribution_type.id as contrib_id, tbl_contribution_type.contribution_amount, tbl_employee.monthly_rate, tbl_employee.employee_id, tbl_employee.monthly_rate')
                ->join('tbl_employee', 'tbl_employee.employee_id = tbl_contribution_type.employee_id')
                ->find($id);





            $userId = $session->get('id');
            $data['user'] = $userModel->find($userId);



            $data['contributions'] = $model->findAll();
            return View('common/header', $data)
                . View('philhealthList', $data);


        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    function updatePhilhealth($id)
    {
        try {

            $model = new ContributionTypeListModel;
            $data = array(
                // DATABASE TABLE                           TEXTFIELD FIELD
                'contribution_amount' => $this->request->getPost('employee_share'),

            );

            $model->update($id, $data);

            $currentDate = date('D M j, Y');
            $currentTime = date('H:i A');
            log_activity("Admin updated a Philhealth Contribution with ID: $id on Date: $currentDate $currentTime", session()->get('id'));
            return redirect()->to('/philhealthList')->with('message', 'Contribution updated Successfully');


        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }


}
