<?= $this->extend('base'); ?>
<?= $this->section('main_content'); ?>



<?php $isEditing = isset($philhealth_column); ?>

<?php if ($isEditing): ?>
    <script>
        // Automatically show the modal if $holiday is set
        window.onload = function () {
            var updateModal = new bootstrap.Modal(document.getElementById('updateModal'));
            updateModal.show();
        };
    </script>

<?php endif; ?>
<div class="container">
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('error'); ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('message')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('message') ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>


        </div>
    <?php endif; ?>

    <div class="row">



        <div class="row">
            <div class="col">
                <h1>Philhealth Contribution List</h1>


            </div>


            <div class="d-flex">
                <a href="/dashboard">Home </a>
                <p class="mx-2"> > </p>
                <a href=""> Contribution </a>

                <p class="mx-2"> > </p>
                <a href=""> Contribution List</a>
            </div>

        </div>
        <div>
            <a href="https://www.philhealth.gov.ph/advisories/2025/PA2025-0002.pdf" target="_blank"><u>Show Table
                    Reference</u></a>
        </div>






        <div class="table-responsive">
            <table id="table" class="table table-striped text-center">
                <thead>
                    <tr>
                        <th class="text-center">Employee ID</th>
                        <th class="text-center">Employee Name</th>
                        <th class="text-center">Contribution Name</th>
                        <th class="text-center">Monthly Salary</th>
                        <th class="text-center">Contribution </th>
                        <th class="text-center">Action </th>





                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($employees as $employee): ?>
                        <tr>
                            <td class="text-center"><?= $employee['employee_id'] ?></td>
                            <td><?= $employee['firstname'] ?>     <?= $employee['middlename'] ?>     <?= $employee['lastname'] ?>
                            </td>
                            <td><?= $employee['contribution_name'] ?></td>
                            <td>₱<?= number_format($employee['monthly_rate'], 2) ?></td>
                            <td>₱<?= number_format($employee['contribution_amount'], 2) ?></td>
                            <td>
                                <a href="/editPhilhealth/<?= $employee['id']; ?>" class="btn btn-primary btn"
                                    title="Edit Contribution"><i class="fa-solid fa-pen-to-square"></i> </a>
                            </td>





                        </tr>
                    <?php endforeach; ?>


                </tbody>

                <tfoot>
                    <tr>
                        <th class="text-center">Employee ID</th>
                        <th class="text-center">Employee Name</th>
                        <th class="text-center">Contribution Name</th>
                        <th class="text-center">Monthly Pay</th>
                        <th class="text-center">Salary Start Range </th>
                        <th class="text-center">Action </th>



                    </tr>
                </tfoot>

            </table>



        </div>
        <?php include('modal/edit_philhealth_modal.php'); ?>
    </div>



    <script>
        new DataTable('#table');


    </script>

    <?= $this->endSection(); ?>