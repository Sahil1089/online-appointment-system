<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>Lab Management Dashboard — Dynamic Modals</title>
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body { background:#f4f7fa; font-family:Inter,system-ui,-apple-system,Segoe UI,Roboto,Helvetica,Arial;}
    .card-custom { border-radius:14px; background:#fff; padding:18px; box-shadow:0 6px 20px rgba(0,0,0,0.06); border:none; }
    .lead-box { border-radius:10px; padding:12px; background:#e9f3ff; border-left:4px solid #0d6efd; }
    .action-btn { font-size:12px; }
    .table-light th { background:#fbfdff; }
    .thumbnail { height:44px; border-radius:8px; border:1px solid #e6eef8; }
  </style>
</head>
<body>

<div class="container py-4">

  <!-- header -->
  <div class="d-flex align-items-center justify-content-between mb-3">
    <div class="d-flex align-items-center gap-3">
      <h3 class="mb-0">📊 Lab Management Dashboard</h3>
      <small class="text-muted">Admin</small>
    </div>
    <div class="d-flex align-items-center gap-2">
      <!-- uploaded file thumbnail (local path) -->
      <img src="/mnt/data/6e3be7ca-3dc0-4000-bf27-4368c7dd730c.png" alt="ref" class="thumbnail" />
      <button id="btnAddNew" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addGeneralModal">+ Add New</button>
       <?php include 'components/backbtn.php' ;?>
    </div>
  </div>

  <!-- top stats -->
  <div class="row g-3 mb-3">
    <div class="col-md-4">
      <div class="card-custom">
        <small class="text-muted">Total Lab Tests</small>
        <div class="h3 text-primary">215</div>
        <small class="text-muted">This month</small>
        <div class="mt-2">
          <button class="btn btn-outline-primary btn-sm action-btn" data-type="tests" data-filter="all" id="btnViewAllTests">View Details</button>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card-custom">
        <small class="text-muted">Completed Tests</small>
        <div class="h3 text-success">180</div>
        <small class="text-muted">Updated hourly</small>
        <div class="mt-2">
          <button class="btn btn-outline-success btn-sm action-btn" data-type="tests" data-filter="completed" id="btnViewCompleted">View Completed</button>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card-custom">
        <small class="text-muted">Pending Tests</small>
        <div class="h3 text-warning">35</div>
        <small class="text-muted">Across all labs</small>
        <div class="mt-2">
          <button class="btn btn-outline-warning btn-sm action-btn" data-type="tests" data-filter="pending" id="btnViewPending">View Pending</button>
        </div>
      </div>
    </div>
  </div>

  <!-- tests per lab -->
  <div class="card-custom mb-3">
    <div class="d-flex justify-content-between align-items-center mb-2">
      <h5 class="mb-0">🏥 Tests Per Lab</h5>
      <div>
        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addLabModal">+ Add Lab</button>
      </div>
    </div>

    <table class="table align-middle" id="labsTable">
      <thead class="table-light">
        <tr>
          <th>Lab</th><th>Total Tests</th><th>Completed</th><th>Pending</th><th>Action</th>
        </tr>
      </thead>
      <tbody>
        <!-- row data attributes used by JS to populate modals -->
        <tr data-lab-id="1" data-lab-name="Central Lab" data-total="120" data-completed="90" data-pending="30" data-location="Building A, Floor 1">
          <td>Central Lab</td>
          <td>120</td>
          <td><span class="badge bg-success">90</span></td>
          <td><span class="badge bg-warning">30</span></td>
          <td>
            <button class="btn btn-outline-primary btn-sm action-btn btn-view-lab" data-bs-toggle="modal" data-bs-target="#viewLabModal">View</button>
            <button class="btn btn-outline-secondary btn-sm action-btn btn-edit-lab" data-bs-toggle="modal" data-bs-target="#editLabModal">Edit</button>
            <button class="btn btn-outline-danger btn-sm action-btn btn-delete-lab" data-bs-toggle="modal" data-bs-target="#deleteConfirmModal">Delete</button>
          </td>
        </tr>

        <tr data-lab-id="2" data-lab-name="Pathology Lab" data-total="95" data-completed="88" data-pending="7" data-location="Building B, Floor 2">
          <td>Pathology Lab</td>
          <td>95</td>
          <td><span class="badge bg-success">88</span></td>
          <td><span class="badge bg-warning">7</span></td>
          <td>
            <button class="btn btn-outline-primary btn-sm action-btn btn-view-lab" data-bs-toggle="modal" data-bs-target="#viewLabModal">View</button>
            <button class="btn btn-outline-secondary btn-sm action-btn btn-edit-lab" data-bs-toggle="modal" data-bs-target="#editLabModal">Edit</button>
            <button class="btn btn-outline-danger btn-sm action-btn btn-delete-lab" data-bs-toggle="modal" data-bs-target="#deleteConfirmModal">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>

  <!-- employees by department -->
  <div class="card-custom mb-3">
    <div class="d-flex justify-content-between align-items-center mb-2">
      <h5 class="mb-0">👨‍⚕️ Employees by Department</h5>
      <div>
        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">+ Add Employee</button>
      </div>
    </div>

    <table class="table table-bordered text-center" id="deptsTable">
      <thead class="table-light">
        <tr><th>Department</th><th>Total Employees</th><th>Action</th></tr>
      </thead>
      <tbody>
        <tr data-dept-id="1" data-dept-name="Hematology" data-count="4" data-lead="Dr. Rajesh Kumar">
          <td>Hematology</td><td>12</td>
          <td>
            <button class="btn btn-outline-primary btn-sm btn-view-dept" data-bs-toggle="modal" data-bs-target="#viewDeptModal">View</button>
            <button class="btn btn-outline-secondary btn-sm btn-change-lead" data-bs-toggle="modal" data-bs-target="#changeLeadModal">Change Lead</button>
            <button class="btn btn-outline-danger btn-sm btn-remove-dept">Remove</button>
          </td>
        </tr>

        <tr data-dept-id="2" data-dept-name="Microbiology" data-count="8" data-lead="Dr. Anita Verma">
          <td>Microbiology</td><td>8</td>
          <td>
            <button class="btn btn-outline-primary btn-sm btn-view-dept" data-bs-toggle="modal" data-bs-target="#viewDeptModal">View</button>
            <button class="btn btn-outline-secondary btn-sm btn-change-lead" data-bs-toggle="modal" data-bs-target="#changeLeadModal">Change Lead</button>
            <button class="btn btn-outline-danger btn-sm btn-remove-dept">Remove</button>
          </td>
        </tr>

        <tr data-dept-id="3" data-dept-name="Radiology" data-count="6" data-lead="Dr. Pooja Reddy">
          <td>Radiology</td><td>6</td>
          <td>
            <button class="btn btn-outline-primary btn-sm btn-view-dept" data-bs-toggle="modal" data-bs-target="#viewDeptModal">View</button>
            <button class="btn btn-outline-secondary btn-sm btn-change-lead" data-bs-toggle="modal" data-bs-target="#changeLeadModal">Change Lead</button>
            <button class="btn btn-outline-danger btn-sm btn-remove-dept">Remove</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>

  <!-- recent tests -->
  <div class="card-custom mb-4">
    <div class="d-flex justify-content-between align-items-center mb-2">
      <h5 class="mb-0">🧪 Recent Lab Tests</h5>
      <div><button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addTestModal">+ Add Test</button></div>
    </div>

    <table class="table align-middle" id="testsTable">
      <thead class="table-light"><tr><th>Test</th><th>Lab</th><th>Date</th><th>Status</th><th>Action</th></tr></thead>
      <tbody>
        <tr data-test-id="101" data-test-name="CBC" data-lab="Central Lab" data-date="2025-11-22" data-status="Completed">
          <td>CBC</td><td>Central Lab</td><td>2025-11-22</td><td><span class="badge bg-success">Completed</span></td>
          <td>
            <button class="btn btn-outline-primary btn-sm btn-view-test" data-bs-toggle="modal" data-bs-target="#viewTestModal">View</button>
            <button class="btn btn-outline-secondary btn-sm btn-edit-test" data-bs-toggle="modal" data-bs-target="#editTestModal">Edit</button>
            <button class="btn btn-outline-danger btn-sm btn-delete-test" data-bs-toggle="modal" data-bs-target="#deleteConfirmModal">Delete</button>
          </td>
        </tr>

        <tr data-test-id="102" data-test-name="Blood Sugar" data-lab="Pathology Lab" data-date="2025-11-22" data-status="Pending">
          <td>Blood Sugar</td><td>Pathology Lab</td><td>2025-11-22</td><td><span class="badge bg-warning">Pending</span></td>
          <td>
            <button class="btn btn-outline-primary btn-sm btn-view-test" data-bs-toggle="modal" data-bs-target="#viewTestModal">View</button>
            <button class="btn btn-outline-secondary btn-sm btn-edit-test" data-bs-toggle="modal" data-bs-target="#editTestModal">Edit</button>
            <button class="btn btn-outline-danger btn-sm btn-delete-test" data-bs-toggle="modal" data-bs-target="#deleteConfirmModal">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>

</div>

<!-- ===================== MODALS (Dynamic) ===================== -->

<!-- Generic Add New Modal -->
<div class="modal fade" id="addGeneralModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Add New (Choose)</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
      <div class="modal-body">
        <div class="d-grid gap-2 d-md-flex justify-content-md-start">
          <button class="btn btn-primary" data-bs-target="#addLabModal" data-bs-toggle="modal" data-bs-dismiss="modal">Add Lab</button>
          <button class="btn btn-primary" data-bs-target="#addDepartmentModal" data-bs-toggle="modal" data-bs-dismiss="modal">Add Department</button>
          <button class="btn btn-primary" data-bs-target="#addEmployeeModal" data-bs-toggle="modal" data-bs-dismiss="modal">Add Employee</button>
          <button class="btn btn-primary" data-bs-target="#addTestModal" data-bs-toggle="modal" data-bs-dismiss="modal">Add Test</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- View Lab Modal -->
<div class="modal fade" id="viewLabModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Lab Details</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
      <div class="modal-body">
        <p><strong id="viewLabName">Lab Name</strong></p>
        <p><strong>Location:</strong> <span id="viewLabLocation"></span></p>
        <p><strong>Total Tests:</strong> <span id="viewLabTotal"></span></p>
        <p><strong>Completed:</strong> <span id="viewLabCompleted"></span></p>
        <p><strong>Pending:</strong> <span id="viewLabPending"></span></p>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
        <button class="btn btn-primary btn-sm btn-open-edit-lab">Edit</button>
      </div>
    </div>
  </div>
</div>

<!-- Edit Lab Modal -->
<div class="modal fade" id="editLabModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <form class="modal-content" id="editLabForm">
      <div class="modal-header"><h5 class="modal-title">Edit Lab</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
      <div class="modal-body">
        <input type="hidden" id="editLabId">
        <div class="mb-2"><label class="form-label">Lab Name</label><input id="editLabName" class="form-control" required></div>
        <div class="mb-2"><label class="form-label">Location</label><input id="editLabLocation" class="form-control"></div>
        <div class="mb-2"><label class="form-label">Total Tests</label><input id="editLabTotal" type="number" class="form-control"></div>
        <div class="mb-2"><label class="form-label">Completed</label><input id="editLabCompleted" type="number" class="form-control"></div>
        <div class="mb-2"><label class="form-label">Pending</label><input id="editLabPending" type="number" class="form-control"></div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-primary btn-sm" type="submit">Save Changes</button>
      </div>
    </form>
  </div>
</div>

<!-- Delete Confirm Modal (used for labs & tests) -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Confirm Delete</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
      <div class="modal-body">
        <p id="deleteMessage">Are you sure?</p>
        <input type="hidden" id="deleteTargetType">
        <input type="hidden" id="deleteTargetId">
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-danger btn-sm" id="confirmDeleteBtn">Delete</button>
      </div>
    </div>
  </div>
</div>

<!-- View Dept Modal -->
<div class="modal fade" id="viewDeptModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Department Details</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
      <div class="modal-body">
        <p><strong id="viewDeptName">Department</strong></p>
        <p><strong>Lead:</strong> <span id="viewDeptLead"></span></p>
        <p><strong>Total Employees:</strong> <span id="viewDeptCount"></span></p>

        <hr/>
        <h6>Employees</h6>
        <ul id="viewDeptEmployees" class="list-group"></ul>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
        <button class="btn btn-primary btn-sm" data-bs-target="#addEmployeeModal" data-bs-toggle="modal" data-bs-dismiss="modal">+ Add Employee</button>
      </div>
    </div>
  </div>
</div>

<!-- Change Lead Modal -->
<div class="modal fade" id="changeLeadModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <form class="modal-content" id="changeLeadForm">
      <div class="modal-header"><h5 class="modal-title">Change Department Lead</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
      <div class="modal-body">
        <input type="hidden" id="changeLeadDeptId">
        <div class="mb-2"><label class="form-label">Department</label><input id="changeLeadDeptName" class="form-control" readonly></div>
        <div class="mb-2"><label class="form-label">New Lead Name</label><input id="changeLeadName" class="form-control" required></div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-primary btn-sm" type="submit">Change Lead</button>
      </div>
    </form>
  </div>
</div>

<!-- Add Department Modal -->
<div class="modal fade" id="addDepartmentModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <form class="modal-content" id="addDeptForm">
      <div class="modal-header"><h5 class="modal-title">Add Department</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
      <div class="modal-body">
        <div class="mb-2"><label class="form-label">Department Name</label><input id="newDeptName" class="form-control" required></div>
        <div class="mb-2"><label class="form-label">Lead</label><input id="newDeptLead" class="form-control"></div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-primary btn-sm" type="submit">Add Department</button>
      </div>
    </form>
  </div>
</div>

<!-- Add Lab Modal -->
<div class="modal fade" id="addLabModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <form class="modal-content" id="addLabForm">
      <div class="modal-header"><h5 class="modal-title">Add Lab</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
      <div class="modal-body">
        <div class="mb-2"><label class="form-label">Lab Name</label><input id="newLabName" class="form-control" required></div>
        <div class="mb-2"><label class="form-label">Location</label><input id="newLabLocation" class="form-control"></div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-primary btn-sm" type="submit">Add Lab</button>
      </div>
    </form>
  </div>
</div>

<!-- Add Employee Modal -->
<div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <form class="modal-content" id="addEmployeeForm">
      <div class="modal-header"><h5 class="modal-title">Add Employee</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
      <div class="modal-body">
        <div class="mb-2"><label class="form-label">Employee Name</label><input id="newEmpName" class="form-control" required></div>
        <div class="mb-2"><label class="form-label">Department</label>
          <select id="newEmpDept" class="form-select">
            <option value="Hematology">Hematology</option>
            <option value="Microbiology">Microbiology</option>
            <option value="Radiology">Radiology</option>
          </select>
        </div>
        <div class="mb-2"><label class="form-label">Supervisor (optional)</label><input id="newEmpSupervisor" class="form-control"></div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-primary btn-sm" type="submit">Add Employee</button>
      </div>
    </form>
  </div>
</div>

<!-- View Test Modal -->
<div class="modal fade" id="viewTestModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Test Details</h5><button class="btn-close" data-bs-dismiss="modal"></button></div>
      <div class="modal-body">
        <p><strong id="viewTestName">Test</strong></p>
        <p><strong>Lab:</strong> <span id="viewTestLab"></span></p>
        <p><strong>Date:</strong> <span id="viewTestDate"></span></p>
        <p><strong>Status:</strong> <span id="viewTestStatus"></span></p>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
        <button class="btn btn-primary btn-sm btn-open-edit-test">Edit</button>
      </div>
    </div>
  </div>
</div>

<!-- Edit Test Modal -->
<div class="modal fade" id="editTestModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <form class="modal-content" id="editTestForm">
      <div class="modal-header"><h5 class="modal-title">Edit Test</h5><button class="btn-close" data-bs-dismiss="modal"></button></div>
      <div class="modal-body">
        <input id="editTestId" type="hidden">
        <div class="mb-2"><label class="form-label">Test Name</label><input id="editTestName" class="form-control" required></div>
        <div class="mb-2"><label class="form-label">Lab</label><input id="editTestLab" class="form-control"></div>
        <div class="mb-2"><label class="form-label">Date</label><input id="editTestDate" type="date" class="form-control"></div>
        <div class="mb-2"><label class="form-label">Status</label>
          <select id="editTestStatus" class="form-select">
            <option>Pending</option><option>In Progress</option><option>Completed</option>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-primary btn-sm" type="submit">Save Test</button>
      </div>
    </form>
   
  </div>
  
</div>

<!-- ===================== SCRIPTS ===================== -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>



(() => {
  // Helper to find parent TR and its dataset
  function getRowData(button) {
    const tr = button.closest('tr');
    return tr ? tr.dataset : {};
  }

  // ---------- LAB: View ----------
  document.querySelectorAll('.btn-view-lab').forEach(btn => {
    btn.addEventListener('click', (e) => {
      const data = getRowData(e.currentTarget);
      document.getElementById('viewLabName').textContent = data.labName || '—';
      document.getElementById('viewLabLocation').textContent = data.location || '—';
      document.getElementById('viewLabTotal').textContent = data.total || '0';
      document.getElementById('viewLabCompleted').textContent = data.completed || '0';
      document.getElementById('viewLabPending').textContent = data.pending || '0';
      // store current lab id for edit shortcut
      document.querySelector('.btn-open-edit-lab').dataset.labId = data.labId || '';
    });
  });

  // Open edit modal from view modal
  document.querySelectorAll('.btn-open-edit-lab').forEach(btn => {
    btn.addEventListener('click', (e) => {
      const id = e.currentTarget.dataset.labId;
      if (!id) return;
      // find table row by data-lab-id
      const row = document.querySelector('tr[data-lab-id=\"' + id + '\"]');
      if (row) row.querySelector('.btn-edit-lab').click();
    });
  });

  // ---------- LAB: Edit ----------
  document.querySelectorAll('.btn-edit-lab').forEach(btn => {
    btn.addEventListener('click', (e) => {
      const d = getRowData(e.currentTarget);
      document.getElementById('editLabId').value = d.labId || '';
      document.getElementById('editLabName').value = d.labName || '';
      document.getElementById('editLabLocation').value = d.location || '';
      document.getElementById('editLabTotal').value = d.total || '';
      document.getElementById('editLabCompleted').value = d.completed || '';
      document.getElementById('editLabPending').value = d.pending || '';
    });
  });

  // Submit edit lab (updates table row client-side)
  document.getElementById('editLabForm').addEventListener('submit', function(evt) {
    evt.preventDefault();
    const id = document.getElementById('editLabId').value;
    const row = document.querySelector('tr[data-lab-id=\"' + id + '\"]');
    if (!row) { bootstrap.Modal.getInstance(document.getElementById('editLabModal')).hide(); return; }
    // update dataset and visible cells
    row.dataset.labName = document.getElementById('editLabName').value;
    row.dataset.location = document.getElementById('editLabLocation').value;
    row.dataset.total = document.getElementById('editLabTotal').value;
    row.dataset.completed = document.getElementById('editLabCompleted').value;
    row.dataset.pending = document.getElementById('editLabPending').value;
    row.cells[0].textContent = row.dataset.labName;
    row.cells[1].textContent = row.dataset.total;
    row.cells[2].innerHTML = '<span class=\"badge bg-success\">' + row.dataset.completed + '</span>';
    row.cells[3].innerHTML = '<span class=\"badge bg-warning\">' + row.dataset.pending + '</span>';
    bootstrap.Modal.getInstance(document.getElementById('editLabModal')).hide();
  });

  // ---------- DELETE generic ----------
  document.querySelectorAll('.btn-delete-lab, .btn-delete-test, .btn-remove-dept').forEach(btn => {
    btn.addEventListener('click', (e) => {
      const d = getRowData(e.currentTarget);
      let type = 'item', id = '', name = '';
      // determine type by classes
      if (e.currentTarget.classList.contains('btn-delete-lab')) { type = 'lab'; id = d.labId; name = d.labName; }
      if (e.currentTarget.classList.contains('btn-delete-test')) { type = 'test'; id = d.testId; name = d.testName; }
      if (e.currentTarget.classList.contains('btn-remove-dept')) {
        // remove dept button is not inside row-level dataset, so find parent tr
        const tr = e.currentTarget.closest('tr');
        if (tr) { id = tr.dataset.deptId; name = tr.dataset.deptName; type = 'department'; }
      }
      document.getElementById('deleteTargetType').value = type;
      document.getElementById('deleteTargetId').value = id || '';
      document.getElementById('deleteMessage').textContent = 'Are you sure you want to delete ' + (name || type) + '? This action cannot be undone.';
    });
  });

  // confirm delete (client-side remove)
  document.getElementById('confirmDeleteBtn').addEventListener('click', () => {
    const type = document.getElementById('deleteTargetType').value;
    const id = document.getElementById('deleteTargetId').value;
    if (!type) return;
    if (type === 'lab') {
      const row = document.querySelector('tr[data-lab-id=\"' + id + '\"]');
      if (row) row.remove();
    } else if (type === 'test') {
      const row = document.querySelector('tr[data-test-id=\"' + id + '\"]');
      if (row) row.remove();
    } else if (type === 'department') {
      const row = document.querySelector('tr[data-dept-id=\"' + id + '\"]');
      if (row) row.remove();
    }
    bootstrap.Modal.getInstance(document.getElementById('deleteConfirmModal')).hide();
  });

  // ---------- DEPARTMENT: View ----------
  document.querySelectorAll('.btn-view-dept').forEach(btn => {
    btn.addEventListener('click', (e) => {
      const d = getRowData(e.currentTarget);
      const id = d.deptId;
      document.getElementById('viewDeptName').textContent = d.deptName || '';
      document.getElementById('viewDeptLead').textContent = d.lead || '—';
      document.getElementById('viewDeptCount').textContent = d.count || '0';
      // Example: populate employee list from static sample (in real app load via AJAX)
      const list = document.getElementById('viewDeptEmployees');
      list.innerHTML = '';
      // static sample mapping (you can change to dynamic)
      const sample = {
        'Hematology': ['Rohit Sharma','Neha Verma','Vikas Patel'],
        'Microbiology': ['Sunil Kumar','Deepak Yadav'],
        'Radiology': ['Anil Kumar','Rita Bose']
      };
      (sample[d.deptName] || []).forEach(name => {
        const li = document.createElement('li');
        li.className = 'list-group-item d-flex justify-content-between align-items-center';
        li.innerHTML = name + '<div><button class=\"btn btn-sm btn-outline-primary btn-view-emp action-btn\" data-name=\"' + name + '\" data-bs-toggle=\"modal\" data-bs-target=\"#viewEmpModal\">View</button></div>';
        list.appendChild(li);
      });
    });
  });

  // ---------- CHANGE LEAD ----------
  document.querySelectorAll('.btn-change-lead').forEach(btn => {
    btn.addEventListener('click', (e) => {
      const tr = e.currentTarget.closest('tr');
      if (!tr) return;
      const d = tr.dataset;
      document.getElementById('changeLeadDeptId').value = d.deptId || '';
      document.getElementById('changeLeadDeptName').value = d.deptName || '';
      document.getElementById('changeLeadName').value = d.lead || '';
    });
  });

  document.getElementById('changeLeadForm').addEventListener('submit', function(evt){
    evt.preventDefault();
    const id = document.getElementById('changeLeadDeptId').value;
    const name = document.getElementById('changeLeadName').value;
    const tr = document.querySelector('tr[data-dept-id=\"' + id + '\"]');
    if (tr) {
      tr.dataset.lead = name;
      // optionally update UI cell if present
    }
    bootstrap.Modal.getInstance(document.getElementById('changeLeadModal')).hide();
  });

  // ---------- ADD Department ----------
  document.getElementById('addDeptForm').addEventListener('submit', function(evt){
    evt.preventDefault();
    const name = document.getElementById('newDeptName').value;
    const lead = document.getElementById('newDeptLead').value;
    // add to depts table (client-side) with new id
    const tbody = document.querySelector('#deptsTable tbody');
    const newId = Date.now();
    const tr = document.createElement('tr');
    tr.dataset.deptId = newId;
    tr.dataset.deptName = name;
    tr.dataset.count = 0;
    tr.dataset.lead = lead;
    tr.innerHTML = '<td>' + name + '</td><td>0</td><td>' +
      '<button class=\"btn btn-outline-primary btn-sm btn-view-dept\" data-bs-toggle=\"modal\" data-bs-target=\"#viewDeptModal\">View</button> ' +
      '<button class=\"btn btn-outline-secondary btn-sm btn-change-lead\" data-bs-toggle=\"modal\" data-bs-target=\"#changeLeadModal\">Change Lead</button> ' +
      '<button class=\"btn btn-outline-danger btn-sm btn-remove-dept\">Remove</button></td>';
    tbody.appendChild(tr);
    bootstrap.Modal.getInstance(document.getElementById('addDepartmentModal')).hide();
    // rebind newly-added buttons
    attachDynamicBindings();
  });

  // ---------- ADD Lab ----------
  document.getElementById('addLabForm').addEventListener('submit', function(evt){
    evt.preventDefault();
    const name = document.getElementById('newLabName').value;
    const loc = document.getElementById('newLabLocation').value;
    const tbody = document.querySelector('#labsTable tbody');
    const newId = Date.now();
    const tr = document.createElement('tr');
    tr.dataset.labId = newId;
    tr.dataset.labName = name;
    tr.dataset.location = loc;
    tr.dataset.total = 0;
    tr.dataset.completed = 0;
    tr.dataset.pending = 0;
    tr.innerHTML = '<td>' + name + '</td><td>0</td><td><span class=\"badge bg-success\">0</span></td><td><span class=\"badge bg-warning\">0</span></td><td>' +
      '<button class=\"btn btn-outline-primary btn-sm btn-view-lab\" data-bs-toggle=\"modal\" data-bs-target=\"#viewLabModal\">View</button> ' +
      '<button class=\"btn btn-outline-secondary btn-sm btn-edit-lab\" data-bs-toggle=\"modal\" data-bs-target=\"#editLabModal\">Edit</button> ' +
      '<button class=\"btn btn-outline-danger btn-sm btn-delete-lab\" data-bs-toggle=\"modal\" data-bs-target=\"#deleteConfirmModal\">Delete</button></td>';
    tbody.appendChild(tr);
    bootstrap.Modal.getInstance(document.getElementById('addLabModal')).hide();
    attachDynamicBindings();
  });

  // ---------- ADD Employee ----------
  document.getElementById('addEmployeeForm').addEventListener('submit', function(evt){
    evt.preventDefault();
    const name = document.getElementById('newEmpName').value;
    const dept = document.getElementById('newEmpDept').value;
    const supervisor = document.getElementById('newEmpSupervisor').value;
    // In a real app, POST to server. Here we just show a success toast (or console)
    console.log('Add Employee', {name, dept, supervisor});
    bootstrap.Modal.getInstance(document.getElementById('addEmployeeModal')).hide();
    alert('Employee added (client-side demo). Implement server-side to persist.');
  });

  // ---------- VIEW TEST ----------
  document.querySelectorAll('.btn-view-test').forEach(btn => {
    btn.addEventListener('click', (e) => {
      const d = getRowData(e.currentTarget);
      document.getElementById('viewTestName').textContent = d.testName || '';
      document.getElementById('viewTestLab').textContent = d.lab || '';
      document.getElementById('viewTestDate').textContent = d.date || '';
      document.getElementById('viewTestStatus').textContent = d.status || '';
      document.querySelectorAll('.btn-open-edit-test').forEach(x => x.dataset.testId = d.testId || '');
    });
  });

  // open edit test from view
  document.querySelectorAll('.btn-open-edit-test').forEach(btn => {
    btn.addEventListener('click', (e) => {
      const id = e.currentTarget.dataset.testId;
      if (!id) return;
      const row = document.querySelector('tr[data-test-id=\"' + id + '\"]');
      if (row) row.querySelector('.btn-edit-test').click();
    });
  });

  // ---------- EDIT TEST ----------
  document.querySelectorAll('.btn-edit-test').forEach(btn => {
    btn.addEventListener('click', (e) => {
      const d = getRowData(e.currentTarget);
      document.getElementById('editTestId').value = d.testId || '';
      document.getElementById('editTestName').value = d.testName || '';
      document.getElementById('editTestLab').value = d.lab || '';
      document.getElementById('editTestDate').value = d.date || '';
      document.getElementById('editTestStatus').value = d.status || '';
    });
  });

  document.getElementById('editTestForm').addEventListener('submit', function(evt){
    evt.preventDefault();
    const id = document.getElementById('editTestId').value;
    const row = document.querySelector('tr[data-test-id=\"' + id + '\"]');
    if (!row) return;
    const name = document.getElementById('editTestName').value;
    const lab = document.getElementById('editTestLab').value;
    const date = document.getElementById('editTestDate').value;
    const status = document.getElementById('editTestStatus').value;
    // update dataset and UI
    row.dataset.testName = name;
    row.dataset.lab = lab;
    row.dataset.date = date;
    row.dataset.status = status;
    row.cells[0].textContent = name;
    row.cells[1].textContent = lab;
    row.cells[2].textContent = date;
    row.cells[3].innerHTML = status === 'Completed' ? '<span class=\"badge bg-success\">Completed</span>' :
                         status === 'Pending' ? '<span class=\"badge bg-warning\">Pending</span>' :
                         '<span class=\"badge bg-info\">In Progress</span>';
    bootstrap.Modal.getInstance(document.getElementById('editTestModal')).hide();
  });

  // ---------- Helper to attach bindings for dynamically added rows ----------
  function attachDynamicBindings(){
    // Labs
    document.querySelectorAll('#labsTable .btn-view-lab').forEach(btn => {
      if (!btn.dataset.bound) {
        btn.addEventListener('click', (e) => {
          const d = getRowData(e.currentTarget);
          document.getElementById('viewLabName').textContent = d.labName || '';
          document.getElementById('viewLabLocation').textContent = d.location || '';
          document.getElementById('viewLabTotal').textContent = d.total || '0';
          document.getElementById('viewLabCompleted').textContent = d.completed || '0';
          document.getElementById('viewLabPending').textContent = d.pending || '0';
          document.querySelector('.btn-open-edit-lab').dataset.labId = d.labId || '';
        });
        btn.dataset.bound = '1';
      }
    });

    document.querySelectorAll('#labsTable .btn-edit-lab').forEach(btn => {
      if (!btn.dataset.bound) {
        btn.addEventListener('click', (e) => {
          const d = getRowData(e.currentTarget);
          document.getElementById('editLabId').value = d.labId || '';
          document.getElementById('editLabName').value = d.labName || '';
          document.getElementById('editLabLocation').value = d.location || '';
          document.getElementById('editLabTotal').value = d.total || '';
          document.getElementById('editLabCompleted').value = d.completed || '';
          document.getElementById('editLabPending').value = d.pending || '';
        });
        btn.dataset.bound = '1';
      }
    });

    // Tests
    document.querySelectorAll('#testsTable .btn-view-test').forEach(btn => {
      if (!btn.dataset.bound) {
        btn.addEventListener('click', (e) => {
          const d = getRowData(e.currentTarget);
          document.getElementById('viewTestName').textContent = d.testName || '';
          document.getElementById('viewTestLab').textContent = d.lab || '';
          document.getElementById('viewTestDate').textContent = d.date || '';
          document.getElementById('viewTestStatus').textContent = d.status || '';
          document.querySelectorAll('.btn-open-edit-test').forEach(x => x.dataset.testId = d.testId || '');
        });
        btn.dataset.bound = '1';
      }
    });

    document.querySelectorAll('#testsTable .btn-edit-test').forEach(btn => {
      if (!btn.dataset.bound) {
        btn.addEventListener('click', (e) => {
          const d = getRowData(e.currentTarget);
          document.getElementById('editTestId').value = d.testId || '';
          document.getElementById('editTestName').value = d.testName || '';
          document.getElementById('editTestLab').value = d.lab || '';
          document.getElementById('editTestDate').value = d.date || '';
          document.getElementById('editTestStatus').value = d.status || '';
        });
        btn.dataset.bound = '1';
      }
    });

    // Department buttons
    document.querySelectorAll('#deptsTable .btn-view-dept').forEach(btn => {
      if (!btn.dataset.bound) {
        btn.dataset.bound = '1';
        btn.addEventListener('click', (e) => {
          const d = getRowData(e.currentTarget);
          document.getElementById('viewDeptName').textContent = d.deptName || '';
          document.getElementById('viewDeptLead').textContent = d.lead || '';
          document.getElementById('viewDeptCount').textContent = d.count || '0';
          // (repopulate employees list as shown previously)
        });
      }
    });

    document.querySelectorAll('#deptsTable .btn-change-lead').forEach(btn => {
      if (!btn.dataset.bound) {
        btn.dataset.bound = '1';
        btn.addEventListener('click', (e) => {
          const tr = e.currentTarget.closest('tr');
          if (!tr) return;
          const d = tr.dataset;
          document.getElementById('changeLeadDeptId').value = d.deptId || '';
          document.getElementById('changeLeadDeptName').value = d.deptName || '';
          document.getElementById('changeLeadName').value = d.lead || '';
        });
      }
    });

    // delete bindings for newly added ones
    document.querySelectorAll('#labsTable .btn-delete-lab, #testsTable .btn-delete-test, #deptsTable .btn-remove-dept').forEach(btn=>{
      if(!btn.dataset.bound){
        btn.dataset.bound = '1';
        btn.addEventListener('click', (e) => {
          const d = getRowData(e.currentTarget);
          let type='item', id='', name='';
          if (e.currentTarget.classList.contains('btn-delete-lab')) { type='lab'; id=d.labId; name=d.labName; }
          if (e.currentTarget.classList.contains('btn-delete-test')) { type='test'; id=d.testId; name=d.testName; }
          if (e.currentTarget.classList.contains('btn-remove-dept')) {
            const tr = e.currentTarget.closest('tr');
            if (tr) { id = tr.dataset.deptId; name = tr.dataset.deptName; type='department'; }
          }
          document.getElementById('deleteTargetType').value = type;
          document.getElementById('deleteTargetId').value = id || '';
          document.getElementById('deleteMessage').textContent = 'Are you sure you want to delete ' + (name || type) + '? This action cannot be undone.';
        });
      }
    });
  }

  // attach dynamic bindings initially
  attachDynamicBindings();

  // Hook view all/completed/pending buttons to show filtered tests in modal (simple example: just alert)
  document.getElementById('btnViewAllTests').addEventListener('click', ()=>{ alert('Filter: all tests (demo)'); });
  document.getElementById('btnViewCompleted').addEventListener('click', ()=>{ alert('Filter: completed tests (demo)'); });
  document.getElementById('btnViewPending').addEventListener('click', ()=>{ alert('Filter: pending tests (demo)'); });

})();
</script>

</body>
</html>
