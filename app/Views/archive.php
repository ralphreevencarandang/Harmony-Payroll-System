<?= $this->extend('base') ?>
<?= $this->section('main_content') ?>




<div class="row">
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissble show fade" role="alert">
            <?= session()->getFlashdata('error'); ?>


            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('message')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('message'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <div class="col">
        <h1>Archive</h1>
    </div>
    <div class="d-flex">
        <a href="/dashboard">Home </a>

        <p class="mx-2"> > </p>
        <p class="text-primary"> Archive</p>
    </div>
</div>

<div class="row">
    <ul class="nav nav-tabs" id="myTab" role="tablist">


        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="employee-tab" data-bs-toggle="tab" data-bs-target="#employee"
                type="button" role="tab" aria-controls="employee" aria-selected="true">Employee</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="department-tab" data-bs-toggle="tab" data-bs-target="#department" type="button"
                role="tab" aria-controls="department" aria-selected="false">Department</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="position-tab" data-bs-toggle="tab" data-bs-target="#position" type="button"
                role="tab" aria-controls="position" aria-selected="false">Position</button>
        </li>


        <li class="nav-item" role="presentation">
            <button class="nav-link" id="payhead-tab" data-bs-toggle="tab" data-bs-target="#manualPayhead" type="button"
                role="tab" aria-controls="manualPayhead" aria-selected="false">Manual Payhead</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="holiday-tab" data-bs-toggle="tab" data-bs-target="#holiday" type="button"
                role="tab" aria-controls="holiday" aria-selected="false">Holiday</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="leave-tab" data-bs-toggle="tab" data-bs-target="#leave" type="button"
                role="tab" aria-controls="leave" aria-selected="false">Leave</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="payroll-tab" data-bs-toggle="tab" data-bs-target="#payroll" type="button"
                role="tab" aria-controls="payroll" aria-selected="false">Payroll</button>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">

        <!-- EMPLOYEE ARCHIVE -->
        <div class="tab-pane fade show active" id="employee" role="tabpanel" aria-labelledby="employee-tab">
            <div class="table-responsive">

                <?php if (!empty($archivedEmployees)): ?>
                    <table id="table" class="table table-striped text-center">
                        <thead>
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="text-center">Employee ID</th>
                                <th class="text-center">Name</th>
                                <th class="text-center">Department</th>
                                <th class="text-center">Position</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Schedule</th>

                                <th class="text-center">Status</th>
                                <th class="text-center">Date Hired</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($archivedEmployees as $employee): ?>
                                <tr>
                                    <td><?= $employee['id'] ?></td>
                                    <td><?= $employee['employee_id'] ?></td>
                                    <td><?= $employee['firstname'] . " " . $employee['middlename'] . " " . $employee['lastname'] ?>
                                    </td>
                                    <td><?= $employee['department_name'] ?></td>
                                    <td><?= $employee['position_name'] ?></td>
                                    <td><?= $employee['email'] ?></td>
                                    <td> <?= date("g:i A", strtotime($employee['time_in'])) . " - " . date("g:i A", strtotime($employee['time_out'])) ?>
                                    </td>
                                    <td><?= $employee['status'] ?></td>
                                    <td><?= $employee['date_hired'] ?></td>




                                    <td>


                                        <a href="/unarchiveEmployee/<?= $employee['id'] ?>" class="btn btn-warning btn-sm"
                                            onclick="return confirmUnarchive()"> <i class="fa-solid fa-box-archive"></i>
                                            Unarchive</a>






                                    </td>

                                </tr>

                            <?php endforeach; ?>


                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="text-center">ID</th>

                                <th class="text-center">Employee ID</th>
                                <th class="text-center">Name</th>
                                <th class="text-center">Department</th>
                                <th class="text-center">Position</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Schedule</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Date Hired</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </tfoot>
                    </table>
                <?php else: ?>
                    <p class="text-center mt-4">No records found</p>
                <?php endif; ?>

            </div>
        </div>

        <!-- DEPARTMENT ARCHIVE -->
        <div class="tab-pane fade" id="department" role="tabpanel" aria-labelledby="department-tab">

            <div class="row">

                <div class="table-responsive">

                    <?php if (!empty($archivedDepartments)): ?>
                        <table id="table" class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">Department ID</th>
                                    <th class="text-center">Department Name</th>
                                    <th class="text-center">Description</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <?php foreach ($archivedDepartments as $department): ?>
                                    <tr>
                                        <td><?= $department['department_id']; ?></td>
                                        <td><?= $department['department_name']; ?></td>
                                        <td><?= $department['description']; ?></td>
                                        <td class="text-center">
                                            <a href="/unarchiveDepartment/<?= $department['department_id']; ?>"
                                                class="btn btn-warning btn-sm" onclick="return confirmUnarchive()"> <i
                                                    class="fa-solid fa-box-archive"></i> Unarchive</a>



                                        </td>
                                    </tr>
                                <?php endforeach; ?>



                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="text-center">Department ID</th>
                                    <th class="text-center">Department Name</th>
                                    <th class="text-center">Description</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    <?php else: ?>

                        <p class="text-center mt-4">No records found</p>
                    <?php endif; ?>


                </div>
            </div>
        </div>


        <!-- POSITION ARCHIVE -->
        <div class="tab-pane fade" id="position" role="tabpanel" aria-labelledby="position-tab">
            <div class="row">

                <div class="table-responsive">
                    <?php if (!empty($archivedPositions)): ?>
                        <table id="table" class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">Position ID</th>
                                    <th class="text-center">Position Name</th>
                                    <th class="text-center">Position Description</th>
                                    <th class="text-center">Department</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <?php foreach ($archivedPositions as $position): ?>
                                    <tr>
                                        <td><?= $position['position_id'] ?></td>
                                        <td><?= $position['position_name'] ?></td>
                                        <td><?= $position['position_description'] ?></td>
                                        <td><?= $position['department_name'] ?></td>

                                        <td class="text-center">
                                            <a href="/unarchivePosition/<?= $position['position_id']; ?>"
                                                class="btn btn-warning btn-sm" onclick="return confirmUnarchive()"> <i
                                                    class="fa-solid fa-archive"></i> Unarchive</a>




                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="text-center">Position ID</th>
                                    <th class="text-center">Position Name</th>
                                    <th class="text-center">Position Description</th>
                                    <th class="text-center">Department</th>
                                    <th class="text-center">Action</th>

                                </tr>
                            </tfoot>
                        </table>

                    <?php else: ?>

                        <p class="text-center mt-4">No records found</p>
                    <?php endif; ?>


                </div>
            </div>
        </div>

        <!-- PAYHEAD ARCHIVE -->
        <div class="tab-pane fade" id="payhead" role="tabpanel" aria-labelledby="payhead-tab">
            <div class="table-responsive">

                <?php if (!empty($archivePayheads)): ?>
                    <table id="table" class="table table-striped text-center">
                        <thead>
                            <tr>
                                <th class="text-center">Payhead ID</th>
                                <th class="text-center">Payhead Name</th>
                                <th class="text-center">Description</th>
                                <th class="text-center">Amount</th>
                                <th class="text-center">Head Type</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <?php foreach ($archivePayheads as $payhead): ?>
                                <tr>
                                    <td class="text-center"><?= $payhead['payhead_id'] ?></td>
                                    <td><?= $payhead['payhead_name'] ?></td>
                                    <td><?= $payhead['description'] ?></td>
                                    <td class="text-center"><?= $payhead['amount'] ?></td>

                                    <td><span
                                            class="badge <?= $payhead['payhead_type'] == 'Earnings' ? 'bg-success' : 'bg-danger' ?>"><?= $payhead['payhead_type'] ?></span>
                                    </td>



                                    <td class="text-center">
                                        <a href="/unarchivePayhead/<?= $payhead['payhead_id'] ?>" class="btn btn-warning btn-sm"
                                            onclick="return confirmUnarchive()"><i class="fa-solid fa-box-archive"></i>
                                            Unarchive</a>


                                        <a href="/deleteArchivedPayhead/<?= $payhead['payhead_id']; ?>"
                                            class="btn btn-danger btn-sm" onclick="return confirmDelete()">
                                            <i class="fa-solid fa-trash"></i> Delete</a>

                                    </td>
                                </tr>

                            <?php endforeach; ?>


                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="text-center">Payhead ID</th>
                                <th class="text-center">Payhead Name</th>
                                <th class="text-center">Description</th>
                                <th class="text-center">Amount</th>
                                <th class="text-center">Head Type</th>


                                <th class="text-center">Action</th>
                            </tr>
                        </tfoot>
                    </table>
                <?php else: ?>

                    <p class="text-center mt-4">No records found</p>
                <?php endif; ?>

            </div>
        </div>

        <!-- MANUAL PAYHEAD ARCHIVE -->
        <div class="tab-pane fade" id="manualPayhead" role="tabpanel" aria-labelledby="payhead-tab">
            <div class="table-responsive">

                <?php if (!empty($archiveManualPayheads)): ?>
                    <table id="table" class="table table-striped text-center">
                        <thead>
                            <tr>
                                <th class="text-center">Payhead ID</th>
                                <th class="text-center">Payhead Name</th>

                                <th class="text-center">Head Type</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <?php foreach ($archiveManualPayheads as $manualPayhead): ?>
                                <tr>
                                    <td class="text-center"><?= $manualPayhead['manual_payhead_id'] ?></td>
                                    <td><?= $manualPayhead['payhead_name'] ?></td>


                                    <td><span
                                            class="badge <?= $manualPayhead['head_type'] == 'Earnings' ? 'bg-success' : 'bg-danger' ?>"><?= $manualPayhead['head_type'] ?></span>
                                    </td>



                                    <td class="text-center">
                                        <a href="/unarchiveManualPayhead/<?= $manualPayhead['manual_payhead_id'] ?>"
                                            class="btn btn-warning btn-sm" onclick="return confirmUnarchive()"><i
                                                class="fa-solid fa-box-archive"></i>
                                            Unarchive</a>



                                    </td>
                                </tr>

                            <?php endforeach; ?>


                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="text-center">Payhead ID</th>
                                <th class="text-center">Payhead Name</th>

                                <th class="text-center">Head Type</th>


                                <th class="text-center">Action</th>
                            </tr>
                        </tfoot>
                    </table>
                <?php else: ?>

                    <p class="text-center mt-4">No records found</p>
                <?php endif; ?>

            </div>
        </div>



        <!-- HOLIDAY ARCHIVE -->
        <div class="tab-pane fade" id="holiday" role="tabpanel" aria-labelledby="holiday-tab">
            <div class="table-responsive">
                <?php if (!empty($archiveHolidays)): ?>
                    <table id="table" class="table table-striped w-100 text-center">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Holiday Title</th>
                                <th class="text-center">Holiday Description</th>
                                <th class="text-center">Holiday Date</th>
                                <th class="text-center">Holiday Type</th>
                                <th class="text-center">Action</th>

                        </thead>
                        <tbody>

                            <?php foreach ($archiveHolidays as $holiday): ?>
                                <tr>
                                    <td class="text-center"><?= $holiday['holiday_id']; ?></td>
                                    <td><?= $holiday['holiday_title']; ?></td>

                                    <td><?= $holiday['holiday_description']; ?></td>

                                    <td><?= date('F j, Y', strtotime($holiday['holiday_date'])) ?></td>
                                    <td><span
                                            class="badge <?= $holiday['holiday_type'] == 'Regular' ? 'bg-success' : 'bg-danger' ?>"><?= $holiday['holiday_type']; ?></span>
                                    </td>

                                    <td>

                                        <a href="/unarchiveHoliday/<?= $holiday['holiday_id']; ?>"
                                            class="btn btn-warning btn-sm" onclick="return confirmUnarchive()">
                                            <i class="fa-solid fa-box-archive"></i> Unarchive</a>




                                    </td>


                                </tr>

                            <?php endforeach; ?>

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Holiday Title</th>
                                <th>Holiday Description</th>
                                <th>Holiday Date</th>
                                <th>Holiday Type</th>
                                <th>Action</th>

                            </tr>
                        </tfoot>
                    </table>

                <?php else: ?>

                    <p class="text-center mt-4">No records found</p>
                <?php endif; ?>








            </div>
        </div>


        <!-- Leave ARCHIVE -->
        <div class="tab-pane fade" id="leave" role="tabpanel" aria-labelledby="holiday-tab">
            <div class="table-responsive">
                <?php if (!empty($archiveHolidays)): ?>
                    <table id="table" class="table table-striped w-100 text-center">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Employee ID</th>
                                <th class="text-center">Name</th>
                                <th class="text-center">Leave Type</th>
                                <th class="text-center">Leave Duration</th>
                                <th class="text-center">No. of Days</th>
                                <th class="text-center">Reason</th>
                                <th class="text-center">Action</th>

                        </thead>
                        <tbody>

                            <?php foreach ($archivedLeaves as $leave): ?>
                                <tr>
                                    <td class="text-center"><?= $leave['leave_id']; ?></td>
                                    <td><?= $leave['employee_id']; ?></td>
                                    <td><?= $leave['firstname']; ?>         <?= $leave['middlename']; ?>         <?= $leave['lastname']; ?></td>

                                    <td><?= $leave['leave_type']; ?></td>

                                    <td><?= date('F j, Y', strtotime($leave['leave_start_date'])) ?> -
                                        <?= date('F j, Y', strtotime($leave['leave_end_date'])) ?>
                                    </td>
                                    <td><?= $leave['number_of_days']; ?></td>
                                    <td><?= $leave['reason']; ?></td>


                                    <td>

                                        <a href="/unarchiveHoliday/<?= $holiday['holiday_id']; ?>"
                                            class="btn btn-warning btn-sm" onclick="return confirmUnarchive()">
                                            <i class="fa-solid fa-box-archive"></i> Unarchive</a>



                                    </td>


                                </tr>

                            <?php endforeach; ?>

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Holiday Title</th>
                                <th>Holiday Description</th>
                                <th>Holiday Date</th>
                                <th>Holiday Type</th>
                                <th>Action</th>

                            </tr>
                        </tfoot>
                    </table>

                <?php else: ?>

                    <p class="text-center mt-4">No records found</p>
                <?php endif; ?>








            </div>
        </div>

        <!-- Payroll ARCHIVE -->
        <div class="tab-pane fade" id="payroll" role="tabpanel" aria-labelledby="payroll-tab">
            <div class="table-responsive">
                <?php if (!empty($archivePayrolls)): ?>
                    <table id="table" class="table table-striped w-100 text-center">
                        <thead>
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="text-center">Refrence No.</th>
                                <th class="text-center">Date From</th>
                                <th class="text-center">Date To</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>

                        </thead>
                        <tbody>

                            <?php foreach ($archivePayrolls as $payroll): ?>
                                <tr>
                                    <td><?= esc($payroll['payroll_id']) ?></td>
                                    <td><?= esc($payroll['reference_number']) ?></td>
                                    <td><?= date('M j, Y', strtotime(esc($payroll['date_from']))) ?></td>
                                    <td><?= date('M j, Y', strtotime(esc($payroll['date_to']))) ?></td>
                                    <td> <span class="badge bg-success">Calculated</span></td>

                                    <td>
                                        <a href="/unarchivePayroll/<?= $payroll['reference_number']; ?>"
                                            class="btn btn-warning btn-sm" onclick="return confirmUnarchive()">
                                            <i class="fa-solid fa-box-archive"></i> Unarchive</a>



                                    </td>


                                </tr>

                            <?php endforeach; ?>

                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="text-center">Refrence No.</th>
                                <th class="text-center">Date From</th>
                                <th class="text-center">Date To</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>

                            </tr>
                        </tfoot>
                    </table>

                <?php else: ?>

                    <p class="text-center mt-4">No records found</p>
                <?php endif; ?>








            </div>
        </div>
    </div>
</div>



<script>

    function confirmUnarchive() {
        return confirm('Are you sure you want to unarchive this record? ');
    }
    function confirmDelete() {
        return confirm('Are you sure you want to delete this record? ');
    }



</script>

<?= $this->endSection() ?>