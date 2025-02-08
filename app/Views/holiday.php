<?= $this->extend('base'); ?>
<?= $this->section('main_content'); ?>

<?php $isEditing = isset($holiday_column); ?>

<?php if ($isEditing): ?>
    <script>
        // Automatically show the modal if $holiday is set
        window.onload = function () {
            var updateModal = new bootstrap.Modal(document.getElementById('updateModal'));
            updateModal.show();
        };
    </script>
<?php endif; ?>



<div class="row">

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('error'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>

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
            <h1>List of Holidays</h1>
        </div>
        <div class="col d-flex justify-content-end">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Add Holidays
            </button>

        </div>
    </div>

    <div class="d-flex">
        <a href="/dashboard">Home </a>
        <p class="mx-2"> > </p>
        <a href="/holiday"> List of Holidays</a>

    </div>

</div>





<div class="table-responsive">
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
            <?php foreach ($holidays as $holiday): ?>
                <tr>
                    <td class="text-center"><?= $holiday['holiday_id']; ?></td>
                    <td><?= $holiday['holiday_title']; ?></td>

                    <td><?= $holiday['holiday_description']; ?></td>

                    <td><?= date('F j, Y', strtotime($holiday['holiday_date'])) ?></td>
                    <td><span
                            class="badge <?= $holiday['holiday_type'] == 'Regular' ? 'bg-success' : 'bg-danger' ?>"><?= $holiday['holiday_type']; ?></span>
                    </td>
                    <td>
                        <a href="/editHoliday/<?= $holiday['holiday_id'] ?>" class="btn btn-primary btn-sm" title="Edit Holiday"><i
                                class="fa-solid fa-pen-to-square"></i> </a>
                        <a href="/archiveHoliday/<?= $holiday['holiday_id']; ?>" class="btn btn-warning btn-sm"
                            onclick="return archiveHoliday()" title="Archive Holiday"> <i class="fa-solid fa-box-archive"></i> </a>

                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#confirmModal"
                            data-id="<?= $holiday['holiday_id'] ?>" title="Delete Holiday"><i class="fa-solid fa-trash "></i> </button>

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

 


</div>






<!-- MODAL  -->
<?php include('modal/add_holiday_modal.php') ?>
<?php include('modal/edit_holiday_modal.php') ?>
<?php include('modal/delete_holiday_modal.php') ?>

<script>
    new DataTable('#table');

    function confirmUpdate() {
        return confirm("Are you sure you want to update this record?");
    }
    function archiveHoliday() {
        return confirm("Are you sure you want to archive this holiday?");
    }

    // Handle delete confirmation
    const confirmModal = document.getElementById('confirmModal');
    confirmModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget; // Button that triggered the modal
        const holidayId = button.getAttribute('data-id'); // Extract info from data-* attributes

        // Update the confirmation link
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
        confirmDeleteBtn.href = '/deleteHoliday/' + holidayId;
        document.getElementById('holidayId').textContent = holidayId;

    });

</script>


<?= $this->endSection(); ?>