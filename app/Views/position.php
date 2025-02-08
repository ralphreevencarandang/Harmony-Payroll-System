<?= $this->extend('base'); ?>
<?= $this->section('main_content'); ?>

<style>
    #table td {
        text-align: center;
    }
</style>

<?php $isEditing = isset($position_column); ?>
<?php if ($isEditing): ?>
    <script>
        // Automatically show the modal if $holiday is set
        window.onload = function () {
            var updateModal = new bootstrap.Modal(document.getElementById('updateModal'));
            updateModal.show();
        };
    </script>

<?php endif; ?>



<div class="container-fluid">

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
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



    <div class="row">
        <div class="col">
            <h1>Position</h1>
        </div>
        <div class="col d-flex justify-content-end">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Add Position
            </button>

        </div>

        <div class="d-flex">
            <a href="/dashboard">Home </a>
            <p class="mx-2"> > </p>
            <a href=""> Add Position</a>
        </div>

    </div>

    <div class="row">

        <div class="table-responsive">
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
                    <?php foreach ($positions as $position): ?>
                        <tr>
                            <td><?= $position['position_id'] ?></td>
                            <td><?= $position['position_name'] ?></td>
                            <td><?= $position['position_description'] ?></td>
                            <td><?= $position['department_name'] ?></td>
                            <td>
                                <a href="/editPosition/<?= $position['position_id'] ?>" class="btn btn-primary btn-sm"><i
                                        class="fa-solid fa-pen-to-square"></i> Edit</a>
                                <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#confirmModal"
                                    data-id="<?= $position['position_id'] ?>"><i class="fa-solid fa-trash "></i>
                                    Delete</button>
                                <a href="/archivePosition/<?= $position['position_id']; ?>" class="btn btn-warning btn-sm"
                                    onclick="return archivePosition();"> <i class="fa-solid fa-box-archive"></i> Archive</a>

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


        </div>
    </div>

   
</div>




<?php include('modal/add_position_modal.php') ?>
<?php include('modal/edit_position_modal.php') ?>
<?php include('modal/delete_position_modal.php') ?>
<script>
    new DataTable('#table');


    function confirmUpdate() {
        return confirm('Are you sure you want to update this record?');
    }

    // Handle delete confirmation
    const confirmModal = document.getElementById('confirmModal');
    confirmModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget; // Button that triggered the modal
        const positionId = button.getAttribute('data-id'); // Extract info from data-* attributes

        // Update the confirmation link
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
        confirmDeleteBtn.href = '/deletePosition/' + positionId;
        document.getElementById('position_id').textContent = positionId;

    });


    function archivePosition() {
        return confirm('Are you sure you want to archive this data?');
    }


</script>



<?= $this->endSection() ?>