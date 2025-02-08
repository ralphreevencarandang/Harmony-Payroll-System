<?= $this->extend('base'); ?>
<?= $this->section('main_content'); ?>

<style>
    body {
        font-size: 0.9rem;
    }
</style>

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


<div class="container-fluid">
    <div class="row">



        <div class="row">
            <div class="col">
                <h1>Pay Employees Table</h1>
            </div>
            <div class="col d-flex justify-content-end">
                <a href="/employeeForm" class="btn btn-primary">Add Employee</a>
            </div>
        </div>

        <div class="d-flex">
            <a href="/dashboard">Home </a>
            <p class="mx-2"> > </p>
            <a href=""> Employee</a>
        </div>

    </div>

    <div class="table-responsive">
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

                <?php foreach ($employees as $employee): ?>
                    <tr>
                        <td><?= $employee['id'] ?></td>
                        <td><?= $employee['employee_id'] ?></td>
                        <td><?= $employee['firstname'] . " " . $employee['middlename'] . " " . $employee['lastname'] ?></td>
                        <td><?= $employee['department_name'] ?></td>
                        <td><?= $employee['position_name'] ?></td>
                        <td><?= $employee['email'] ?></td>
                        <td> <?= date("g:i A", strtotime($employee['time_in'])) . " - " . date("g:i A", strtotime($employee['time_out'])) ?>
                        </td>
                        <td><?= $employee['status'] ?></td>
                        <td><?= date('M j, Y', strtotime($employee['date_hired'])) ?></td>




                        <td class="d-flex">

                            <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                data-bs-target="#payEmployeeModal">
                                pay
                            </button>
                            <a href="" class="btn btn-primary btn-sm">Payhead</a>




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

    </div>
</div>


<!-- MODAL -->
 <?php include('modal/pay_employee_modal.php')?>






<script>
    new DataTable('#table');

    // Handle delete confirmation
    const confirmModal = document.getElementById('confirmModal');
    confirmModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget; // Button that triggered the modal
        const empId = button.getAttribute('data-id'); // Extract info from data-* attributes
        const EmployeeID = button.getAttribute('data-employee-id'); // Extract info from data-* attributes


        // Update the confirmation link
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
        confirmDeleteBtn.href = '/deleteEmployee/' + empId;
        document.getElementById('empId').textContent = EmployeeID;

    });


</script>


<?= $this->endSection(); ?>