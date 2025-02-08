<?= $this->extend('base'); ?>
<?= $this->section('main_content'); ?>


<?php
$isEditing = isset($contribution_column)
    ?>

<?php if ($isEditing): ?>
    <script>
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

        <form action="/addContributionList" method="post">

            <div class="row">
                <div class="col">
                    <h1>Contribution List</h1>
                </div>
                <div class="col d-flex justify-content-end">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Add Contribution
                    </button>

                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Add Contribution</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Contribution Name: </label>
                                        <input type="text" name="contributionName" class="form-control" required>

                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Contribution Description: </label>
                                        <input type="text" name="contributionDescription" class="form-control" required>
                                    </div>




                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex">
                    <a href="/dashboard">Home </a>
                    <p class="mx-2"> > </p>
                    <a href=""> Contribution </a>

                    <p class="mx-2"> > </p>
                    <a href=""> Contribution List</a>
                </div>

            </div>

        </form>




        <div class="table-responsive">
            <table id="table" class="table table-striped text-center">
                <thead>
                    <tr>
                        <th class="text-center">Employee ID</th>
                        <th class="text-center">Employee Name</th>
                        <th class="text-center">Contribution Name</th>
                        <th class="text-center">Monthly Pay</th>

                        <th class="text-center">SSS </th>
                        <th class="text-center">Philhealth </th>
                        <th class="text-center">Pagibig </th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>

                        <?php foreach ($contributions as $contribution): ?>
                            <tr>
                                <td class="text-center"><?= $contribution['id'] ?></td>
                                <td>Ralph Reeven Carandang</td>
                                <td><?= $contribution['contribution_name'] ?></td>
                                <td><?= 3600 ?></td>

                                <td><?= '450' ?></td>
                                <td><?= '450' ?></td>
                                <td><?= '450' ?></td>


                                <td class="text-center">

                                    <a href="/editContributionList/<?= $contribution['id'] ?>"
                                        class="btn btn-warning btn-sm">Edit</a>

                                    <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#confirmModal"
                                        data-id="<?= $contribution['id'] ?>">Delete</button>
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

                        <th class="text-center">SSS </th>
                        <th class="text-center">Philhealth </th>
                        <th class="text-center">Pagibig </th>
                        <th class="text-center">Action</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!--  DELETE MODAL -->
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmModalLabel">Confirm Action</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this Contribution ID <span id="contribution_id"></span>?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <a href="" class="btn btn-danger" id="confirmDeleteBtn">Delete</a>
                </div>
            </div>
        </div>
    </div>

    <!-- UPDATE MODAL -->

    <form onsubmit="return confirmUpdate()"
        action="/updateContributionList/<?= $isEditing ? $contribution_column['id'] : '' ?>"
        method="post">
        <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Update Contribution</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Contribution Name: </label>
                            <input type="text" name="contributionName" class="form-control"
                                value="<?= $isEditing ? $contribution_column['contribution_name'] : '' ?>" required>

                        </div>

                        




                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>

        </div>

    </form>

    <script>
        new DataTable('#table');

        // Handle delete confirmation
        const confirmModal = document.getElementById('confirmModal');
        confirmModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget; // Button that triggered the modal
            const conrtibution_id = button.getAttribute('data-id'); // Extract info from data-* attributes

            // Update the confirmation link
            const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
            confirmDeleteBtn.href = '/deleteContributionList/' + conrtibution_id;
            document.getElementById('contribution_id').textContent = conrtibution_id;

        });

        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>

    <?= $this->endSection(); ?>