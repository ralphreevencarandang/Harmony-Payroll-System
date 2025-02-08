<form onsubmit="return confirmUpdate()"
        action="/updateDepartment/<?= $isEditing ? $department_column['department_id'] : '' ?>" method="post">
        <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Update Department</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label class="form-label">Department Name</label>
                        <input type="text" name="department_name" class="form-control"
                            value="<?= $isEditing ? $department_column['department_name'] : '' ?>" required>
                        <label class="form-label">Department Description</label>
                        <input type="text" name="department_description" class="form-control"
                            value="<?= $isEditing ? $department_column['description'] : '' ?>" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <input type="submit" value="Save changes" class="btn btn-primary">


                    </div>
                </div>
            </div>
        </div>

    </form>