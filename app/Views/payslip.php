<?= $this->extend('base'); ?>
<?= $this->section('main_content'); ?>


<div class="container">
    <div class="row">

        <div class="row">
            <div class="col">
                <h1>Payslip</h1>
            </div>

          
            <div class="d-flex">
                <a href="/dashboard">Home </a>
                <p class="mx-2"> > </p>
                <a href=""> Payslips</a>
            </div>

        </div>


        <div class="table-responsive">
            <table id="table" class="table table-striped">
                <thead>
                    <tr>
                        <th class="text-center">Employee ID</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Salary Date</th>
                        <th class="text-center">Earnings</th>
                        <th class="text-center">Deductions</th>
                        <th class="text-center">Net Salary</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <tr >
                        <td class="text-center">010111</td>
                        <td class="text-center">Ralph Reeven Carnadang</td>
                        <td class="text-center">05-20-24</td>
                        <td class="text-center">25,000.00</td>
                        <td class="text-center">5,000.00</td>
                        <td class="text-center">20,000.00</td>

                        <td class="text-center">
                        
                            <a href="" class="btn btn-success btn-sm">Download</a>
                        </td>
                    </tr>
  
                   

                </tbody>
                <tfoot>
                    <tr>
                        <th class="text-center">Employee ID</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Salary Date</th>
                        <th class="text-center">Earnings</th>
                        <th class="text-center">Deductions</th>
                        <th class="text-center">Net Salary</th>
                        <th class="text-center">Action</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>


    <script>
        new DataTable('#table');
    </script>

    <?= $this->endSection(); ?>