<?=
$this->extend('base');
?>

<?= $this->section('main_content');?>

<div class="container">

    <div class="row">
        <div class="row">
            <div class="col">
                <h1>Add Loans</h1>
            </div>
        </div>

        <div class="d-flex">
            <a href="/dashboard">Home </a>
            <p class="mx-2"> > </p>
            <a href="/manageEmployee"> Loans</a>
            <p class="mx-2"> > </p>
            <a href="">Add Loans</a>
        </div>

    </div>

    
    <div class="mb-3">
        <label class="for-label">Employee ID</label>
        <input type="text" name="idNumber" class="form-control">
    </div>
    <div class="mb-3">
        <label class="for-label">Employee Name</label>
        <input type="text" name="name" class="form-control" readonly>
    </div>
    <div class="mb-3">
        <label class="for-label">Loan Provider</label>

        <select name="provider" class="form-control">
            <option value="sss">SSS</option>
            <option value="pagibig">Pagibig</option>
            <option value="philhealth">Philhealth</option>
        </select>
    </div>
    <div class="mb-3">
        <label class="for-label">Loan ID Number</label>
        <input type="text" name="loanIdNumber" class="form-control">
    </div>
    <div class="mb-3">
        <label class="for-label">Loan Amount</label>
        <input type="text" name="loanAmount" class="form-control">
    </div>
    <div class="mb-3">
        <label class="for-label">Monthly Deduction</label>
        <input type="text" name="monthlyDeduction" class="form-control">
    </div>
    <div class="mb-3">
        <label class="for-label">Start Date</label>
        <input type="date" name="startDate" class="form-control">
    </div>
    <div class="mb-3">
        <label class="for-label">End Date</label>
        <input type="date" name="endDate" class="form-control">
    </div>
    <div class="mb-3">
        <label class="for-label">Status</label>
        <select name="status" class="form-control">
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
        </select>
    </div>
    <div class="mb-3">
        <button type="submit" class="btn btn-primary">Add Loan</button>
    </div>

    <div class="mb-3">
        
    </div>
</div>

<?= $this->endSection();?>
