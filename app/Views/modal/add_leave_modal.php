<form action="/addLeave" method="post">
    <div class="modal fade" id="leaveModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Leaves</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Department</label>
                        <select name="department" id="department" class="form-control">.
                            <option value="" disable selected>--- Select Department ---</option>
                            <?php foreach ($departments as $department): ?>

                                <option value="<?php echo $department['department_id'] ?>">
                                    <?php echo $department['department_name'] ?></option>
                            <?php endforeach; ?>

                        </select>

                    </div>

                    <div class="mb-3">
                        <label class="form-label">Employee</label>
                        <select name="employee_id" id="employee_id" class="form-control">
                            <option value="" disabled selected>--- Select an Employee ---</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Leave Type</label>
                        <select name="leave_type" id="leave_type" class="form-control">
                            <option value="" disabled selected>-- Select Leave Type --</option>
                            <option value="Sick Leave">Sick Leave</option>
                            <option value="Vacation Leave">Vacation Leave</option>
                   
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Start Date</label>
                        <input type="date" name="start_date" class="form-control"  max="2030-12-31"  min="2024-01-01" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">End Date</label>
                        <input type="date" name="end_date" class="form-control"  max="2030-12-31"  min="2024-01-01" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Reason</label>
                        <input type="text" name="reason" class="form-control" required>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

</form>