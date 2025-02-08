<form method="POST" action="/saveManualPayheads/<?= $isEditing ? $employees_column['employee_id'] : '' ?>">
  <div class="modal fade" id="payheadModal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalToggleLabel">Assign Payheads</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div>
            <div>
              <p>Employee ID: <?= $isEditing ? $employees_column['employee_id'] : '' ?></p>
              <p>Name:
                <?= $isEditing ? $employees_column['firstname'] . ' ' . $employees_column['middlename'] . ' ' . $employees_column['lastname'] : '' ?>
              </p>
              <p>Department: <?= $isEditing ? $employees_column['department_name'] : '' ?></p>
              <p>Position: <?= $isEditing ? $employees_column['position_name'] : '' ?></p>
            </div>
          </div>

          <hr>
          <div class="card">
            <div class="card-header">

              <div class="row">
                <div class="col-9">
                  <select name="payhead" class="form-select" id="payheadSelect">
                    <option value="" disabled selected>--- Select payhead ---</option>
                    <?php foreach ($manual_payheads as $payhead): ?>
                      <option value="<?= $payhead['manual_payhead_id'] ?>"><?= $payhead['payhead_name'] ?>
                        (<?= $payhead['head_type'] ?>)</option>
                    <?php endforeach; ?>
                  </select>

                </div>
                <div class="col-3 ">
                  <button class="btn btn-primary" id="addPayheadBtn">Add to list</button>
                </div>
              </div>

            </div>
            <div class="card-body" id="payheadList">

              <?php foreach ($payheads as $payhead): ?>
                <div class="mb-3">
                  <label
                    class="form-label <?= $payhead['payhead_type'] == 'Earnings' ? 'text-success' : 'text-danger' ?>"><?= $payhead['payhead_name'] ?>(<?= $payhead['payhead_type'] ?>)</label>

                  <input type="text" name="payhead_amount" class="form-control" value="₱ <?= $payhead['amount'] ?>"
                    readonly>



                </div>
              <?php endforeach; ?>



              <?php if ($isEditing): ?>
                <?php foreach ($contributions as $contribution): ?>
                  <div class="mb-3">
                    <label class="form-label"><?= $contribution['contribution_name'] ?></label>
                    <input type="text" name="contribution_amount" class="form-control"
                      value="<?= $contribution['contribution_amount'] ?>" readonly>
                  </div>

                <?php endforeach; ?>
              <?php endif; ?>

              <?php if (!empty($assigned_payheads)): ?>
                <?php foreach ($assigned_payheads as $assigned): ?>
                  <div class="mb-3">
                    <label class="form-label <?= $assigned['head_type'] == 'Earnings' ? 'text-success' : 'text-danger' ?>">
                      <?= $assigned['payhead_name'] ?> (<?= $assigned['head_type'] ?>)
                    </label>
                    <div class="d-flex">
                      <input type="text" name="payhead_amount[]" class="form-control" value="<?= $assigned['amount'] ?>">

                      <button type="button" class="btn btn-danger delete-payhead-btn"
                        data-id="<?= $assigned['id'] ?>"><i class="fa-solid fa-trash"></i></button>

                    </div>
                    <input type="hidden" name="payhead[]" value="<?= $assigned['manual_payhead_id'] ?>">
                  </div>
                <?php endforeach; ?>

              <?php endif; ?>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Save</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</form>

<!-- DOM MANIPUILATION FOR ADDING THE INPUT BOX  -->
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const payheadSelect = document.getElementById('payheadSelect');
    const payheadList = document.getElementById('payheadList');

    // Disable already assigned payheads on page load
    const assignedPayheads = document.querySelectorAll('input[name="payhead[]"]');
    assignedPayheads.forEach(input => {
      const optionToDisable = payheadSelect.querySelector(`option[value="${input.value}"]`);
      if (optionToDisable) {
        optionToDisable.disabled = true;
      }
    });

    document.getElementById('addPayheadBtn').addEventListener('click', function (e) {
      e.preventDefault(); // Prevent form submission

      const selectedOption = payheadSelect.options[payheadSelect.selectedIndex];

      if (selectedOption.value) {
        // Check if the payhead is already in the list
        const existingInputs = payheadList.querySelectorAll('input[name="payhead[]"]');
        for (const input of existingInputs) {
          if (input.value === selectedOption.value) {
            alert('This payhead is already added to the list.');
            return;
          }
        }

        // Create a new div
        const newPayheadDiv = document.createElement('div');
        newPayheadDiv.classList.add('mb-3');

        // Create label
        const newLabel = document.createElement('label');
        newLabel.classList.add(
          'form-label',
          selectedOption.dataset.type === 'Earnings' ? 'text-success' : 'text-danger'
        );
        newLabel.textContent = selectedOption.text;

        // Create input for amount
        const newInput = document.createElement('input');
        newInput.type = 'text';
        newInput.name = 'payhead_amount[]';
        newInput.classList.add('form-control');

        // Create hidden input for payhead ID
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'payhead[]';
        hiddenInput.value = selectedOption.value;

        // Append elements to the div
        newPayheadDiv.appendChild(newLabel);
        newPayheadDiv.appendChild(newInput);
        newPayheadDiv.appendChild(hiddenInput);

        // Append the div to the payhead list
        payheadList.appendChild(newPayheadDiv);

        // Disable the added option in the dropdown
        selectedOption.disabled = true;
        // Reset the select
        payheadSelect.selectedIndex = 0;
      } else {
        alert('Please select a payhead before adding.');
      }
    });
  });
</script>



<!-- VALIDATION FOR INPUTS -->
<script>

  document.querySelector('form').addEventListener('submit', function (e) {
    const payheadAmounts = document.querySelectorAll('input[name="payhead_amount[]"]');
    let isValid = true;

    payheadAmounts.forEach(input => {
      if (!input.value.trim()) {
        isValid = false;
        input.classList.add('is-invalid'); // Add Bootstrap invalid class for feedback
      } else {
        input.classList.remove('is-invalid'); // Remove invalid class if filled
      }
    });

    if (!isValid) {
      e.preventDefault(); // Prevent form submission
      alert('Please fill in all the amounts for the added payheads.');
    }
  });


</script>


<!-- DELETE BUTTON FOR PAYHEAD LIST -->
<script>
  document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.delete-payhead-btn').forEach(button => {
      button.addEventListener('click', function () {
        const manualPayheadId = this.getAttribute('data-id');
        console.log('Manual Payhead ID to delete:', manualPayheadId); // Debugging
        if (!manualPayheadId) {
          alert('Invalid Payhead ID. Cannot proceed with deletion.');
          return;
        }
        if (confirm('Are you sure you want to delete this payhead?')) {
          fetch(`/assignPayhead/setPayhead/<?= $isEditing ? $employees_column['employee_id'] : '' ?>/deleteManualPayheadInList/${manualPayheadId}`, {
            method: 'DELETE',
            headers: {

              'X-Requested-With': 'XMLHttpRequest' // Ensure this header is present
            }
          })
            .then(response => response.json())
            .then(data => {
              console.log('Debug Manual Payhead ID:', data.debug_manualPayheadId); // Debugging
              if (data.status === 'success') {
                alert(data.message);
                // Remove the payhead from the DOM
                this.closest('.mb-3').remove();
              } else {
                alert(data.message);
              }
            })
            .catch(error => {
              console.error('Error:', error);
              alert('An error occurred while deleting the payhead.');
            });
        }
      });
    });
  });
</script>