<?php
// appointments.php
session_start();

// seed demo appointments if not present
if (!isset($_SESSION['appointments'])) {
    $_SESSION['appointments'] = [
        [
            'id' => 1,
            'patient' => 'John Doe',
            'patient_email' => 'john@example.com',
            'doctor' => 'Dr. Smith',
            'date' => '2025-01-12 10:30 AM',
            'type' => 'Cardiology Checkup',
            'status' => 'Pending',
            'notes' => ''
        ],
        [
            'id' => 2,
            'patient' => 'Amit Sharma',
            'patient_email' => 'amit@example.com',
            'doctor' => 'Dr. Amy',
            'date' => '2025-01-15 02:00 PM',
            'type' => 'Neurology Consultation',
            'status' => 'Approved',
            'notes' => ''
        ],
        [
            'id' => 3,
            'patient' => 'Priya Singh',
            'patient_email' => 'priya@example.com',
            'doctor' => 'Dr. Rahul',
            'date' => '2025-01-05 11:00 AM',
            'type' => 'X-ray Review',
            'status' => 'Completed',
            'notes' => ''
        ]
    ];
}
$appointments = $_SESSION['appointments'];
$logo_path = '/mnt/data/5bd7db93-95f2-430d-8271-afa40a244bc6.png'; // developer-provided local file path
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Appointment Management — Admin</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

  <style>
    :root{
      --card-bg: rgba(255,255,255,0.92);
      --muted: #6b7280;
      --accent: #38bdf8;
    }
    body { background: linear-gradient(180deg,#f7fbff 0%, #eef9ff 100%); font-family: Inter, system-ui, -apple-system, "Segoe UI", Roboto; color:#0b1220; padding:18px; }
    .card-glass { background: var(--card-bg); border-radius: 12px; padding: 14px; border: 1px solid rgba(0,0,0,0.04); box-shadow: 0 8px 24px rgba(9,30,66,0.04); }
    .status-badge { padding:6px 10px; border-radius:8px; color:white; font-weight:600; }
    .st-pending { background:#f59e0b; }
    .st-approved { background:#0ea5e9; }
    .st-completed { background:#10b981; }
    .st-cancelled { background:#ef4444; }
    .btn-sm { padding:.25rem .5rem; }
    .toast-container { position: fixed; top: 18px; right: 18px; z-index: 99999; }
  </style>
</head>
<body>

<div class="container-fluid">

  <div class="d-flex justify-content-between align-items-center mb-4">
    <div class="d-flex align-items-center gap-3">
      <img src="<?php echo $logo_path ?>" alt="logo" width="48" height="48" style="border-radius:8px; object-fit:cover;">
      <div>
        <h4 class="mb-0">Appointment Management</h4>
        <small class="text-muted">Approve, reject, complete or cancel appointments — sends email & shows notifications.</small>
      </div>
    </div>

    <div>
      <button class="btn btn-outline-secondary" id="refreshBtn"><i class="bi bi-arrow-clockwise"></i> Refresh</button>
      <button class="btn btn-primary" id="addApptBtn"><i class="bi bi-plus-lg"></i> New Appointment</button>
    </div>
  </div>

  <div id="cards" class="row g-3 mb-4">
    <!-- appointment cards rendered by JS -->
  </div>

  <div class="card-glass mt-3">
    <h5 class="mb-3">All Appointments</h5>
    <div class="table-responsive">
      <table class="table align-middle" id="apptTable">
        <thead>
          <tr>
            <th>Patient</th>
            <th>Doctor</th>
            <th>Date</th>
            <th>Type</th>
            <th>Status</th>
            <th class="text-end">Actions</th>
          </tr>
        </thead>
        <tbody id="apptTbody">
          <!-- rows by JS -->
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- TOASTS -->
<div class="toast-container" id="toastContainer"></div>

<!-- VIEW/DETAILS MODAL -->
<div class="modal fade" id="viewModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-md modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Appointment Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="viewBody"></div>
    </div>
  </div>
</div>

<!-- NEW APPT MODAL -->
<div class="modal fade" id="newModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-md modal-dialog-centered">
    <form id="newApptForm" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">New Appointment</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-2">
          <label class="form-label">Patient name</label>
          <input class="form-control" id="new_patient" required>
        </div>
        <div class="mb-2">
          <label class="form-label">Patient email</label>
          <input class="form-control" id="new_email" type="email" required>
        </div>
        <div class="mb-2 row g-2">
          <div class="col-6">
            <label class="form-label">Doctor</label>
            <input class="form-control" id="new_doctor" required>
          </div>
          <div class="col-6">
            <label class="form-label">Date & time</label>
            <input class="form-control" id="new_date" placeholder="2025-01-10 09:00 AM" required>
          </div>
        </div>
        <div class="mb-2">
          <label class="form-label">Type / Reason</label>
          <input class="form-control" id="new_type">
        </div>
        <div class="mb-2">
          <label class="form-label">Notes</label>
          <textarea id="new_notes" class="form-control" rows="3"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-primary" type="submit">Create</button>
      </div>
    </form>
  </div>
</div>

<!-- Bootstrap + fetch polyfill if needed -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
/*
  Frontend script:
  - Renders initial appointments (fetched from a PHP variable embedded)
  - Calls api/appointments.php for action calls and new appointment creation
  - Shows toast notifications for success/failure
  - Sends 'notify' flag to instruct backend to email patient & optionally doctor
*/

// initial data provided by PHP for first render
const initialAppointments = <?php echo json_encode($appointments, JSON_HEX_TAG|JSON_HEX_AMP); ?>;

let appointments = initialAppointments.slice();

// helper: create toast
function showToast(title, msg, type='info', timeout=4000) {
  const id = 't' + Date.now();
  const wrapper = document.createElement('div');
  wrapper.className = 'toast align-items-center text-bg-white border-0 mb-2';
  wrapper.id = id;
  wrapper.role = 'alert';
  wrapper.ariaLive = 'polite';
  wrapper.ariaAtomic = 'true';

  // icon by type
  let icon = '<i class="bi bi-info-circle text-info me-2"></i>';
  if (type === 'success') icon = '<i class="bi bi-check-circle text-success me-2"></i>';
  if (type === 'error') icon = '<i class="bi bi-exclamation-circle text-danger me-2"></i>';
  if (type === 'warning') icon = '<i class="bi bi-exclamation-triangle text-warning me-2"></i>';

  wrapper.innerHTML = `
    <div class="d-flex">
      <div class="toast-body">
        ${icon}<strong>${title}</strong><div style="font-size:0.9rem">${msg}</div>
      </div>
      <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  `;
  document.getElementById('toastContainer').appendChild(wrapper);
  const bsToast = new bootstrap.Toast(wrapper, { delay: timeout });
  bsToast.show();
  // remove when hidden
  wrapper.addEventListener('hidden.bs.toast', () => wrapper.remove());
}

// render cards and table
function renderAll() {
  renderCards();
  renderTable();
}

function statusClass(s) {
  if (s === 'Pending') return 'st-pending';
  if (s === 'Approved') return 'st-approved';
  if (s === 'Completed') return 'st-completed';
  return 'st-cancelled';
}

function renderCards() {
  const container = document.getElementById('cards');
  container.innerHTML = '';
  appointments.forEach(a => {
    const col = document.createElement('div');
    col.className = 'col-md-4';
    col.innerHTML = `
      <div class="card-glass p-3 h-100">
        <div class="d-flex justify-content-between align-items-start">
          <div>
            <h6 class="mb-1">${escapeHtml(a.patient)}</h6>
            <div class="small text-muted">${escapeHtml(a.type)} • ${escapeHtml(a.date)}</div>
            <div class="small text-muted">Doctor: ${escapeHtml(a.doctor)}</div>
          </div>
          <div><span class="status-badge ${statusClass(a.status)}">${escapeHtml(a.status)}</span></div>
        </div>

        <div class="mt-3 d-flex gap-2 justify-content-end">
          <button class="btn btn-sm btn-outline-primary" onclick="viewAppt(${a.id})"><i class="bi bi-eye"></i> View</button>
          ${a.status === 'Pending' ? `<button class="btn btn-sm btn-success" onclick="actionAppt(${a.id}, 'approve', true)"><i class="bi bi-check-lg"></i> Approve</button>
          <button class="btn btn-sm btn-danger" onclick="actionAppt(${a.id}, 'reject', true)"><i class="bi bi-x-lg"></i> Reject</button>` : ''}
          ${a.status === 'Approved' ? `<button class="btn btn-sm btn-primary" onclick="actionAppt(${a.id}, 'complete', true)"><i class="bi bi-check2-square"></i> Complete</button>` : ''}
          <button class="btn btn-sm btn-outline-danger" onclick="actionAppt(${a.id}, 'cancel', true)"><i class="bi bi-trash"></i> Cancel</button>
        </div>
      </div>
    `;
    container.appendChild(col);
  });
}

function renderTable() {
  const tbody = document.getElementById('apptTbody');
  tbody.innerHTML = '';
  appointments.forEach(a => {
    const tr = document.createElement('tr');
    tr.innerHTML = `
      <td>${escapeHtml(a.patient)}</td>
      <td>${escapeHtml(a.doctor)}</td>
      <td>${escapeHtml(a.date)}</td>
      <td>${escapeHtml(a.type)}</td>
      <td><span class="${statusClass(a.status)} status-badge">${escapeHtml(a.status)}</span></td>
      <td class="text-end">
        <div class="btn-group btn-group-sm">
          <button class="btn btn-outline-primary" onclick="viewAppt(${a.id})">View</button>
          ${a.status === 'Pending' ? `<button class="btn btn-success" onclick="actionAppt(${a.id}, 'approve', true)">Approve</button>
          <button class="btn btn-danger" onclick="actionAppt(${a.id}, 'reject', true)">Reject</button>` : ''}
          ${a.status === 'Approved' ? `<button class="btn btn-primary" onclick="actionAppt(${a.id}, 'complete', true)">Complete</button>` : ''}
          <button class="btn btn-outline-danger" onclick="actionAppt(${a.id}, 'cancel', true)">Cancel</button>
        </div>
      </td>
    `;
    tbody.appendChild(tr);
  });
}

// view modal
function viewAppt(id) {
  const appt = appointments.find(x => x.id === id);
  if (!appt) return showToast('Not found','Appointment not found', 'error');
  const body = document.getElementById('viewBody');
  body.innerHTML = `
    <p><strong>Patient:</strong> ${escapeHtml(appt.patient)}</p>
    <p><strong>Email:</strong> ${escapeHtml(appt.patient_email || '')}</p>
    <p><strong>Doctor:</strong> ${escapeHtml(appt.doctor)}</p>
    <p><strong>Date:</strong> ${escapeHtml(appt.date)}</p>
    <p><strong>Type:</strong> ${escapeHtml(appt.type)}</p>
    <p><strong>Status:</strong> ${escapeHtml(appt.status)}</p>
    <p><strong>Notes:</strong> ${escapeHtml(appt.notes || '')}</p>
  `;
  const vm = new bootstrap.Modal(document.getElementById('viewModal'));
  vm.show();
}

// generic action call to backend
async function actionAppt(id, action, notify=false) {
  try {
    const resp = await fetch('api/appointments.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ id, action, notify })
    });
    const json = await resp.json();
    if (!json || !json.success) {
      showToast('Error', json?.message || 'Action failed', 'error');
      return;
    }
    // update local copy from server result
    appointments = json.appointments;
    renderAll();
    showToast('Success', json.message || 'Action completed', 'success');
  } catch (err) {
    console.error(err);
    showToast('Error', 'Network error', 'error');
  }
}

// create new appointment
document.getElementById('addApptBtn').addEventListener('click', () => {
  const m = new bootstrap.Modal(document.getElementById('newModal'));
  m.show();
});

document.getElementById('newApptForm').addEventListener('submit', async (e) => {
  e.preventDefault();
  const payload = {
    patient: document.getElementById('new_patient').value.trim(),
    patient_email: document.getElementById('new_email').value.trim(),
    doctor: document.getElementById('new_doctor').value.trim(),
    date: document.getElementById('new_date').value.trim(),
    type: document.getElementById('new_type').value.trim(),
    notes: document.getElementById('new_notes').value.trim()
  };
  try {
    const resp = await fetch('api/appointments.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ action: 'create', data: payload, notify: true })
    });
    const json = await resp.json();
    if (!json.success) { showToast('Error', json.message || 'Create failed','error'); return; }
    appointments = json.appointments;
    renderAll();
    showToast('Success', 'Appointment created', 'success');
    const modalEl = bootstrap.Modal.getInstance(document.getElementById('newModal'));
    if (modalEl) modalEl.hide();
  } catch (err) {
    console.error(err);
    showToast('Error', 'Network error','error');
  }
});

// refresh (fetch latest from server)
document.getElementById('refreshBtn').addEventListener('click', async () => {
  try {
    const resp = await fetch('api/appointments.php', { method: 'GET' });
    const json = await resp.json();
    if (json.success) {
      appointments = json.appointments;
      renderAll();
      showToast('Refreshed', 'Latest appointments loaded','success',2000);
    }
  } catch (e) { console.error(e); showToast('Error','Cannot refresh','error'); }
});

// small helper
function escapeHtml(s) { if (s === null || s === undefined) return ''; return String(s).replaceAll('&','&amp;').replaceAll('<','&lt;').replaceAll('>','&gt;').replaceAll('"','&quot;'); }

// initial render
renderAll();
</script>

       <a href="javascript:history.back()" 
   style="padding:8px 18px; position:sticky;
   top:0px;right:1px;background-color:whitesmoke; text-decoration:none; margin-right:auto;">
    Back
</a>
</body>
</html>
