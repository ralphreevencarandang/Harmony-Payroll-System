<?= $this->extend('base'); ?>
<?= $this->section('main_content'); ?>

<style>
    #table td {
        text-align: center;
    }
</style>

<?php $isEditing = isset($department_column); ?>

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
            <h1>Department</h1>
        </div>
        <div class="col d-flex justify-content-end">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Add Department
            </button>
            
        </div>

        <div class="d-flex">
            <a href="/dashboard">Home </a>

            <p class="mx-2"> > </p>
            <a href="/department"> Add Department</a>
        </div>

    </div>


    <div class="row">

        <div class="table-responsive">
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
                    <?php foreach ($departments as $department): ?>
                        <tr>
                            <td><?= $department['department_id']; ?></td>
                            <td><?= $department['department_name']; ?></td>
                            <td><?= $department['description']; ?></td>

                            <td class="text-center">
                                <a href="/editDepartment/<?= $department['department_id']; ?>"
                                    class="btn btn-primary btn" title="Edit Department"><i class="fa-solid fa-pen-to-square"></i> </a>

                                <a href="/archiveDepartment/<?= $department['department_id']; ?>"
                                    class="btn btn-warning btn" onclick="return archiveDepartment()" title="Archive Department"> <i
                                        class="fa-solid fa-box-archive"></i> </a>

                                <button class="btn btn-danger btn" data-bs-toggle="modal" data-bs-target="#confirmModal"
                                    data-id="<?= $department['department_id'] ?>" title="Delete Department"><i class="fa-solid fa-trash"></i>
                                    </button>

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
        </div>
    </div>


    
    

<!-- MODAL -->
    <?php include('modal/add_department_modal.php')?>
    <?php include('modal/edit_department_modal.php')?>
    <?php include('modal/delete_department_modal.php')?>
</div>

<script>
    new DataTable('#table');

    function confirmUpdate() {
        return confirm('Are you sure you want to update this record?');
    }

    // Handle delete confirmation
    const confirmModal = document.getElementById('confirmModal');
    confirmModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget; // Button that triggered the modal
        const departmentId = button.getAttribute('data-id'); // Extract info from data-* attributes

        // Update the confirmation link
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
        confirmDeleteBtn.href = '/deleteDepartment/' + departmentId;
        document.getElementById('department_id').textContent = departmentId;

    });


    function archiveDepartment() {
        return confirm('Are you sure you want to archive this data? ');
    }
</script>



<?= $this->endSection() ?>