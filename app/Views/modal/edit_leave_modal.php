<form onsubmit="return confirmUpdate()" action="/updateLeave/<?= $isEditing ? $leave_column['leave_id'] : '' ?>"
    method="post">
    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Payhead</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Department</label>

                        <input type="text" name="department" id="department" value="<?= $isEditing ? $leave_column['department_name']: ''?>" class="form-control" readonly>
                    
                   
                          
                        </select>

                    </div>

                    <div class="mb-3">
                        <label class="form-label">Employee</label>
                      
                        <input type="text" name="employee_id" id="employee_id" value="<?= $isEditing ? $leave_column['firstname'] . ' '. $leave_column['middlename'] . ' ' . $leave_column['lastname']: ''?>" class="form-control" readonly>

                    </div>
                    <div class="mb-3">
                        <label class="form-label">Leave Type</label>
                        <select name="leave_type" id="leave_type" class="form-control">

                            <option value="Sick Leave" <?= $isEditing && $leave_column['leave_type'] == 'Sick Leave' ? 'selected' : '' ?>>Sick Leave</option>
                            <option value="Vacation Leave" <?= $isEditing && $leave_column['leave_type'] == 'Vacation Leave' ? 'selected' : '' ?>>Vacation Leave</option>
                            <option value="Emergency Leave" <?= $isEditing && $leave_column['leave_type'] == 'Emergency Leave' ? 'selected' : '' ?>>Emergency Leave</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Start Date</label>
                        <input type="date" name="start_date" class="form-control" max="2030-12-31" min="2024-01-01"
                            value="<?= $isEditing ? $leave_column['leave_start_date'] : '' ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">End Date</label>
                        <input type="date" name="end_date" class="form-control" max="2030-12-31" min="2024-01-01"
                            value="<?= $isEditing ? $leave_column['leave_end_date'] : '' ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Reason</label>
                        <input type="text" name="reason" class="form-control"
                            value="<?= $isEditing ? $leave_column['reason'] : '' ?>" required>
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