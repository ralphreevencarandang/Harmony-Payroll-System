<?=
    $this->extend('base');
?>

<?= $this->section('main_content'); ?>


<div class="container">

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
        <div class="row">
            <div class="col">
                <h1>Add Employees</h1>
            </div>
        </div>

        <div class="d-flex">
            <a href="/dashboard">Home </a>
            <p class="mx-2"> > </p>
            <a href="/manageEmployee"> Employee</a>
            <p class="mx-2"> > </p>
            <a href="">Add Employee</a>
        </div>

    </div>

    <form action="/employeeForm/addEmployee" method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="row">
                <h3>Personal Details</h3>
            </div>


            <div class="col mb-2">

                <div class="mb-2">
                    <label class="form-label">Image</label>
                    <input type="file" name="profileImage" class="form-control" accept=".jpg, .jpeg, .png" required>
                </div>
                <div class="mb-2">
                    <label class="form-label">RFID UID</label>
                    <input type="text" name="rfid_uid" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label class="form-label">Firstname</label>
                    <input type="text" name="firstname" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label class="form-label">Middlename</label>
                    <input type="text" name="middlename" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label class="form-label">Lastname</label>
                    <input type="text" name="lastname" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label class="form-label">Sex</label>
                    <select name="sex" class="form-control" required>
                        <option value="Male">Male</option>
                        <option value="Male">Female</option>
                    </select>
                </div>
                <div class="mb-2">
                    <label class="form-label">Birthdate</label>
                    <input type="date" name="birthdate" class="form-control" max="2024-12-31" min="1924-01-01" required>
                </div>

                <div class="mb-2">
                    <label class="form-label">Region</label>
                    <select id="region" class="form-control" name="region">
                        <option value="">--- Select Region ---</option>
                        <?php foreach ($regions as $region): ?>
                            <option value="<?= $region['regCode']; ?>"><?= $region['regDesc']; ?></option>
                        <?php endforeach; ?>

                    </select>
                </div>
                <div class="mb-2">
                    <label class="form-label">Province</label>
                    <select name="province" class="form-control" id="province">
                        <option value="">--- Select Province ---</option>
                    </select>
                </div>
                <div class="mb-2">
                    <label class="form-label">Municipality</label>
                    <select name="municipality" class="form-control" id="municipality">

                        <option value="">--- Select Municipality ---</option>

                    </select>
                </div>
                <div class="mb-2">
                    <label class="form-label">Barangay</label>
                    <select name="barangay" class="form-control" id="barangay">

                        <option value="">--- Select Barangay ---</option>

                    </select>
                </div>


                <div class="mb-2">
                    <label class="form-label">Street / House No.</label>
                    <input type="text" name="street" class="form-control" required>
                </div>

                <div class="mb-2">
                    <label class="form-label">Phonenumber</label>
                    <input type="text" name="phonenumber" class="form-control" minlength="11" maxlength="11" required>
                </div>
            </div>

            <div class="col mb-2">
                <div class="mb-2">
                    <label class="form-label">Department</label>
                    <select name="department" class="form-control" id="department" required>
                        <option value="">--- Select Department ---</option>
                        <?php foreach ($departments as $department): ?>
                            <option value="<?= $department['department_id']; ?>"><?= $department['department_name']; ?>
                            </option>

                        <?php endforeach; ?>



                    </select>
                </div>
                <div class="mb-2">
                    <label class="form-label">Position</label>
                    <select name="position" class="form-control" id="position" required>
                        <option value="">--- Select Position ---</option>

                    </select>
                </div>
                <div class="mb-2">
                    <label class="form-label">Monthly Rate</label>
                    <input type="text" name="monthly_rate" class="form-control" id="monthlyRate" readonly>
                </div>
                <div class="mb-2">
                    <label class="form-label">Daily Rate</label>
                    <input type="number" name="daily_rate" class="form-control" id="dailyRate"  required>
                </div>
                <div class="mb-2">
                    <label class="form-label">Date Hired</label>
                    <input type="date" name="date_hired" class="form-control" max="2025-12-31"  min="1990-01-01" required>
                </div>

                <div class="mb-2">
                <label class="form-label">Rest Day</label>
                    <select name="restday" class="form-control">
                        <option value="Sunday">Sunday</option>
                        <option value="Monday">Monday</option>
                        <option value="Tuesday">Tuesday</option>
                        <option value="Wednesday">Wednesday</option>
                        <option value="Thursday">Thursday</option>
                        <option value="Friday">Friday</option>
                        <option value="Saturday">Saturday</option>
                    </select>
                </div>
                <div class="mb-2">
                    <label class="form-label">Shift In</label>
                    <input type="time" name="time_in" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label class="form-label">Shift Out</label>
                    <input type="time" name="time_out" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control" required>

                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>

                <div class="mb-2">
                    <label class="form-label">Pagibig Account Number: </label>

                    <input type="text" name="pagibig" class="form-control" maxlength="12" pattern="\d{12}" inputmode="numeric" required>
                    <p class="text-danger" style="font-size: 0.9rem">*Please input the 12 digit of pagibig ID *</p>
                </div>
                <div class="mb-2">
                    <label class="form-label">SSS Account Number: </label>
                    <input type="text" name="sss" class="form-control" maxlength="10" pattern="\d{10}" inputmode="numeric" required>
                    <p class="text-danger" style="font-size: 0.9rem">*Please input the 10 digit of SSS ID *</p>

                </div>
                <div class="mb-2">
                    <label class="form-label">Philhealth Account Number: </label>
                    <input type="text" name="philhealth" class="form-control" maxlength="12" pattern="\d{12}" inputmode="numeric" required>
                    <p class="text-danger" style="font-size: 0.9rem">*Please input the 12 digit of Philhealth ID *</p>

                </div>


            </div>

            <div class="mb-2">
                <button type="submit" class="btn btn-primary w-100">Add Employee</button>
            </div>

    </form>

</div>





</div>

<script>
    $(document).ready(function () {
        // On region change, fetch provinces
        $('#region').change(function () {
            var regCode = $(this).val();
            $.ajax({
                url: "<?= site_url('employeeForm/getProvinces'); ?>",
                method: "POST",
                data: { regCode: regCode },
                dataType: 'json',
                success: function (data) {
                    $('#province').empty();
                    $('#province').append('<option value="">--- Select Province ---</option>');
                    $.each(data, function (key, value) {
                        $('#province').append('<option value="' + value.provCode + '">' + value.provDesc + '</option>');
                    });
                }
            });
        });

        // On province change, fetch municipalities
        $('#province').change(function () {
            var provCode = $(this).val();
            $.ajax({
                url: "<?= site_url('employeeForm/getMunicipalities'); ?>",
                method: "POST",
                data: { provCode: provCode },
                dataType: 'json',
                success: function (data) {
                    $('#municipality').empty();
                    $('#municipality').append('<option value="">--- Select Municipality ---</option>');
                    $.each(data, function (key, value) {
                        $('#municipality').append('<option value="' + value.citymunCode + '">' + value.citymunDesc + '</option>');
                    });
                }
            });
        });

        // On municipality change, fetch barangays
        $('#municipality').change(function () {
            var citymunCode = $(this).val();
            $.ajax({
                url: "<?= site_url('employeeForm/getBarangays'); ?>",
                method: "POST",
                data: { citymunCode: citymunCode },
                dataType: 'json',
                success: function (data) {
                    $('#barangay').empty();
                    $('#barangay').append('<option value="">--- Select Barangay ---</option>');
                    $.each(data, function (key, value) {
                        $('#barangay').append('<option value="' + value.id + '">' + value.brgyDesc + '</option>');
                    });
                }
            });
        });
    });



    $('#department').change(function () {
        var department_id = $(this).val();
        $.ajax({
            url: "<?= site_url('employeeForm/getPosition'); ?>",
            method: "POST",
            data: { department_id: department_id },
            dataType: 'json',
            success: function (data) {
                $('#position').empty();
                $('#position').append('<option value="">--- Select Position ---</option>');
                $.each(data, function (key, value) {
                    $('#position').append('<option value="' + value.position_id + '">' + value.position_name + '</option>');
                });
            }
        });
    });


    $('form').on('submit', function (e) {
        // Validate province
        let region = $('#region').val();
        let province = $('#province').val();
        let municipality = $('#municipality').val();
        let barangay = $('#barangay').val();
        let department = $('#department').val();
        let position = $('#position').val();
        let pagibig = document.getElementsByName('pagibig').val();
        let sss = document.getElementsByName('sss').val();
        let philheath = document.getElementsByName('philheath').val();
        if (region === "") {
            e.preventDefault(); // Prevent form submission
            alert("Please select a region."); // Show alert or error message
        }
        else if (province === "") {
            e.preventDefault(); // Prevent form submission
            alert("Please select a province."); // Show alert or error message
        }
        else if (municipality === "") {
            e.preventDefault(); // Prevent form submission
            alert("Please select a municipality."); // Show alert or error message
        }
        else if (barangay === "") {
            e.preventDefault(); // Prevent form submission
            alert("Please select a barangay."); // Show alert or error message
        } else if (department === "") {
            e.preventDefault(); // Prevent form submission
            alert("Please select a department."); // Show alert or error message

        } else if (position === "") {
            e.preventDefault(); // Prevent form submission
            alert("Please select a position."); // Show alert or error message
        }

    });


  

    


</script>

<script>

document.getElementById('dailyRate').addEventListener('input', function () {
        const dailyRate = parseFloat(this.value) || 0;
        const monthlyRate = (dailyRate * 314)/12;
        document.getElementById('monthlyRate').value = monthlyRate.toFixed(2);
    });


</script>



<?= $this->endSection() ?>