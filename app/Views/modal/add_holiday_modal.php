<form action="/addHoliday" method="post">
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Holidays</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-2">
                        <label class="form-label">Holiday Title</label>
                        <input type="text" name="holidayTitle" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Description</label>
                        <input type="text" name="holidayDescription" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Holiday Date</label>
                        <input type="date" name="holidayDate" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Holiday Type</label>
                        <select name="holidayType" id="holiday_type" class="form-control" required>
                            <option value="Regular">Regular</option>
                            <option value="Special non-working day">Special non-working day</option>

                        </select>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Holiday Rate</label>
                        <input type="text" name="holiday_rate" class="form-control" id="holiday_rate" value="2.0"
                            readonly>
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


<script>
   
    document.addEventListener('change', function (event) {
        if (event.target && event.target.id === 'holiday_type') {
            var holidayType = event.target.value;
            var holidayRateInput = event.target.closest('.modal').querySelector('#holiday_rate');
            if (holidayType === 'Regular') {
                holidayRateInput.value = '2.00';
            } else {
                holidayRateInput.value = '1.30';
            }
        }
    });

</script>