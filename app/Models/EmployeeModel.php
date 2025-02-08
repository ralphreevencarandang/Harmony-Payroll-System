<?php

namespace App\Models;

use CodeIgniter\Model;

class EmployeeModel extends Model
{
    protected $table = 'tbl_employee';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'employee_id',
        'firstname',
        'middlename',
        'lastname',
        'birthdate',
        'sex',
        'phonenumber',
        'email',
        'status',
        'date_hired',
        'restday',
        'daily_rate',
        'monthly_rate',
        'time_in',
        'time_out',
        'sick_leave_balance',
        'vacation_leave_balance',
        'pagibig_account_number',
        'sss_account_number',
        'philhealth_account_number',
        'position_id',
        'department_id',
        'region_id',
        'province_id',
        'municipality_id',
        'barangay_id',
        'street',
        'created_at',
        'image',
        'rfid_uid',
        'sick_leave_balance',
        'vacation_leave_balance',
        'is_archive'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];
}
