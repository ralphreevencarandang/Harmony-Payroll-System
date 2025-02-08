<form action="/addPosition" method="post">
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Position</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label class="form-label">Department</label>
                    <select name="department" class="form-control mb-2" id="deparment">
                        <option value="">--- Select Department ---</option>
                        <?php foreach ($departments as $department): ?>
                            <option value="<?= $department['department_id'] ?>">
                                <?= $department['department_name'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <label class="form-label">Position Name</label>
                    <input type="text" name="position_name" class="form-control mb-2" required>
                    <label class="form-label">Position Description</label>
                    <input type="text" name="position_description" class="form-control mb-2" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <input type="submit" value="Save changes" class="btn btn-primary">


                </div>
            </div>
        </div>
    </div>
</form>