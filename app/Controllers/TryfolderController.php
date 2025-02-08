<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\RegionModel;
use App\Models\ProvinceModel;
use App\Models\MunicipalityModel;
use App\Models\BarangayModel;

class TryfolderController extends BaseController
{
    public function index()
    {


        $data = [
            'page_title' => 'My Title',
            'heading' => 'Burat',
        ];


        $regionModel = new regionModel ();
        $data['regions'] = $regionModel->orderBy('regDesc','ASC')->findAll();
        
        return view('tryfolder/header', $data)
        . view ('tryfolder/index',$data);
        
    }

    function action (){
        if($this->request->getVar('action')){
            $action = $this->request->getVar('action');
            if($action == 'get_province'){
                $provinceModel = new ProvinceModel();
                $provinceData = $provinceModel->where('regCode', $this->request->getVar('regCode'))->findAll();
                echo json_encode($provinceData);
            }

            if($action == 'get_municipality')
			{
				$municipalityModel = new MunicipalityModel();
				$municipalityData = $municipalityModel->where('provCode', $this->request->getVar('provCode'))->findAll();

				echo json_encode($municipalityData);
			}
        }

    }

    public function viewBurat (){

        $data = [
            'page_title' => 'My Title',
            'heading' => 'Burat',
        ];
        
        
        return view('tryfolder/header', $data)
        . view ('tryfolder/viewBurat');
    }
}
