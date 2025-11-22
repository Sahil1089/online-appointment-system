<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Admin — Patient Management</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

  <style>
    :root{
      --card-bg: rgba(255,255,255,0.88);
      --muted: #6b7280;
      --accent: #38bdf8;
      --glass-border: rgba(255,255,255,0.7);
    }
    body {
      background: linear-gradient(180deg,#f7fbff 0%, #eef9ff 100%);
      font-family: Inter, system-ui, -apple-system, "Segoe UI", Roboto, Arial, "Helvetica Neue";
      color:#0b1220;
      padding:18px;
    }

    .page { max-width:1200px; margin:0 auto; }

    .card-glass {
      background: var(--card-bg);
      border-radius: 12px;
      padding: 14px;
      border: 1px solid var(--glass-border);
      box-shadow: 0 8px 24px rgba(9,30,66,0.04);
    }

    .table-avatar {
      width:44px; height:44px; object-fit:cover; border-radius:8px;
      box-shadow:0 6px 16px rgba(3,102,214,0.06);
    }

    .filters { gap:10px; display:flex; align-items:center; flex-wrap:wrap; }
    .filters .form-control, .filters .form-select { min-width: 180px; }

    .small-note { color:var(--muted); font-size:0.9rem; }

    @media (max-width: 768px) {
      .filters { flex-direction:column; align-items:stretch; }
      .filters .form-control, .filters .form-select { min-width: auto; width:100%; }
    }
  </style>
</head>
<body>

<div class="page">

  <div class="d-flex align-items-center justify-content-between mb-3">
    <div>
      <h4 class="mb-0">Patient Management</h4>
      <small class="text-muted">Approve appointments, upload reports, manage patient records.</small>
    </div>

    <div class="d-flex gap-2">
      <button class="btn btn-outline-secondary" id="exportPatientsCsv"><i class="bi bi-download"></i> Export Patients</button>
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#patientModal" id="openAddPatientBtn">
        <i class="bi bi-plus-lg"></i> Add Patient
      </button>
    </div>
  </div>

  <div class="card-glass mb-3">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
      <div class="filters">
        <input id="patientSearch" class="form-control" placeholder="Search by name, phone or email">
        <select id="apptStatusFilter" class="form-select">
          <option value="">All Appointment Status</option>
          <option value="Pending">Pending</option>
          <option value="Approved">Approved</option>
          <option value="Rejected">Rejected</option>
          <option value="Completed">Completed</option>
        </select>
        <select id="ageFilter" class="form-select">
          <option value="">All ages</option>
          <option value="0-18">0 - 18</option>
          <option value="19-40">19 - 40</option>
          <option value="41-65">41 - 65</option>
          <option value="65+">65+</option>
        </select>
      </div>

      <div class="text-muted small">Total patients: <strong id="patientCount">0</strong></div>
    </div>
  </div>

  <div class="card-glass mb-4">
    <div class="table-responsive">
      <table class="table align-middle" id="patientsTable">
        <thead>
          <tr>
            <th></th>
            <th>Patient</th>
            <th>Phone / Email</th>
            <th>DOB / Age</th>
            <th>Last Visit</th>
            <th>Reports</th>
            <th class="text-end">Actions</th>
          </tr>
        </thead>
        <tbody id="patientsTbody">
          <!-- filled by JS -->
        </tbody>
      </table>
    </div>
  </div>

</div>

<!-- PATIENT MODAL (Add / Edit) -->
<div class="modal fade" id="patientModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <form id="patientForm" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="patientModalTitle">Add Patient</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="patientId">
        <div class="row g-3">
          <div class="col-md-4 text-center">
            <img id="patientAvatarPreview" src="/mnt/data/5bd7db93-95f2-430d-8271-afa40a244bc6.png" class="mb-3" style="width:150px;height:150px;object-fit:cover;border-radius:12px;">
            <div class="d-grid gap-2">
              <input class="form-control form-control-sm" type="file" id="patientAvatarFile" accept="image/*">
              <button type="button" class="btn btn-sm btn-outline-secondary" id="patientRemoveAvatar">Remove</button>
            </div>
          </div>

          <div class="col-md-8">
            <div class="row g-2">
              <div class="col-md-6">
                <label class="form-label">Full name</label>
                <input id="p_name" class="form-control" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Email</label>
                <input id="p_email" type="email" class="form-control">
              </div>
              <div class="col-md-6">
                <label class="form-label">Phone</label>
                <input id="p_phone" class="form-control">
              </div>
              <div class="col-md-6">
                <label class="form-label">Date of birth</label>
                <input id="p_dob" type="date" class="form-control">
              </div>
              <div class="col-md-6">
                <label class="form-label">Gender</label>
                <select id="p_gender" class="form-select">
                  <option>Male</option>
                  <option>Female</option>
                  <option>Other</option>
                </select>
              </div>
              <div class="col-md-6">
                <label class="form-label">Last Visit</label>
                <input id="p_lastvisit" type="date" class="form-control">
              </div>
              <div class="col-12">
                <label class="form-label">Address</label>
                <input id="p_address" class="form-control">
              </div>
              <div class="col-12">
                <label class="form-label">Medical History / Notes</label>
                <textarea id="p_notes" rows="3" class="form-control"></textarea>
              </div>
            </div>
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary" id="savePatientBtn">Save Patient</button>
      </div>
    </form>
  </div>
</div>

<!-- VIEW PATIENT PROFILE (Tabs: Details | Appointments | Reports | Notes) -->
<div class="modal fade" id="patientViewModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body p-3">
        <div class="d-flex justify-content-between align-items-start gap-3">
          <div class="d-flex gap-3">
            <img id="pv_avatar" src="/mnt/data/5bd7db93-95f2-430d-8271-afa40a244bc6.png" style="width:110px;height:110px;object-fit:cover;border-radius:12px;">
            <div>
              <h4 id="pv_name" class="mb-1"></h4>
              <div class="small-note" id="pv_contact"></div>
              <div class="small-note" id="pv_address"></div>
              <div class="mt-2"><span id="pv_age"></span> • <span id="pv_gender"></span></div>
            </div>
          </div>
          <div class="text-end">
            <button class="btn btn-outline-secondary btn-sm" id="pv_edit_btn"><i class="bi bi-pencil"></i> Edit</button>
            <button class="btn btn-danger btn-sm" id="pv_delete_btn"><i class="bi bi-trash"></i> Delete</button>
          </div>
        </div>

        <hr>

        <ul class="nav nav-tabs" id="pvTabs" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active" id="details-tab" data-bs-toggle="tab" data-bs-target="#tab-details">Details</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="appointments-tab" data-bs-toggle="tab" data-bs-target="#tab-appointments">Appointments</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="reports-tab" data-bs-toggle="tab" data-bs-target="#tab-reports">Reports</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="notes-tab" data-bs-toggle="tab" data-bs-target="#tab-notes">Notes</button>
          </li>
        </ul>

        <div class="tab-content mt-3">
          <div class="tab-pane fade show active" id="tab-details">
            <div id="pv_details"></div>
          </div>

          <div class="tab-pane fade" id="tab-appointments">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <div>
                <strong>Appointments</strong>
                <div class="small-note">Approve, reject, reschedule or mark complete.</div>
              </div>
              <div>
                <button id="addApptBtn" class="btn btn-sm btn-outline-primary">Add Appointment</button>
              </div>
            </div>

            <div id="pv_appts_list"></div>
          </div>

          <div class="tab-pane fade" id="tab-reports">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <div>
                <strong>Reports</strong>
                <div class="small-note">Upload / Download / Delete patient reports.</div>
              </div>
              <div>
                <input id="reportFileInput" type="file" accept=".pdf,image/*" style="display:none">
                <button id="uploadReportBtn" class="btn btn-sm btn-outline-secondary"><i class="bi bi-upload"></i> Upload Report</button>
              </div>
            </div>

            <div id="pv_reports_list"></div>
          </div>

          <div class="tab-pane fade" id="tab-notes">
            <div id="pv_notes" class="small-note"></div>
            <div class="mt-3">
              <textarea id="adminNoteInput" rows="3" class="form-control" placeholder="Write internal admin note..."></textarea>
              <div class="mt-2 text-end">
                <button id="saveAdminNoteBtn" class="btn btn-sm btn-primary">Save Note</button>
              </div>
            </div>
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- DELETE PATIENT CONFIRM -->
<div class="modal fade" id="patientDeleteModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body text-center p-4">
        <h5>Delete Patient?</h5>
        <p class="text-muted">This action will remove patient data including reports. This cannot be undone.</p>
        <div class="d-flex gap-2 justify-content-center mt-3">
          <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
          <button id="confirmDeletePatientBtn" class="btn btn-danger btn-sm">Delete</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- APPOINTMENT MODAL (Add / Reschedule) -->
<div class="modal fade" id="apptModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-md modal-dialog-centered">
    <form id="apptForm" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add / Reschedule Appointment</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="apptId">
        <div class="mb-2">
          <label class="form-label">Doctor</label>
          <input id="apptDoctor" class="form-control" placeholder="Dr. Raj Patel">
        </div>
        <div class="row g-2">
          <div class="col-md-6">
            <label class="form-label">Date</label>
            <input id="apptDate" type="date" class="form-control" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Time</label>
            <input id="apptTime" type="time" class="form-control" required>
          </div>
        </div>
        <div class="mt-2">
          <label class="form-label">Notes</label>
          <textarea id="apptNotes" rows="2" class="form-control"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary btn-sm">Save Appointment</button>
      </div>
    </form>
  </div>
</div>

<!-- bootstrap js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
/* Patient Management (frontend-only, localStorage)
   - Storage key: patients_data_v1
   - Data structure:
     patients: [
       {
         id, name, email, phone, dob, gender, address, notes, avatar (dataURL),
         lastVisit,
         reports: [{id, name, dataURL, mime, uploaded_at}],
         appointments: [{id, doctor, date, time, status (Pending/Approved/Rejected/Completed), notes}],
         adminNotes: ''
       }
     ]
*/

// Use uploaded image path as default avatar (developer requested)
const DEFAULT_AVATAR = '/mnt/data/5bd7db93-95f2-430d-8271-afa40a244bc6.png';
const STORAGE_KEY = 'patients_data_v1';

let patients = [];
let currentViewId = null;
let toDeletePatientId = null;
let apptEditPatientId = null;
let apptEditId = null;

// DOM
const tbody = document.getElementById('patientsTbody');
const patientCount = document.getElementById('patientCount');
const patientSearch = document.getElementById('patientSearch');
const apptStatusFilter = document.getElementById('apptStatusFilter');
const ageFilter = document.getElementById('ageFilter');

const patientModalEl = document.getElementById('patientModal');
const bsPatientModal = new bootstrap.Modal(patientModalEl);
const patientForm = document.getElementById('patientForm');

const pAvatarFile = document.getElementById('patientAvatarFile');
const pAvatarPreview = document.getElementById('patientAvatarPreview');
const pRemoveAvatarBtn = document.getElementById('patientRemoveAvatar');

const pvModalEl = document.getElementById('patientViewModal');
const bsPvModal = new bootstrap.Modal(pvModalEl);

const reportFileInput = document.getElementById('reportFileInput');
const uploadReportBtn = document.getElementById('uploadReportBtn');

const apptModalEl = document.getElementById('apptModal');
const bsApptModal = new bootstrap.Modal(apptModalEl);
const apptForm = document.getElementById('apptForm');

const confirmDeletePatientBtn = document.getElementById('confirmDeletePatientBtn');
const exportPatientsCsv = document.getElementById('exportPatientsCsv');

document.addEventListener('DOMContentLoaded', () => {
  loadData();
  renderPatients();
});

// load or seed
function loadData() {
  const raw = localStorage.getItem(STORAGE_KEY);
  if (raw) {
    try { patients = JSON.parse(raw); return; } catch(e){ console.error(e); }
  }

  // seed demo patients
  patients = [
    {
      id: Date.now()+1,
      name: 'Jane Moore',
      email: 'jane.moore@example.com',
      phone: '9876500100',
      dob: '1988-02-11',
      gender: 'Female',
      address: '12 Baker Street, London',
      notes: 'Hypertension. Allergic to penicillin.',
      avatar: DEFAULT_AVATAR,
      lastVisit: '2024-11-25',
      adminNotes: 'Monitor blood pressure monthly.',
      reports: [
        { id: 1, name: 'Blood Test 2024-11-12.pdf', dataURL: '', mime: 'application/pdf', uploaded_at: '2024-11-12' }
      ],
      appointments: [
        { id: 1, doctor: 'Dr Raj Patel', date: '2024-11-25', time: '10:30', status: 'Completed', notes: 'Follow up 3 months' },
        { id: 2, doctor: 'Dr S Kumar', date: '2024-12-10', time: '09:00', status: 'Pending', notes: 'Ultrasound' }
      ]
    },
    {
      id: Date.now()+2,
      name: 'Amelia Pond',
      email: 'amelia@example.com',
      phone: '9876500200',
      dob: '1990-05-20',
      gender: 'Female',
      address: '45 Oak Road',
      notes: '',
      avatar: DEFAULT_AVATAR,
      lastVisit: '2024-12-01',
      adminNotes: '',
      reports: [],
      appointments: [
        { id: 3, doctor: 'Dr Chloe Martin', date: '2024-12-01', time: '11:00', status: 'Approved', notes: 'Routine check' }
      ]
    }
  ];

  saveData();
}

function saveData() {
  localStorage.setItem(STORAGE_KEY, JSON.stringify(patients));
}

// render patients table
function renderPatients() {
  const q = (patientSearch.value || '').toLowerCase().trim();
  const apptStatus = apptStatusFilter.value;
  const ageSel = ageFilter.value;

  const filtered = patients.filter(p => {
    if (apptStatus) {
      // any appointment with that status?
      const has = (p.appointments || []).some(a => a.status === apptStatus);
      if (!has) return false;
    }
    if (ageSel) {
      const age = calcAge(p.dob);
      if (ageSel === '0-18' && !(age<=18)) return false;
      if (ageSel === '19-40' && !(age>=19 && age<=40)) return false;
      if (ageSel === '41-65' && !(age>=41 && age<=65)) return false;
      if (ageSel === '65+' && !(age>=65)) return false;
    }
    if (!q) return true;
    return (p.name||'').toLowerCase().includes(q) ||
           (p.phone||'').toLowerCase().includes(q) ||
           (p.email||'').toLowerCase().includes(q);
  });

  tbody.innerHTML = '';
  filtered.forEach(p => {
    const tr = document.createElement('tr');
    tr.innerHTML = `
      <td style="width:64px"><img src="${escapeHtml(p.avatar||DEFAULT_AVATAR)}" class="table-avatar" alt=""></td>
      <td><div class="fw-semibold">${escapeHtml(p.name)}</div><div class="small-note">${escapeHtml(p.address || '')}</div></td>
      <td>${escapeHtml(p.phone || '')}<div class="small-note">${escapeHtml(p.email || '')}</div></td>
      <td>${escapeHtml(p.dob || '')} <div class="small-note">${calcAge(p.dob)} yrs</div></td>
      <td>${escapeHtml(p.lastVisit || '—')}</td>
      <td>${(p.reports||[]).length}</td>
      <td class="text-end">
        <div class="btn-group btn-group-sm" role="group">
          <button class="btn btn-outline-primary" onclick="onViewPatient(${p.id})" title="View"><i class="bi bi-eye"></i></button>
          <button class="btn btn-outline-secondary" onclick="onEditPatient(${p.id})" title="Edit"><i class="bi bi-pencil"></i></button>
          <button class="btn btn-outline-danger" onclick="onDeletePatient(${p.id})" title="Delete"><i class="bi bi-trash"></i></button>
        </div>
      </td>
    `;
    tbody.appendChild(tr);
  });

  patientCount.textContent = patients.length;
}

// helpers
function escapeHtml(str){ if (str===null||str===undefined) return ''; return String(str).replaceAll('&','&amp;').replaceAll('<','&lt;').replaceAll('>','&gt;').replaceAll('"','&quot;'); }
function calcAge(dob) {
  if (!dob) return '—';
  const b = new Date(dob);
  const diff = Date.now() - b.getTime();
  const age = Math.floor(diff / (1000*60*60*24*365.25));
  return age;
}

// filters
patientSearch.addEventListener('input', renderPatients);
apptStatusFilter.addEventListener('change', renderPatients);
ageFilter.addEventListener('change', renderPatients);

// Add patient - open modal ready
document.getElementById('openAddPatientBtn').addEventListener('click', () => {
  document.getElementById('patientModalTitle').textContent = 'Add Patient';
  patientForm.reset();
  document.getElementById('patientId').value = '';
  pAvatarPreview.src = DEFAULT_AVATAR;
});

// avatar preview handlers
pAvatarFile.addEventListener('change', (e) => {
  const f = e.target.files[0];
  if (!f) return;
  const reader = new FileReader();
  reader.onload = () => { pAvatarPreview.src = reader.result; pAvatarPreview.dataset.custom = '1'; };
  reader.readAsDataURL(f);
});
pRemoveAvatarBtn.addEventListener('click', () => { pAvatarPreview.src = DEFAULT_AVATAR; pAvatarPreview.removeAttribute('data-custom'); pAvatarFile.value = ''; });

// Save patient (add/edit)
patientForm.addEventListener('submit', (ev) => {
  ev.preventDefault();
  const id = document.getElementById('patientId').value;
  const data = {
    id: id ? Number(id) : Date.now(),
    name: document.getElementById('p_name').value.trim(),
    email: document.getElementById('p_email').value.trim(),
    phone: document.getElementById('p_phone').value.trim(),
    dob: document.getElementById('p_dob').value,
    gender: document.getElementById('p_gender').value,
    address: document.getElementById('p_address').value.trim(),
    notes: document.getElementById('p_notes').value.trim(),
    avatar: pAvatarPreview.src || DEFAULT_AVATAR,
    lastVisit: document.getElementById('p_lastvisit').value,
    adminNotes: '',
    reports: [],
    appointments: []
  };

  if (!data.name) { alert('Please enter patient name'); return; }

  if (id) {
    const idx = patients.findIndex(x => x.id === Number(id));
    if (idx > -1) { patients[idx] = { ...patients[idx], ...data }; }
  } else {
    patients.unshift(data);
  }
  saveData();
  renderPatients();
  bsPatientModal.hide();
});

// Edit patient
function onEditPatient(id) {
  const p = patients.find(x => x.id === id);
  if (!p) return alert('Patient not found');
  document.getElementById('patientModalTitle').textContent = 'Edit Patient';
  document.getElementById('patientId').value = p.id;
  document.getElementById('p_name').value = p.name || '';
  document.getElementById('p_email').value = p.email || '';
  document.getElementById('p_phone').value = p.phone || '';
  document.getElementById('p_dob').value = p.dob || '';
  document.getElementById('p_gender').value = p.gender || 'Male';
  document.getElementById('p_address').value = p.address || '';
  document.getElementById('p_lastvisit').value = p.lastVisit || '';
  document.getElementById('p_notes').value = p.notes || '';
  pAvatarPreview.src = p.avatar || DEFAULT_AVATAR;
  bsPatientModal.show();
}

// View patient
function onViewPatient(id) {
  const p = patients.find(x => x.id === id);
  if (!p) return;
  currentViewId = id;
  // header
  document.getElementById('pv_avatar').src = p.avatar || DEFAULT_AVATAR;
  document.getElementById('pv_name').textContent = p.name;
  document.getElementById('pv_contact').textContent = `${p.phone || '—'} • ${p.email || '—'}`;
  document.getElementById('pv_address').textContent = p.address || '';
  document.getElementById('pv_gender').textContent = p.gender || '';
  document.getElementById('pv_age').textContent = calcAge(p.dob) + ' yrs';

  // details
  document.getElementById('pv_details').innerHTML = `
    <div><strong>Medical history</strong><div class="small-note mt-1">${escapeHtml(p.notes || '—')}</div></div>
    <div class="mt-2"><strong>Last Visit:</strong> ${escapeHtml(p.lastVisit || '—')}</div>
    <div class="mt-1"><strong>Admin Notes:</strong> <div class="small-note mt-1">${escapeHtml(p.adminNotes || '—')}</div></div>
  `;

  // appointments
  renderPatientAppointments(p);

  // reports
  renderPatientReports(p);

  // notes tab
  document.getElementById('pv_notes').textContent = p.adminNotes || '';

  bsPvModal.show();

  // wire edit & delete from view header
  document.getElementById('pv_edit_btn').onclick = () => { bsPvModal.hide(); setTimeout(()=> onEditPatient(id), 250); };
  document.getElementById('pv_delete_btn').onclick = () => { bsPvModal.hide(); onDeletePatient(id); };
}

// Delete patient
function onDeletePatient(id) {
  toDeletePatientId = id;
  const modal = new bootstrap.Modal(document.getElementById('patientDeleteModal'));
  modal.show();
}
confirmDeletePatientBtn.addEventListener('click', () => {
  if (!toDeletePatientId) return;
  patients = patients.filter(p => p.id !== toDeletePatientId);
  saveData();
  renderPatients();
  toDeletePatientId = null;
  bootstrap.Modal.getInstance(document.getElementById('patientDeleteModal')).hide();
});

// Render appointments inside patient view
function renderPatientAppointments(p) {
  const container = document.getElementById('pv_appts_list');
  container.innerHTML = '';
  (p.appointments||[]).forEach(a => {
    const div = document.createElement('div');
    div.className = 'd-flex justify-content-between align-items-center py-2 border-bottom';
    div.innerHTML = `
      <div>
        <div><strong>${escapeHtml(a.doctor)}</strong> <span class="small-note">• ${escapeHtml(a.date)} ${a.time ? ' ' + escapeHtml(a.time) : ''}</span></div>
        <div class="small-note mt-1">${escapeHtml(a.notes || '')}</div>
      </div>
      <div class="text-end">
        ${renderApptButtons(p.id, a)}
      </div>
    `;
    container.appendChild(div);
  });
  if ((p.appointments||[]).length === 0) container.innerHTML = '<div class="text-muted small">No appointments</div>';
}

// appointment action buttons
function renderApptButtons(patientId, appt) {
  const status = appt.status || 'Pending';
  let btns = `<div class="btn-group btn-group-sm" role="group">`;
  if (status === 'Pending') {
    btns += `<button class="btn btn-outline-success" onclick="onApproveAppt(${patientId}, ${appt.id})" title="Approve"><i class="bi bi-check-lg"></i></button>`;
    btns += `<button class="btn btn-outline-danger" onclick="onRejectAppt(${patientId}, ${appt.id})" title="Reject"><i class="bi bi-x-lg"></i></button>`;
  }
  btns += `<button class="btn btn-outline-secondary" onclick="onEditAppt(${patientId}, ${appt.id})" title="Reschedule"><i class="bi bi-clock"></i></button>`;
  if (status !== 'Completed') btns += `<button class="btn btn-outline-primary" onclick="onMarkCompleteAppt(${patientId}, ${appt.id})" title="Mark Completed"><i class="bi bi-check2-square"></i></button>`;
  btns += `</div>`;
  return btns;
}

function onApproveAppt(pid, aid) { changeApptStatus(pid, aid, 'Approved'); }
function onRejectAppt(pid, aid) { changeApptStatus(pid, aid, 'Rejected'); }
function onMarkCompleteAppt(pid, aid) { changeApptStatus(pid, aid, 'Completed'); }

function changeApptStatus(pid, aid, status) {
  const p = patients.find(x => x.id === pid);
  if (!p) return;
  const a = (p.appointments||[]).find(x => x.id === aid);
  if (!a) return;
  a.status = status;
  saveData();
  renderPatientAppointments(p);
  renderPatients();
}

// Add / edit appointment
document.getElementById('addApptBtn').addEventListener('click', () => {
  apptEditPatientId = currentViewId;
  apptEditId = null;
  apptForm.reset();
  bsApptModal.show();
});

function onEditAppt(pid, aid) {
  apptEditPatientId = pid;
  apptEditId = aid;
  const p = patients.find(x => x.id === pid);
  const a = (p.appointments||[]).find(x => x.id === aid);
  if (!a) return;
  document.getElementById('apptId').value = a.id;
  document.getElementById('apptDoctor').value = a.doctor;
  document.getElementById('apptDate').value = a.date;
  document.getElementById('apptTime').value = a.time;
  document.getElementById('apptNotes').value = a.notes || '';
  bsApptModal.show();
}

apptForm.addEventListener('submit', (ev) => {
  ev.preventDefault();
  const pid = apptEditPatientId;
  if (!pid) return alert('No patient selected');
  const p = patients.find(x => x.id === pid);
  if (!p) return;
  const id = document.getElementById('apptId').value;
  const payload = {
    id: id ? Number(id) : Date.now(),
    doctor: document.getElementById('apptDoctor').value.trim(),
    date: document.getElementById('apptDate').value,
    time: document.getElementById('apptTime').value,
    notes: document.getElementById('apptNotes').value.trim(),
    status: 'Pending'
  };
  if (!payload.date || !payload.doctor) { alert('Provide doctor and date'); return; }

  if (!p.appointments) p.appointments = [];
  if (id) {
    const idx = p.appointments.findIndex(x => x.id === Number(id));
    if (idx > -1) p.appointments[idx] = { ...p.appointments[idx], ...payload };
  } else {
    p.appointments.unshift(payload);
  }
  saveData();
  renderPatientAppointments(p);
  renderPatients();
  bsApptModal.hide();
});

// Reports: upload/download/delete
uploadReportBtn.addEventListener('click', () => {
  if (!currentViewId) return;
  reportFileInput.click();
});

reportFileInput.addEventListener('change', (e) => {
  const f = e.target.files[0];
  if (!f) return;
  const reader = new FileReader();
  reader.onload = () => {
    const p = patients.find(x => x.id === currentViewId);
    if (!p) return;
    if (!p.reports) p.reports = [];
    p.reports.unshift({
      id: Date.now(),
      name: f.name,
      dataURL: reader.result,
      mime: f.type,
      uploaded_at: new Date().toISOString().slice(0,10)
    });
    saveData();
    renderPatientReports(p);
    renderPatients();
  };
  reader.readAsDataURL(f);
  // reset input
  reportFileInput.value = '';
});

function renderPatientReports(p) {
  const container = document.getElementById('pv_reports_list');
  container.innerHTML = '';
  (p.reports||[]).forEach(r => {
    const div = document.createElement('div');
    div.className = 'd-flex justify-content-between align-items-center py-2 border-bottom';
    div.innerHTML = `
      <div>
        <div><strong>${escapeHtml(r.name)}</strong></div>
        <div class="small-note">${escapeHtml(r.uploaded_at || '')} • ${escapeHtml(r.mime || '')}</div>
      </div>
      <div class="text-end">
        <button class="btn btn-sm btn-outline-primary" onclick="downloadReport(${p.id}, ${r.id})"><i class="bi bi-download"></i></button>
        <button class="btn btn-sm btn-outline-danger" onclick="deleteReport(${p.id}, ${r.id})"><i class="bi bi-trash"></i></button>
      </div>
    `;
    container.appendChild(div);
  });
  if ((p.reports||[]).length === 0) container.innerHTML = '<div class="text-muted small">No reports</div>';
}

function downloadReport(pid, rid) {
  const p = patients.find(x => x.id === pid);
  if (!p) return;
  const r = (p.reports||[]).find(x => x.id === rid);
  if (!r) return alert('Report not found');
  const a = document.createElement('a');
  a.href = r.dataURL || '';
  a.download = r.name || 'report';
  document.body.appendChild(a);
  a.click();
  a.remove();
}

function deleteReport(pid, rid) {
  if (!confirm('Delete this report?')) return;
  const p = patients.find(x => x.id === pid);
  if (!p) return;
  p.reports = (p.reports || []).filter(x => x.id !== rid);
  saveData();
  renderPatientReports(p);
  renderPatients();
}

// admin notes
document.getElementById('saveAdminNoteBtn').addEventListener('click', () => {
  const val = document.getElementById('adminNoteInput').value.trim();
  const p = patients.find(x => x.id === currentViewId);
  if (!p) return;
  p.adminNotes = val;
  saveData();
  renderPatients();
  renderPatientNotes(p);
  alert('Note saved');
});

function renderPatientNotes(p) {
  document.getElementById('pv_notes').textContent = p.adminNotes || '';
}

// Export CSV
exportPatientsCsv.addEventListener('click', () => {
  if (!patients.length) return alert('No patients to export');
  const rows = [['id','name','email','phone','dob','gender','address','lastVisit','notes']];
  patients.forEach(p => {
    rows.push([p.id, p.name, p.email, p.phone, p.dob, p.gender, p.address, p.lastVisit, (p.notes||'').replaceAll(/\n/g,' ')]);
  });
  const csv = rows.map(r => r.map(c => `"${String(c||'').replaceAll('"','""')}"`).join(',')).join('\n');
  const blob = new Blob([csv], {type:'text/csv'});
  const url = URL.createObjectURL(blob);
  const a = document.createElement('a');
  a.href = url; a.download = 'patients.csv'; document.body.appendChild(a); a.click(); a.remove(); URL.revokeObjectURL(url);
});

// Utility: open edit patient from profile view
document.getElementById('pv_edit_btn').addEventListener('click', () => {
  // handled when viewing individual record; left for safety
});

// small helper: when pv modal hidden, reset currentViewId
pvModalEl.addEventListener('hidden.bs.modal', () => { currentViewId = null; });

// close helper for appt modal to reset edit id
apptModalEl.addEventListener('hidden.bs.modal', () => { apptEditPatientId = null; apptEditId = null; document.getElementById('apptId').value = ''; });

// initial render call
renderPatients();
</script>

<?php include 'components/backbtn.php'; ?>
</body>
</html>
