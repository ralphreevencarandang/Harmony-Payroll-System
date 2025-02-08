<?= $this->extend('base'); ?>
<?= $this->section('main_content'); ?>

<div class="container mt-5">


    <div class="card shadow-lg p-4">
        <div class="text-center">
            <?php if(!empty($employee['image'] ) ) :  ?>
                <img src="/uploads/<?=  $employee['image'] ?>" alt="Profile Picture" class="rounded-circle"
                    width="150" height="150">
             <?php else :?>   
                <img src="/images/HarmonyLogo.jpg" alt="Profile Picture" class="rounded-circle"
                width="150" height="150">
            <?php endif;?>
            <h2 class="mt-3">Employee Profile</h2>

        </div>

        <div class="card-body">
            <form>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="employeeId" class="form-label">Employee ID</label>
                        <input type="text" class="form-control" id="employeeId" value="<?= $employee['employee_id'] ?>"
                            readonly>
                    </div>
                    <div class="col-md-4">
                        <label for="employeeId" class="form-label">RFUID</label>
                        <input type="text" class="form-control" id="rfid_uid" value="<?= $employee['rfid_uid'] ?>"
                            readonly>
                    </div>
                    <div class="col-md-4">
                        <label for="firstname" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="firstname" value="<?= $employee['firstname'] ?>"
                            readonly>
                    </div>

                    <div class="col-md-4 mt-3">
                        <label for="middlename" class="form-label">Middle Name</label>
                        <input type="text" class="form-control" id="middlename" value="<?= $employee['employee_id'] ?>"
                            value="<?= $employee['middlename'] ?>" readonly>
                    </div>

                    

                    <div class="col-md-4 mt-3">
                        <label for="lastname" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="lastname" value="<?= $employee['lastname'] ?>"
                            readonly>
                    </div>
                    <div class="col-md-4 mt-3">
                        <label for="birthdate" class="form-label">Birthdate</label>
                        <input type="date" class="form-control" id="birthdate" value="<?= $employee['birthdate'] ?>"
                            readonly>
                    </div>
                    
                    <div class="col-md-4 mt-3">
                        <label for="sex" class="form-label">Sex</label>
                        <input type="text" class="form-control" id="sex" value="<?= $employee['sex'] ?>" readonly>
                    </div>

                    <div class="col-md-4 mt-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" value="<?= $employee['email'] ?>" readonly>
                    </div>
                    <div class="col-md-4 mt-3">
                        <label for="phoneNumber" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" id="phoneNumber" value="<?= $employee['phonenumber'] ?>"
                            readonly>
                    </div>  
                </div>

               
                   
          

                <h4 class="mt-4">Address</h4>
                <div class="row mb-3">

                    <div class="col-md-6">
                        <label for="region" class="form-label">Region</label>
                        <input type="text" class="form-control" id="region" value="<?= $employee['regDesc'] ?>"
                            readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="province" class="form-label">Province</label>
                        <input type="text" class="form-control" id="province" value="<?= $employee['provDesc'] ?>"
                            readonly>
                    </div>
                    <div class="col-md-4 mt-3">
                        <label for="municipality" class="form-label">Municipality</label>
                        <input type="text" class="form-control" id="municipality"
                            value="<?= $employee['citymunDesc'] ?>" readonly>
                    </div>
                    <div class="col-md-4 mt-3">
                        <label for="barangay" class="form-label">Barangay</label>
                        <input type="text" class="form-control" id="barangay" value="<?= $employee['brgyDesc'] ?>"
                            readonly>
                    </div>
                    <div class="col-md-4 mt-3">
                        <label for="houseNumber" class="form-label">House Number</label>
                        <input type="text" class="form-control" id="houseNumber" value="<?= $employee['street'] ?>"
                            readonly>
                    </div>
                </div>

                <h4 class="mt-4">Job Information</h4>
                <div class="row mb-3">
                    <div class="col-md-4 mt-3">
                        <label for="department" class="form-label">Department</label>
                        <input type="text" class="form-control" id="department"
                            value="<?= $employee['department_name'] ?>" readonly>
                    </div>
                    <div class="col-md-4 mt-3">
                        <label for="position" class="form-label">Position</label>
                        <input type="text" class="form-control" id="position" value="<?= $employee['position_name'] ?>"
                            readonly>
                    </div>
                    <div class="col-md-4 mt-3">
                        <label for="dateHired" class="form-label">Date Hired</label>
                        <input type="date" class="form-control" id="dateHired" value="<?= $employee['date_hired'] ?>"
                            readonly>
                    </div>
                    <div class="col-md-3 mt-3">
                        <label for="dailyRate" class="form-label">Daily Rate</label>
                        <input type="text" class="form-control" id="dailyRate" value="<?= $employee['daily_rate'] ?>"
                            readonly>
                    </div>
                    <div class="col-md-3 mt-3">
                        <label for="monthly_rate" class="form-label">Monthly Rate</label>
                        <input type="text" class="form-control" id="monthly_rate" value="<?= $employee['monthly_rate'] ?>"
                            readonly>
                    </div>
                    <div class="col-md-3 mt-3">
                        <label for="timeIn" class="form-label">Time In</label>
                        <input type="time" class="form-control" id="timeIn" value="<?= $employee['time_in'] ?>"
                            readonly>
                    </div>
                    <div class="col-md-3 mt-3">
                        <label for="timeOut" class="form-label">Time Out</label>
                        <input type="time" class="form-control" id="timeOut" value="<?= $employee['time_out'] ?>"
                            readonly>
                    </div>
                </div>

                <h4 class="mt-4">Accounts</h4>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="pagibig" class="form-label">Pag-IBIG Account Number</label>
                        <input type="text" class="form-control" id="pagibig"
                            value="<?= $employee['pagibig_account_number'] ?>" readonly>
                    </div>
                    <div class="col-md-4">
                        <label for="sss" class="form-label">SSS Account Number</label>
                        <input type="text" class="form-control" id="sss" value="<?= $employee['sss_account_number'] ?>"
                            readonly>
                    </div>
                    <div class="col-md-4">
                        <label for="philhealth" class="form-label">PhilHealth Account Number</label>
                        <input type="text" class="form-control" id="philhealth"
                            value="<?= $employee['philhealth_account_number'] ?>" readonly>
                    </div>
                </div>
            </form>
        </div>
    </div>


</div>

<?= $this->endSection(); ?>