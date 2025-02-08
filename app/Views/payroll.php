<?= $this->extend('base'); ?>
<?= $this->section('main_content'); ?>


<div class="container">
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

        <div class="row">
            <div class="col">
                <h1>Payroll List</h1>
            </div>
            <div class="col d-flex justify-content-end">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#generateModal">
                    Generate Payroll
                </button>
            </div>

            <div class="d-flex">
                <a href="/dashboard">Home </a>
                <p class="mx-2"> > </p>
                <a href=""> Payroll List</a>
            </div>

        </div>

        <div class="table-responsive">
            <table id="table" class="table table-striped">
                <thead>
                    <tr>
                        <th class="text-center">ID</th>
                        <th class="text-center">Refrence No.</th>
                        <th class="text-center">Date From</th>
                        <th class="text-center">Date To</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <?php foreach ($payrolls as $payroll): ?>
                        <tr>
                            <td><?= esc($payroll['payroll_id']) ?></td>
                            <td><?= esc($payroll['reference_number']) ?></td>
                            <td><?= date('M j, Y', strtotime(esc($payroll['date_from'])))  ?></td>
                            <td><?= date('M j, Y', strtotime(esc($payroll['date_to'])))  ?></td>
                            <td> <span class="badge bg-success">Calculated</span></td>
                            <td>
                                <a href="/payroll/view/<?= esc($payroll['reference_number']) ?>"
                                    class="btn btn-primary btn-sm">View</a>
                               
                                <a href="/archivePayroll/<?= esc($payroll['reference_number']) ?>"
                                    class="btn btn-warning btn-sm" onclick="return confirmArchive()">Archive</a>
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
        </div>
    </div>

    <!-- MODAL -->


    <?php include('modal/add_payroll_modal.php') ?>
    <script>
        new DataTable('#table');


        function confirmArchive(){
            return confirm('Are you sure you want to archive this payroll?');
        }
    </script>

    <?= $this->endSection(); ?>