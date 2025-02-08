<form action="/updatePagibig/<?= $isEditing ? $pagibig_column['contrib_id'] : '' ?>" method="post">
    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update SSS Contribution</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label class="form-label">Monthly Salary</label>
                    <input type="text" name="" class="form-control" value="<?= $isEditing ? $pagibig_column['monthly_rate'] : '' ?>" readonly>
                    <label class="form-label">Employee Share</label>
                    <input type="text" name="employee_share" class="form-control"
                        value="<?= $isEditing ? $pagibig_column['contribution_amount'] : '' ?>" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <input type="submit" value="Save changes" class="btn btn-primary">


                </div>
            </div>
        </div>
    </div>

</form>