<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

 // Login
$routes->get('/login', 'LoginController::index');
$routes->post('/authenticate', 'LoginController::authenticate');
$routes->get('/logout', 'LoginController::logout');

$routes->get('/dashboard', 'UserController::index');

$routes->get('/payslip', 'UserController::payslip');
$routes->get('/addLoan', 'UserController::addLoan');


$routes->get('/payeesList', 'UserController::payeesList');
$routes->get('/paysummary', 'UserController::paysummary');
$routes->get('/contributionForm', 'UserController::contributionForm');





// DepartmentList
$routes->get('/department', 'DepartmentController::index');
$routes->post('/addDepartment', 'DepartmentController::addDepartment');
$routes->get('/deleteDepartment/(:any)', 'DepartmentController::deleteDepartment/$1');
$routes->get('/editDepartment/(:any)', 'DepartmentController::editDepartment/$1');
$routes->post('/updateDepartment/(:any)', 'DepartmentController::updateDepartment/$1');
$routes->get('/archiveDepartment/(:any)', 'DepartmentController::archive/$1');


// Holiday List
$routes->get('/holiday', 'HolidayController::index');
$routes->post('/addHoliday', 'HolidayController::addHoliday');
$routes->get('/deleteHoliday/(:any)', 'HolidayController::deleteHoliday/$1');
$routes->get('/editHoliday/(:any)', 'HolidayController::editHoliday/$1');
$routes->post('/updateHoliday/(:any)', 'HolidayController::updateHoliday/$1');
$routes->get('/archiveHoliday/(:any)', 'HolidayController::archive/$1');


// Contribution List
$routes->get('/contributionList', 'ContributionTypeController::index');
$routes->post('/addContributionList', 'ContributionTypeController::addContributionList');
$routes->get('/deleteContributionList/(:any)', 'ContributionTypeController::deleteContributionList/$1');
$routes->get('/editContributionList/(:any)', 'ContributionTypeController::editContributionList/$1');
$routes->post('/updateContributionList/(:any)', 'ContributionTypeController::updateContributionList/$1');

// CONTRIBUTION 2.0
$routes->get('/SSSList', 'ContributionTypeController::SSSList');
$routes->get('/pagibigList', 'ContributionTypeController::pagibigList');
$routes->get('/philhealthList', 'ContributionTypeController::philhealthList');

// Update SSS Contribution
$routes->get('/editSSS/(:any)', 'ContributionTypeController::editSSS/$1');
$routes->post('/updateSSS/(:any)', 'ContributionTypeController::updateSSS/$1');

// Update Pagibig Contribution
$routes->get('/editPagibig/(:any)', 'ContributionTypeController::editPagibig/$1');
$routes->post('/updatePagibig/(:any)', 'ContributionTypeController::updatePagibig/$1');

// Update Philhealth Contribution
$routes->get('/editPhilhealth/(:any)', 'ContributionTypeController::editPhilhealth/$1');
$routes->post('/updatePhilhealth/(:any)', 'ContributionTypeController::updatePhilhealth/$1');




// Payhead (Automatic)
$routes->get('/payhead', 'PayheadController::index');
$routes->post('/addPayhead', 'PayheadController::addPayhead');
$routes->get('/deletePayhead/(:any)', 'PayheadController::deletePayhead/$1');
$routes->get('/editPayhead/(:any)', 'PayheadController::editPayhead/$1');
$routes->post('/updatePayhead/(:any)', 'PayheadController::updatePayhead/$1');
$routes->get('/archivePayhead/(:any)', 'PayheadController::archive/$1');


// Assign Payhead
$routes->get('/assignPayhead', 'PayheadController::assignPayhead');
$routes->get('assignPayhead/setPayhead/(:any)', 'PayheadController::setPayhead/$1');
$routes->post('/saveManualPayheads/(:any)', 'PayheadController::saveManualPayheads/$1');
// $routes->delete('/deleteManualPayheadInList/(:any)', 'PayheadController::deleteManualPayheadInList/$1');
$routes->delete('/assignPayhead/setPayhead/(:any)/deleteManualPayheadInList/(:any)', 'PayheadController::deleteManualPayheadInList/$1/$2');




// Manual Payhead 
$routes->get('/manual_payhead', 'ManualPayheadController::index');
$routes->post('/addManualPayhead', 'ManualPayheadController::addManualPayhead');
$routes->get('/deleteManualPayhead/(:any)', 'ManualPayheadController::deleteManualPayhead/$1');
$routes->get('/editManualPayhead/(:any)', 'ManualPayheadController::editManualPayhead/$1');
$routes->post('/updateManualPayhead/(:any)', 'ManualPayheadController::updateManualPayhead/$1');
$routes->get('/archiveManualPayhead/(:any)', 'ManualPayheadController::archive/$1');


//  Employee Form
$routes->get('/employeeForm', 'EmployeeController::index');
$routes->post('/employeeForm/getProvinces', 'EmployeeController::getProvinces');
$routes->post('/employeeForm/getMunicipalities', 'EmployeeController::getMunicipalities');
$routes->post('/employeeForm/getBarangays', 'EmployeeController::getBarangays');
$routes->post('/employeeForm/getPosition', 'EmployeeController::getPosition');
$routes->post('/employeeForm/addEmployee', 'EmployeeController::addEmployee');

// ManageEmployee
$routes->get('/manageEmployee', 'EmployeeController::manageEmployee');
$routes->get('/deleteEmployee/(:any)', 'EmployeeController::deleteEmployee/$1');
$routes->get('/editEmployee/(:any)/', 'EmployeeController::editEmployee/$1');
$routes->post('/updateEmployee/(:any)/', 'EmployeeController::updateEmployee/$1');
$routes->get('/archiveEmployee/(:any)/', 'EmployeeController::archive/$1');


// Employee Profile
$routes->get('/viewEmployee/(:any)', 'EmployeeController::viewEmployee/$1');

// Pay Employee
$routes->get('/payEmployee', 'EmployeeController::payEmployee');


// Leave
$routes->get('/leave', 'LeaveController::index');
$routes->post('/leave/getEmployee', 'LeaveController::getEmployees');
$routes->post('/addLeave', 'LeaveController::addLeave');
$routes->get('/deleteLeave/(:any)', 'LeaveController::deleteLeave/$1');
$routes->get('/editLeave/(:any)', 'LeaveController::editLeave/$1');
$routes->post('/updateLeave/(:any)', 'LeaveController::updateLeave/$1');
$routes->get('/archiveLeave/(:any)', 'LeaveController::archive/$1');





// Position
$routes->get('/position', 'PositionController::index');
$routes->post('/addPosition', 'PositionController::addPosition');
$routes->get('/deletePosition/(:any)', 'PositionController::deletePosition/$1');
$routes->get('/editPosition/(:any)', 'PositionController::editPosition/$1');
$routes->post('/updatePosition/(:any)', 'PositionController::updatePosition/$1');
$routes->get('/archivePosition/(:any)', 'PositionController::archive/$1');




// Activity Log
$routes->get('/activityLog', 'ActivityLogController::index');

// Settings
$routes->get('/settings', 'SettingsController::index');
$routes->post('/updateProfile', 'SettingsController::updateProfile');
$routes->post('/updateAccount', 'SettingsController::updateAccount');

// Archive
$routes->get('/archive', 'ArchiveController::index');
$routes->get('/unarchiveDepartment/(:any)', 'ArchiveController::unarchiveDepartment/$1');
$routes->get('/unarchivePosition/(:any)', 'ArchiveController::unarchivePosition/$1');
$routes->get('/unarchiveEmployee/(:any)', 'ArchiveController::unarchiveEmployee/$1');
$routes->get('/unarchivePayhead/(:any)', 'ArchiveController::unarchivePayhead/$1');
$routes->get('/unarchiveManualPayhead/(:any)', 'ArchiveController::unarchiveManualPayhead/$1');
$routes->get('/unarchiveHoliday/(:any)', 'ArchiveController::unarchiveHoliday/$1');
$routes->get('/unarchivePayroll/(:any)', 'ArchiveController::unarchivePayroll/$1');


$routes->get('/deleteArchivedHoliday/(:any)', 'ArchiveController::deleteHoliday/$1');
$routes->get('/deleteArchivedPayhead/(:any)', 'ArchiveController::deletePayhead/$1');
$routes->get('/deleteArchivedPosition/(:any)', 'ArchiveController::deletePosition/$1');
$routes->get('/deleteArchivedDepartment/(:any)', 'ArchiveController::deleteDepartment/$1');
$routes->get('/deleteArchivedEmployee/(:any)', 'ArchiveController::deleteEmployee/$1');
$routes->get('/deleteArchivedManualPayhead/(:any)', 'ArchiveController::deleteManualPayhead/$1');

// Attendance  
$routes->get('/attendance', 'AttendanceController::index');
$routes->get('/filterAttendance', 'AttendanceController::filterAttendance');
$routes->get('/employeeAttendance', 'AttendanceController::employeeAttendance');
$routes->get('/attendance/downloadCSV', 'AttendanceController::downloadCSV');
$routes->get('/attendance/downloadExcel', 'AttendanceController::downloadExcel');
$routes->get('/attendance/downloadPDF', 'AttendanceController::downloadPDF');
$routes->get('/attendance/downloadPDFEmployee', 'AttendanceController::downloadPDFEmployee');
$routes->get('/attendance/downloadCSVEmployee', 'AttendanceController::downloadCSVEmployee');
$routes->post('/attendance/log', 'AttendanceController::logAttendance');
// $routes->post('/Editing/HarmonySystem/public/attendance/log', 'AttendanceController::logAttendance');



// Payroll Controller
$routes->get('/payroll', 'PayrollController::index');
$routes->post('/generatePayroll', 'PayrollController::generate');
$routes->get('/archivePayroll/(:any)', 'PayrollController::archive/$1');




// View Payee List
$routes->get('/payroll/view/(:any)', 'PayrollController::view/$1');
$routes->get('/paysummary/(:any)/(:any)', 'PayrollController::paysumarry/$1/$2');

$routes->get('/download/(:any)/(:any)', 'PayrollController::downloadPaysummary/$1/$2');



// Payslip
$routes->get('/payslip', 'PayrollController::index');




$routes->get('/tryfolder/index', 'TryfolderController::index');
$routes->post('/tryfolder/index', 'TryfolderController::action');
$routes->get('/tryfolder/viewBurat', 'TryfolderController::viewBurat');
$routes->get('/DynamicDependent', 'Dynamic_dependent::index');



