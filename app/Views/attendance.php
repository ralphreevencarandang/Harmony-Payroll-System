<?=
    $this->extend('base');
$this->section('main_content');
?>

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

<div class="row">
    <div class="col">
        <h1>Attendance Table</h1>
    </div>


    <div class="d-flex">
        <a href="/dashboard">Home </a>
        <p class="mx-2"> > </p>
        <a href=""> Attendance</a>
    </div>


</div>

<div class="row">
    <div class="col-lg mb-3">
        <button class="btn btn-primary" onclick="printTable()">Print</button>
        <button class="btn btn-primary" onclick="confirmDownloadCSV()">CSV</button>
        <button class="btn btn-primary" onclick="confirmDownloadPDF()">PDF</button>
    </div>

    <div class="col-lg-3 me-3">
        <form action="<?= base_url('filterAttendance') ?>" method="GET">
            <div class="d-flex justify-content-center">

                <input type="date" name="date" class="form-control" id="dateInput" value="<?= $selected_date ?>">
                <button type="submit" class="btn btn-primary ms-3">Filter</button>
            </div>
        </form>
    </div>





</div>

<div class="row">


    <form action="/employeeAttendance" method="GET">


        <div class="row">
            <div class='col-lg-3 form-floating'>
                <select name="employee_id" id="floatingSelect" class="form-select">
                    <option value="">All Employee</option>
                    <?php foreach ($employeesmodel as $employee): ?>
                        <option value="<?= $employee['employee_id'] ?>" <?= isset($employee_id) && $employee_id == $employee['employee_id'] ? 'selected' : '' ?>>
                            <?= $employee['firstname'] . " " . $employee['middlename'] . " " . $employee['lastname'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>


                <label for="floatingSelect">Select Specific Employee</label>

            </div>
            <div class="col-6">
                <button type="submit" class="btn btn-primary">Filter</button>

            </div>
        </div>



    </form>




</div>





<div class="table-responsive">
    <table id="table" class="table table-striped w-100">
        <thead>
            <tr>
                <th class="text-center">Date</th>
                <th class="text-center">Employee ID</th>
                <th class="text-center">Personnel</th>
                <th class="text-center">Department</th>
                <th class="text-center">Shift</th>

                <th class="text-center">Actual-In</th>

                <th class="text-center">Actual-Out</th>
                <th class="text-center">Work Hours</th>
                <th class="text-center">Late Hour</th>
                <th class="text-center">Undertime Hour</th>

        </thead>
        <tbody>
            <?php foreach ($employees as $employee): ?>
                <tr class="text-center">
                    <td class="text-center"><?= $employee['date'] ?></td>
                    <td class="text-center"><?= $employee['employee_id'] ?></td>
                    <td class="text-center">
                        <?= $employee['firstname'] . " " . $employee['middlename'] . " " . $employee['lastname'] ?>
                    </td>
                    <td class="text-center"><?= $employee['department_name'] ?></td>
                    <td class="text-center">
                        <?= date('h:i A', strtotime($employee['emp_time_in'])) . ' - ' . date('h:i A', strtotime($employee['emp_time_out'])) ?>
                    </td>

                    <td class="text-center"><?= date('h:i A', strtotime($employee['att_time_in'])) ?></td>
                    <td class="text-center"><?= $employee['att_time_out'] ?></td>
                    <td class="text-center"><?= $employee['work_hours'] ?></td>
                    <td class="text-center"><?= $employee['late_hours'] ?></td>
                    <td class="text-center"><?= $employee['undertime_hours'] ?></td>


                </tr>

            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th>Date</th>
                <th>Employee ID</th>
                <th>Personnel</th>
                <th>Department</th>
                <th>Shift</th>
                <th>Actual-In</th>
                <th>Actual-Out</th>
                <th>Work Hours</th>
                <th>Late Hour</th>
                <th>Undertime Hour</th>

            </tr>
        </tfoot>
    </table>
</div>


<script>

    new DataTable('#table');


    // PRINT FUNCTION
    function printTable() {
        var printContent = document.getElementById("table").outerHTML;
        var originalContent = document.body.innerHTML;
        document.body.innerHTML = printContent;
        window.print();
        document.body.innerHTML = originalContent;
    }



    function confirmDownloadPDF() {
        const selectedDate = document.getElementById('dateInput').value;
        const employeeId = document.getElementById('floatingSelect').value;

        let url;

        // Decide URL based on available data
        if (employeeId) {
            url = `/attendance/downloadPDFEmployee?employee_id=${employeeId}`;
            if (selectedDate) {
                url += `&date=${selectedDate}`;
            }
        } else if (selectedDate) {
            url = `/attendance/downloadPDF?date=${selectedDate}`;
        } else {
            alert("Please select a date or employee before downloading the PDF.");
            return;
        }

        // Ask for confirmation before downloading the PDF
        if (confirm("Are you sure you want to download this as PDF?")) {
            window.location.href = url;
        }
    }




    function confirmDownloadCSV() {

        const selectedDate = document.getElementById('dateInput').value;
        const employeeId = document.getElementById('floatingSelect').value;


        let url;

        // Decide URL based on available data
        if (employeeId) {
            url = `/attendance/downloadCSVEmployee?employee_id=${employeeId}`;
            if (selectedDate) {
                url += `&date=${selectedDate}`;
            }
        } else if (selectedDate) {
            url = `/attendance/downloadCSV?date=${selectedDate}`;
        } else {
            alert("Please select a date or employee before downloading the PDF.");
            return;
        }

        // Ask for confirmation before downloading the PDF
        if (confirm("Are you sure you want to download this as CSV?")) {
            window.location.href = url;
        }

       
    }


    // Select Specific Employee


</script>

<?= $this->endSection(); ?>