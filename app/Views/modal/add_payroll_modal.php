<form action="/generatePayroll" method="post" id="generatePayrollForm">
    <!-- Original Generate Modal -->
    <div class="modal fade" id="generateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Generate Payroll</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Date From: </label>
                        <input type="date" name="dateFrom" class="form-control" min="2024-01-01">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Date To: </label>
                        <input type="date" name="dateTo" class="form-control" min="2024-01-01">
                    </div>

                    <!-- Loading spinner (hidden initially) -->
                    <div id="loadingSpinner" class="text-center" style="display: none;">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p>Generating payroll...</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Generate</button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    const form = document.getElementById('generatePayrollForm');
    const loadingSpinner = document.getElementById('loadingSpinner');

    form.addEventListener('submit', function (event) {
        // Show the loading spinner when the form is submitted
        loadingSpinner.style.display = 'block';

        // Disable the submit button to prevent multiple submissions
        const submitButton = form.querySelector('button[type="submit"]');
        submitButton.disabled = true;

        // You can add additional logic here to handle form submission asynchronously
    });
</script>