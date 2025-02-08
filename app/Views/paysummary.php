<?= $this->extend('base'); ?>
<?= $this->section('main_content'); ?>



<div class="container my-5">
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissble show fade" role="alert">
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
    <h1 class="text-center mb-4">Employee Pay Summary</h1>

    <div class="d-flex justify-content-between">
        <p><strong>Employee ID:</strong> <i><?= $payroll['employee_id'] ?></i></p>
        <p><strong>Name:</strong> <i><?= $payroll['firstname'] ?> <?= $payroll['middlename'] ?>
                <?= $payroll['lastname'] ?></i></p>
        <p><strong>Department:</strong><i> <?= $payroll['department_name'] ?></i></p>
        <p><strong>Position:</strong> <i><?= $payroll['position_name'] ?></i> </p>



    </div>






    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>Category</th>
                <th>Amount (PHP)</th>
            </tr>
        </thead>
        <tbody>


            <tr>
                <td>Monthly Rate</td>
                <td>₱ <?= number_format($payroll['monthly_rate'], 2) ?></td>
            </tr>
            <tr>
                <td>Daily Rate</td>
                <td>₱ <?= number_format($payroll['daily_rate'], 2) ?></td>
            </tr>
            <tr>
                <td>No. of Days</td>
                <td><?= $payroll['total_days'] ?></td>
            </tr>
            <tr>
                <td>Basic Salary</td>
                <td>₱ <?= number_format($payroll['basic_salary'], 2) ?></td>
            </tr>

            <tr>
                <td>OT Hour</td>
                <td> <?= $payroll['total_overtime_hours'] ?></td>
            </tr>
            <tr>
                <td>OT Amount</td>
                <td>₱ <?= number_format($payroll['overtime_amount'], 2) ?></td>
            </tr>

            <tr>
                <td>Rest Day Amount</td>
                <td>₱ <?= number_format($payroll['restday_amount'], 2) ?> </td>
            </tr>
            <tr>
                <td>Late Hours</td>
                <td><?= $payroll['total_late_hours'] ?></td>
            </tr>
            <tr>
                <td>Sick Leave</td>
                <td><?= $payroll['sick_leave_balance'] ?> / 5</td>
            </tr>
            <tr>
                <td>Vacation Leave</td>
                <td><?= $payroll['vacation_leave_balance'] ?> / 5</td>
            </tr>
            <tr>
                <td>Late Amount</td>
                <td>- ₱ <?= number_format($payroll['late_amount'], 2) ?></td>
            </tr>
            <tr>
                <td>Holiday Premium</td>
                <td>₱ <?= number_format($payroll['holiday_premium'], 2) ?></td>
            </tr>
            <tr>
                <td>Net Basic</td>
                <td>₱ <?= number_format($payroll['net_pay'], 2) ?></td>
            </tr>
            <tr>
                <td>Philhealth</td>
                <td>- ₱ <?= isset($contributions['Philhealth']) ? number_format($contributions['Philhealth'], 2) : '-' ?>
                </td>
            </tr>
            <tr>
                <td>SSS</td>
                <td>- ₱ <?= isset($contributions['SSS']) ? number_format($contributions['SSS'], 2) : '-' ?></td>
            </tr>
            <tr>
                <td>Pagibig</td>
                <td>- ₱ <?= isset($contributions['Pag Ibig']) ? number_format($contributions['Pag Ibig'], 2) : '-' ?></td>
            </tr>
            <?php foreach ($manualPayheads as $payhead): ?>
                <tr>
                    <td><?= esc($payhead['payhead_name']) ?> </td>
                    <td><?=  ucfirst($payhead['head_type']) ==  'Earnings' ? '' : '-' ?> ₱ <?= number_format($payhead['amount'], 2) ?> </td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td>Total Deductions</td>
                <td>₱ <?= number_format($payroll['deductions'], 2) ?></td>
            </tr>
            <tr>
                <td><strong>Final Net Pay</strong></td>
                <td><strong>₱ <?= number_format($payroll['final_netpay'], 2) ?></strong></td>
            </tr>



        </tbody>


    </table>
    <div class="d-flex justify-content-center">
    <a href="<?= site_url('/download/' . $payroll['employee_id'] . '/' . $payroll['reference_number']) ?>" class="btn btn-success">
    <i class="fa-solid fa-download fa-shake"></i> Download PDF
</a>
    </div>

</div>


<?= $this->endSection(); ?>