<?= $this->extend('base'); ?>

<?= $this->section('main_content'); ?>

<div class="container">
    <div class="row">
        <div class="row">
            <div class="col">
                <h1>Contribution Form</h1>
            </div>

            <div class="col d-flex justify-content-end">
              

                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Add Contribution</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Contribution Type: </label>
                                    <select name="contributionType" class="form-control">
                                        <option value="Pagibig">Pagibig</option>
                                        <option value="Pagibig">SSS</option>
                                        <option value="Pagibig">Philhealth</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Salary Start Range: </label>
                                    <input type="number" name="startRange" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Salary End Range: </label>
                                    <input type="number" name="endRange" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Employee Share: </label>
                                    <input type="number" name="employeeShare" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Employer Share: </label>
                                    <input type="number" name="employerShare" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Effective Date: </label>
                                    <input type="date" name="effectiveDate" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Notes: </label>
                                    <textarea name="notes" id="" cols="30" rows="4" class="form-control"></textarea>
                                </div>




                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="d-flex">
            <a href="/dashboard">Home </a>
            <p class="mx-2"> > </p>
            <a href="/"> Contribution</a>
            <p class="mx-2"> > </p>
            <a href="">Contribution Form</a>
        </div>

        <div class="d-flex justify-content- start">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Add Contribution
        </button>
        </div>
        

    </div>


    <div class="table-responsive">
        <table id="table" class="table table-striped">
            <thead>
                <tr>
                    <th class="text-center">Contribution ID</th>
                    <th class="text-center">Contribution Type</th>
                    <th class="text-center">Salary Range Start</th>
                    <th class="text-center">Salary Range End</th>
                    <th class="text-center">Employee Share</th>
                    <th class="text-center">Employer Share</th>
                    <th class="text-center">Effective Date</th>
                    <th class="text-center">Notes</th>

                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <tr>
                    <td>1</td>
                    <td>Pagibig</td>
                    <td>4,500.00</td>
                    <td>6,500.00</td>
                    <td>5%</td>
                    <td>6%</td>
                    <td>2024</td>
                    <td>Description</td>




                    <td class="text-center">

                        <a href="" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                            data-bs-target="#exampleModal">Edit</a>

                        <a href="" class="btn btn-danger btn-sm">Delete</a>
                    </td>
                </tr>


            </tbody>
            <tfoot>
                <tr>
                    <th class="text-center">Contribution ID</th>
                    <th class="text-center">Contribution Type</th>
                    <th class="text-center">Salary Range Start</th>
                    <th class="text-center">Salary Range End</th>
                    <th class="text-center">Employee Share</th>
                    <th class="text-center">Employer Share</th>
                    <th class="text-center">Effective Date</th>

                    <th class="text-center">Notes</th>

                    <th class="text-center">Action</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<script>
    new DataTable('#table');
</script>

<?= $this->endSection() ?>