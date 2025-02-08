<!-- UPDATE MODAL -->

<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <form onsubmit="return confirmUpdate()"
                action="/updateHoliday/<?= isset($holiday_column) ? $holiday_column['holiday_id'] : '' ?>"
                method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Holidays</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-2">
                        <label class="form-label">Holiday Title</label>
                        <input type="text" name="holidayTitle" class="form-control"
                            value="<?= $isEditing ? $holiday_column['holiday_title'] : '' ?>" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Description</label>
                        <input type="text" name="holidayDescription" class="form-control"
                            value="<?= $isEditing ? $holiday_column['holiday_description'] : '' ?>" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Holiday Date</label>
                        <input type="date" name="holidayDate" class="form-control"
                            value="<?= $isEditing ? $holiday_column['holiday_date'] : '' ?>" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Holiday Type</label>
                        <select name="holidayType" class="form-control" id="holiday_type" required>
                            <option value="Regular" <?= isset($holiday_column) && $holiday_column['holiday_type'] == 'Regular' ? 'selected' : '' ?>>Regular</option>
                            <option value="Special non-working day" <?= isset($holiday_column) && $holiday_column['holiday_type'] == 'Special non-working day' ? 'selected' : '' ?>>Special
                                non-working day</option>
                        </select>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Holiday Rate</label>
                        <input type="text" name="holiday_rate" class="form-control" id="holiday_rate"
                            value="<?= $isEditing ? $holiday_column['holiday_rate'] : '' ?>" readonly>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

