<?= $this->extend('base'); ?>
<?= $this->section('main_content'); ?>


<style>
    table td{
        font-size: 14px;
    }
</style>
<?php $isEditing = isset($leave_column) ?>

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
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
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
                <h1>Leaves</h1>
            </div>
            <div class="col d-flex justify-content-end">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#leaveModal">
                    Add Leaves
                </button>



            </div>

            <div class="d-flex">
                <a href="/dashboard">Home </a>
                <p class="mx-2"> > </p>
                <a href=""> Leaves</a>
            </div>

        </div>


        <div class="table-responsive">
            <table id="table" class="table table-striped text-center">
                <thead>
                    <tr>
                        <th class="text-center">Leave ID</th>
                        <th class="text-center">Employee ID</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Leave Type</th>
                        <th class="text-center">Reason</th>

                        <th class="text-center">Leave Start Date</th>
                        <th class="text-center">Leave End Date</th>
                        <th class="text-center">No. of Days</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <?php foreach ($leaves as $leave): ?>


                        <tr>

                            <td class="text-center"><?= $leave['leave_id'] ?></td>
                            <td class="text-center"><?= $leave['employee_id'] ?></td>
                            <td class="text-center"><?= $leave['firstname'], " ", $leave['middlename'], " ", $leave['lastname'] ?></td>
                            <td class="text-center"><?= $leave['leave_type'] ?></td>
                            <td class="text-center"><?= $leave['reason'] ?></td>

                            <td class="text-center"><?= $leave['leave_start_date'] ?></td>
                            <td class="text-center"><?= $leave['leave_end_date'] ?></td>
                            <td class="text-center"><?= $leave['number_of_days'] ?></td>
                            <td class="text-center">

                                    <a href="/editLeave/<?= $leave['leave_id'] ?>" class="btn btn-primary btn-sm " title="Edit Leave"><i
                                            class="fa-solid fa-pen-to-square"></i></a>

                                    <a href="/archiveLeave/<?= $leave['leave_id'] ?>" class="btn btn-warning btn-sm"
                                        onclick="return archiveLeave()" title="Archive Leave"> <i class="fa-solid fa-box-archive"></i>
                                        </a>

                                    <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#deleteLeave" data-id="<?= $leave['leave_id'] ?>" title="Delete Leave"><i
                                            class="fa-solid fa-trash" ></i> </button>

                                

                            </td>
                        </tr>

                    <?php endforeach; ?>

                </tbody>
                <tfoot>
                    <tr>
                    <th class="text-center">Leave ID</th>
                        <th class="text-center">Employee ID</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Leave Type</th>
                        <th class="text-center">Reason</th>

                        <th class="text-center">Leave Start Date</th>
                        <th class="text-center">Leave End Date</th>
                        <th class="text-center">No. of Days</th>

                        <th class="text-center">Action</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>


</div>



<!-- Modal -->
<?php include('modal/add_leave_modal.php') ?>
<?php include('modal/delete_leave_modal.php') ?>
<?php include('modal/edit_leave_modal.php') ?>


<script>
    new DataTable('#table');

    function confirmUpdate() {
        return confirm("Are you sure you want to update this record?");
    }
    function archiveLeave() {
        return confirm("Are you sure you want to archive this data?");
    }


    // Handle delete confirmation
    const deleteLeave = document.getElementById('deleteLeave');
    deleteLeave.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget; // Button that triggered the modal
        const leaveId = button.getAttribute('data-id'); // Extract info from data-* attributes

        // Update the confirmation link
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
        confirmDeleteBtn.href = '/deleteLeave/' + leaveId;
        document.getElementById('leave_id').textContent = leaveId;

    });


</script>


<script>
    $('#department').change(function () {
        var department_id = $(this).val();
        $.ajax({
            url: "<?= site_url('leave/getEmployee'); ?>",
            method: "POST",
            data: { department_id: department_id },
            dataType: 'json',
            success: function (data) {
                $('#employee_id').empty();
                $('#employee_id').append('<option value="">--- Select Employee ---</option>');
                $.each(data, function (key, value) {
                    $('#employee_id').append('<option value="' + value.employee_id + '">' + value.firstname + " " + value.middlename + " " + value.lastname + '</option>');
                });
            }
        });
    });
</script>




<?= $this->endSection(); ?>