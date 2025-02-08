<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <title>Paysummary PDF</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            display: flex;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .table th {
            background-color: #f2f2f2;
        }

        .signature-container {
            width: 100%;
            text-align: justify;
            /* Distribute items evenly */
            margin-top: 20px;
            position: relative;
            top: 80px;
            left: 150px;
            text-align: center;
        }

        .signature-container div {
            display: inline-block;
            width: 30%;
            /* Adjust width as needed */
            text-align: center;
        }

        .info-container {
            width: 100%;
            text-align: justify;
            /* Distribute items evenly */
            margin-bottom: 20px;
        }


        .info-container p {
            display: inline-block;
            width: 49%;
            /* Adjust width as needed */
            text-align: left;
            /* Optional: ensures the text is aligned left */
            margin: 0;
            padding: 0;
        }
    
    </style>

</head>

<body>


    <h1>Employee Pay Summary</h1>
    <div class="payroll-info">
        <p><strong>Payroll ID:</strong> <i> <?= $payroll['reference_number'] ?></i> </p>

        <p><strong>Payroll Date:</strong> <i> <?= date('M j, Y', strtotime($payroll['pay_period_start'])) ?> -
                <?= date('M j, Y', strtotime($payroll['pay_period_end'])) ?></i> </p>
    </div>

    <div class="info-container">

        <div>
            <p><strong>Employee ID:</strong> <i> <?= $payroll['employee_id'] ?></i> </p>
            <p><strong>Name:</strong> <i><?= $payroll['firstname'] ?> <?= $payroll['middlename'] ?>
                    <?= $payroll['lastname'] ?></i> </p>
        </div>
        <div>
            <p><strong>Department:</strong> <i> <?= $payroll['department_name'] ?></i></p>
            <p><strong>Position:</strong> <i><?= $payroll['position_name'] ?></i> </p>
        </div>

    </div>




    <table class="table">
        <thead>
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
                <td>- ₱
                    <?= isset($contributions['Philhealth']) ? number_format($contributions['Philhealth'], 2) : '-' ?>
                </td>
            </tr>
            <tr>
                <td>SSS</td>
                <td>- ₱ <?= isset($contributions['SSS']) ? number_format($contributions['SSS'], 2) : '-' ?></td>
            </tr>
            <tr>
                <td>Pagibig</td>
                <td>- ₱ <?= isset($contributions['Pag Ibig']) ? number_format($contributions['Pag Ibig'], 2) : '-' ?>
                </td>
            </tr>
            <?php foreach ($manualPayheads as $payhead): ?>
                <tr>
                    <td><?= esc($payhead['payhead_name']) ?> </td>
                    <td><?= ucfirst($payhead['head_type']) == 'Earnings' ? '' : '-' ?> ₱
                        <?= number_format($payhead['amount'], 2) ?>
                    </td>
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

        <div class="signature-container">
            <div>
                <p>Prepared by:</p>
            </div>
            <div>
                <p>Verified by:</p>
            </div>
            <div>
                <p>Approved by:</p>
            </div>
        </div>


    </table>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</body>

</html>