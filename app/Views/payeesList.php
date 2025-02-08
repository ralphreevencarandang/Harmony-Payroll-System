<?= $this->extend('base'); ?>
<?= $this->section('main_content') ?>


<div class="container-fluid ">

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
        <div class="d-flex">
            <h4><strong>Payroll ID: <?= $referenceNumber ?></strong></h4>
        </div>
    </div>

    <div class="row">
        <p><strong>Payroll Range: <?= $payrollRange ?> </strong></p>
    </div>
    <div class="col-lg mb-3">
        <button class="btn btn-primary" onclick="printTable()">Print</button>
        <button class="btn btn-primary" onclick="exportToCSV()">CSV</button>
        <button class="btn btn-primary" onclick="downloadPDF()">PDF</button>
    </div>

    <div class="row">
        <hr>
        <div class="table-responsive">
            <table id="table" class="table table-striped">
                <thead>
                    <tr>
                        <th class="text-center">Employee ID</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Total Days</th>
                        <th class="text-center">Late Amount</th>
                        <th class="text-center">Underime Amount</th>
                        <th class="text-center">Overtime Amount</th>
                        <th class="text-center">Total Deduction</th>
                        <th class="text-center">Net Pay</th>
                        <th class="text-center">Final Net Pay</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <?php foreach ($payrolls as $payroll): ?>
                        <tr>
                            <td class="text-center"><?= $payroll['employee_id'] ?></td>
                            <td class="text-center">
                                <?= $payroll['firstname'] . " " . $payroll['middlename'] . " " . $payroll['lastname'] ?>
                            </td>
                            <td class="text-center"><?= $payroll['total_days'] ?></td>
                            <td class="text-center"><?= $payroll['late_amount'] ?></td>
                            <td class="text-center"><?= $payroll['undertime_amount'] ?></td>
                            <td class="text-center"><?= $payroll['overtime_amount'] ?></td>
                            <td class="text-center"><?= $payroll['deductions'] ?></td>
                            <td class="text-center"><?= $payroll['net_pay'] ?></td>
                            <td class="text-center"><?= $payroll['final_netpay'] ?></td>


                            <td class="text-center">

                                <a href="/paysummary/<?= $payroll['employee_id'] ?>/<?= $payroll['reference_number'] ?>"
                                    class="btn btn-success btn-sm">View</a>

                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th class="text-center">Employee ID</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Total Days</th>
                        <th class="text-center">Late Amount</th>
                        <th class="text-center">Underime Amount</th>

                        <th class="text-center">Overtime Amount</th>
                        <th class="text-center">Total Deduction</th>

                        <th class="text-center">Net Pay</th>
                        <th class="text-center">Final Net Pay</th>
                        <th class="text-center">Action</th>

                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<!-- Include jsPDF and autoTable library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.23/jspdf.plugin.autotable.min.js"></script>

<style>
    @media print {
        @page {
            size: A4 landscape;
            margin: 20mm;
        }

        body {
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }

        .btn,
        .alert,
        hr {
            display: none !important;
        }
    }
</style>
<script>
    new DataTable('#table');

    // Initialize DataTable
    new DataTable('#table');

    // Print table function
    function printTable() {
        const printContents = document.querySelector('.container-fluid').innerHTML;
        const originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        window.location.reload(); // Reload the page to restore original view
    }

    // CSV Export Function
    function exportToCSV() {
        let csvContent = "data:text/csv;charset=utf-8,";
        const table = document.getElementById("table");
        const rows = table.querySelectorAll("tr");

        // Extract rows from the table
        rows.forEach(row => {
            let rowData = [];
            row.querySelectorAll("th, td").forEach(cell => {
                rowData.push(cell.textContent.trim());
            });
            csvContent += rowData.join(",") + "\n";
        });

        // Create a download link and trigger it
        const encodedUri = encodeURI(csvContent);
        const link = document.createElement("a");
        link.setAttribute("href", encodedUri);
        link.setAttribute("download", "payroll_data.csv");
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }

    // PDF Download Function
    async function downloadPDF() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();

        // Get dynamic data for the header
        const referenceNumber = "<?= $referenceNumber ?>";
        const payrollRange = "<?= $payrollRange ?>";
        const downloadDate = new Date().toLocaleDateString();

        // PDF Header
        doc.setFontSize(12);
        doc.text(`Payroll Report`, 14, 10);
        doc.setFontSize(10);
        doc.text(`Reference Number: ${referenceNumber}`, 14, 16);
        doc.text(`Payroll Date Range: ${payrollRange}`, 14, 22);
        doc.text(`Downloaded on: ${downloadDate}`, 14, 28);

        // Add table data
        doc.autoTable({
            html: '#table',
            startY: 35,
            theme: 'grid',
            headStyles: { fillColor: [22, 160, 133] },
            columnStyles: {
                0: { cellWidth: 20 },
                1: { cellWidth: 30 },
                2: { cellWidth: 15 },
                3: { cellWidth: 20 }
            },
            styles: { fontSize: 8 }
        });

        // Save the PDF
        doc.save(`payroll_report_${referenceNumber}.pdf`);
    }
</script>





<?= $this->endSection() ?>