<?=
    $this->extend('base');


?>
<?= $this->section('main_content'); ?>

<style>
    #table td {
        text-align: center;
    }
</style>

<div class="container-fluid">
    <div class="row">

        <div class="row">
            <div class="col">
                <h1>Activty Log</h1>
            </div>


            <div class="d-flex">
                <a href="/dashboard">Home </a>
                <p class="mx-2"> > </p>
                <a href=""> Activity Log</a>
            </div>

        </div>


        <div class="table-responsive">
            <table id="table" class="table table-striped">
                <thead>
                    <tr>
                        <th class="text-center">ID</th>
                        <th class="text-center">Date</th>
                        <th class="text-center">User ID</th>
                        <th class="text-center">Activity</th>
                        <th class="text-center">IP Address</th>
                     
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($logs as $log): ?>
                        <tr>
                            <td class="text-center"><?= $log['id'] ?></td>

                            <td class="text-center"><?= date('Y-m-d', strtotime($log['created_at'])) ?></td>
                            <td class="text-center"><?= $log['user_id'] ?></td>
                            <td class="text-start"><?= $log['activity']?></td>
                            <td class="text-center"><?= $log['ip_address'] ?></td>
                       





                        </tr>
                    <?php endforeach; ?>

                </tbody>
                <tfoot>
                    <tr>
                        <th class="text-center">ID</th>

                        <th class="text-center">Date</th>
                        <th class="text-center">User ID</th>
                        <th class="text-center">Activity</th>
                        <th class="text-center">IP Address</th>





                    </tr>
                </tfoot>
            </table>
        </div>
    </div>


    <script>
        new DataTable('#table');
    </script>



    <?= $this->endSection() ?>