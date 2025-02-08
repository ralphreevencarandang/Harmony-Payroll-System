<form action="/addManualPayhead" method="post">
    <div class="modal fade" id="add_manual_payhead" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Payhead</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Payhead Name</label>
                        <input type="text" name="payheadName" class="form-control" required>

                    </div>

                 
                  
                    <div class="mb-3">
                        <label class="form-label">Payhead Type</label>
                        <select name="payheadType" class="form-control">
                            <option value="Earnings">Earnings</option>
                            <option value="Deduction">Deduction</option>
                        </select>
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