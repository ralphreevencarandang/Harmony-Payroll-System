<?php

namespace App\Models;

use CodeIgniter\Model;

class PayrollModel extends Model
{
    protected $table = 'tbl_payroll';
    protected $primaryKey = 'payroll_id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'employee_id',
        'pay_period_start',
        'pay_period_end',
        'total_days',
        'basic_salary',
        'holiday_premium',
        'overtime_amount',
        'total_overtime_hours',
        'total_late_hours',
        'total_undertime_hours',
        'late_amount',
        'undertime_amount',
        'restday_amount',
        'earnings',
        'deductions',
        'net_pay',
        'final_netpay',
        'reference_number',
        'date_issued',
        'is_archive',
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
