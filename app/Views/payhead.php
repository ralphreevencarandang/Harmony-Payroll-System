<?= $this->extend('base'); ?>
<?= $this->section('main_content'); ?>

<?php $isEditing = isset($payhead_column)?>

<?php if ($isEditing): ?>
    <script>
        // Automatically show the modal if $payhead is set
        window.onload = function () {
            var updateModal = new bootstrap.Modal(document.getElementById('updateModal'));
            updateModal.show();
        };
    </script>
<?php endif; ?>


<div class="container-fluid">

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('error') ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

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
                <h1>Default Payheads</h1>
            </div>
            <div class="col d-flex justify-content-end">
                <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Add Payheads
                </button> -->
            </div>

            <div class="d-flex">
                <a href="/dashboard">Home </a>
                <p class="mx-2"> > </p>
                <a href=""> Payheads</a>
                <p class="mx-2"> > </p>
                <a href=""> Automatic</a>
            </div>

        </div>


        <div class="table-responsive">
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
                    <?php foreach ($payheads as $payhead): ?>
                        <tr>
                            <td class="text-center"><?= $payhead['payhead_id'] ?></td>
                            <td><?= $payhead['payhead_name'] ?></td>
                            <td><?= $payhead['description'] ?></td>
                            <td class="text-center"><?= $payhead['amount'] ?></td>

                            <td><span
                                    class="badge <?= $payhead['payhead_type'] == 'Earnings' ? 'bg-success' : 'bg-danger' ?>"><?= $payhead['payhead_type'] ?></span>
                            </td>



                            <td class="text-center">
                                <a href="/editPayhead/<?= $payhead['payhead_id']?>" class="btn btn-primary btn-sm" title="Edit Payhead"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                               

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
        </div>
    </div>

   
</div>



<!-- Modal -->
 <?php include('modal/add_payhead_modal.php')?>
 <?php include('modal/edit_payhead_modal.php')?>
 <?php include('modal/delete_payhead_modal.php')?>

<script>
    new DataTable('#table');

    function confirmUpdate() {
        return confirm("Are you sure you want to update this record?");
    }
    function archivePayhead() {
        return confirm("Are you sure you want to archive this data?");
    }

    // Handle delete confirmation
    const confirmModal = document.getElementById('confirmModal');
    confirmModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget; // Button that triggered the modal
        const payheadId = button.getAttribute('data-id'); // Extract info from data-* attributes

        // Update the confirmation link
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
        confirmDeleteBtn.href = '/deletePayhead/' + payheadId;
        document.getElementById('payhead_id').textContent = payheadId;

    });


</script>

<?= $this->endSection(); ?>