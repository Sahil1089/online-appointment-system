<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Admin — Doctors</title>

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
      font-family: Inter, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
      color:#0b1220;
      padding:20px;
    }

    .page {
      max-width:1200px;
      margin:0 auto;
    }

    .card-glass {
      background: var(--card-bg);
      border-radius: 12px;
      padding: 16px;
      border: 1px solid var(--glass-border);
      box-shadow: 0 8px 24px rgba(9,30,66,0.04);
    }

    .table-avatar {
      width:44px; height:44px; object-fit:cover; border-radius:8px;
      box-shadow:0 6px 16px rgba(3,102,214,0.06);
    }

    .filter-row .form-control, .filter-row .form-select {
      background: transparent;
      border: 1px solid rgba(0,0,0,0.06);
    }

    /* small screens adjustments */
    @media (max-width: 768px) {
      .filters { flex-direction: column; gap:8px; }
      .table-responsive { font-size: 0.95rem; }
    }
  </style>
</head>
<body>

<div class="page">

  <div class="d-flex align-items-center justify-content-between mb-3">
    <div>
      <h4 class="mb-0">Doctors Management</h4>
      <small class="text-muted">Manage doctors — add, edit, remove and view profiles.</small>
    </div>
    <div class="d-flex gap-2">
      <button class="btn btn-outline-secondary" id="exportCsvBtn"><i class="bi bi-download"></i> Export CSV</button>
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#doctorModal" id="openAddBtn">
        <i class="bi bi-plus-lg"></i> Add Doctor
      </button>
    </div>
  </div>

  <div class="card-glass mb-3">
    <div class="d-flex align-items-center justify-content-between flex-wrap filter-row">
      <div class="d-flex gap-2 filters">
        <div>
          <input id="searchInput" class="form-control" placeholder="Search by name, specialization, email">
        </div>
        <div>
          <select id="deptFilter" class="form-select">
            <option value="">All Departments</option>
            <option>Cardiology</option>
            <option>Paediatrics</option>
            <option>Gynaecology</option>
            <option>Neurology</option>
            <option>Orthopedics</option>
            <option>Pathology</option>
          </select>
        </div>
        <div>
          <select id="statusFilter" class="form-select">
            <option value="">All Status</option>
            <option>Active</option>
            <option>On Leave</option>
            <option>Inactive</option>
          </select>
        </div>
      </div>

      <div class="text-muted small">Total doctors: <span id="totalCount">0</span></div>
    </div>
  </div>

  <div class="card-glass">
    <div class="table-responsive">
      <table class="table align-middle" id="doctorsTable">
        <thead>
          <tr>
            <th></th>
            <th>Name</th>
            <th>Specialization</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Experience</th>
            <th>Status</th>
            <th class="text-end">Actions</th>
          </tr>
        </thead>
        <tbody id="doctorsTbody">
          <!-- rows rendered by JS -->
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- DOCTOR MODAL (Add / Edit) -->
<div class="modal fade" id="doctorModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <form id="doctorForm" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="doctorModalTitle">Add Doctor</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="doctorId">
        <div class="row g-3">
          <div class="col-md-4 text-center">
            <img id="avatarPreview" src="/mnt/data/5bd7db93-95f2-430d-8271-afa40a244bc6.png" class="mb-3" style="width:150px;height:150px;object-fit:cover;border-radius:12px;">
            <div class="d-grid gap-2">
              <input class="form-control form-control-sm" type="file" id="avatarFile" accept="image/*">
              <button type="button" class="btn btn-sm btn-outline-secondary" id="removeAvatarBtn">Remove</button>
            </div>
          </div>

          <div class="col-md-8">
            <div class="row g-2">
              <div class="col-md-6">
                <label class="form-label">Full name</label>
                <input id="name" class="form-control" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Email</label>
                <input id="email" type="email" class="form-control" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Phone</label>
                <input id="phone" class="form-control">
              </div>
              <div class="col-md-6">
                <label class="form-label">Specialization / Department</label>
                <input id="specialization" class="form-control" placeholder="Cardiology">
              </div>
              <div class="col-md-6">
                <label class="form-label">Experience (yrs)</label>
                <input id="experience" type="number" min="0" class="form-control">
              </div>
              <div class="col-md-6">
                <label class="form-label">Status</label>
                <select id="status" class="form-select">
                  <option>Active</option>
                  <option>On Leave</option>
                  <option>Inactive</option>
                </select>
              </div>
              <div class="col-12">
                <label class="form-label">Bio / Notes</label>
                <textarea id="bio" rows="3" class="form-control"></textarea>
              </div>
            </div>
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary" id="saveDoctorBtn">Save</button>
      </div>
    </form>
  </div>
</div>

<!-- VIEW PROFILE MODAL -->
<div class="modal fade" id="viewModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-md modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body p-4 text-center">
        <img id="viewAvatar" src="/mnt/data/5bd7db93-95f2-430d-8271-afa40a244bc6.png" style="width:110px;height:110px;object-fit:cover;border-radius:12px;" class="mb-3">
        <h5 id="viewName"></h5>
        <p class="text-muted mb-1" id="viewSpec"></p>
        <p class="small text-muted" id="viewEmail"></p>
        <div class="text-start mt-3">
          <strong>Phone:</strong> <span id="viewPhone"></span><br>
          <strong>Experience:</strong> <span id="viewExp"></span> years<br>
          <strong>Status:</strong> <span id="viewStatus"></span><br>
          <strong>Bio:</strong>
          <div id="viewBio" class="mt-2 text-muted small"></div>
        </div>
      </div>
      <div class="modal-footer justify-content-between">
        <div>
          <button class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Close</button>
        </div>
        <div>
          <button id="viewEditBtn" class="btn btn-sm btn-primary"><i class="bi bi-pencil"></i> Edit</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- DELETE CONFIRM -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body text-center p-4">
        <h5 class="mb-3">Delete Doctor?</h5>
        <p class="text-muted">This action cannot be undone.</p>
        <div class="d-flex gap-2 justify-content-center mt-3">
          <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
          <button id="confirmDeleteBtn" class="btn btn-danger btn-sm">Delete</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
/*
  Doctor Management (client-side)
  - Uses localStorage key: doctors_data
  - Full CRUD with image preview (stores image as dataURL)
*/

const DEFAULT_AVATAR = '/mnt/data/5bd7db93-95f2-430d-8271-afa40a244bc6.png';
const STORAGE_KEY = 'doctors_data_v1';

let doctors = [];
let editId = null;
let deleteId = null;

// DOM refs
const tbody = document.getElementById('doctorsTbody');
const totalCount = document.getElementById('totalCount');
const searchInput = document.getElementById('searchInput');
const deptFilter = document.getElementById('deptFilter');
const statusFilter = document.getElementById('statusFilter');

const doctorModalEl = document.getElementById('doctorModal');
const bsDoctorModal = new bootstrap.Modal(doctorModalEl);
const doctorForm = document.getElementById('doctorForm');
const doctorModalTitle = document.getElementById('doctorModalTitle');

const avatarFile = document.getElementById('avatarFile');
const avatarPreview = document.getElementById('avatarPreview');
const removeAvatarBtn = document.getElementById('removeAvatarBtn');

const viewModalEl = document.getElementById('viewModal');
const bsViewModal = new bootstrap.Modal(viewModalEl);

const deleteModalEl = document.getElementById('deleteModal');
const bsDeleteModal = new bootstrap.Modal(deleteModalEl);

// form fields
const fldId = document.getElementById('doctorId');
const fldName = document.getElementById('name');
const fldEmail = document.getElementById('email');
const fldPhone = document.getElementById('phone');
const fldSpec = document.getElementById('specialization');
const fldExp = document.getElementById('experience');
const fldStatus = document.getElementById('status');
const fldBio = document.getElementById('bio');

const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
const exportCsvBtn = document.getElementById('exportCsvBtn');

// Initialize
document.addEventListener('DOMContentLoaded', () => {
  loadData();
  renderTable();
});

// Load from localStorage or seed demo data
function loadData() {
  const raw = localStorage.getItem(STORAGE_KEY);
  if (raw) {
    try {
      doctors = JSON.parse(raw);
      return;
    } catch (e) {
      console.error('Parsing storage failed', e);
    }
  }

  // seed demo data
  doctors = [
    {
      id: Date.now() + 1,
      name: 'Dr. Raj Patel',
      email: 'raj.patel@example.com',
      phone: '9876500011',
      specialization: 'Cardiology',
      experience: 12,
      status: 'Active',
      bio: 'Senior cardiologist with expertise in interventions.',
      avatar: DEFAULT_AVATAR
    },
    {
      id: Date.now() + 2,
      name: 'Dr. Amrita Kumar',
      email: 'amrita.kumar@example.com',
      phone: '9876500022',
      specialization: 'Gynaecology',
      experience: 9,
      status: 'On Leave',
      bio: 'Specialist in maternal health and complex deliveries.',
      avatar: DEFAULT_AVATAR
    }
  ];
  saveData();
}

function saveData() {
  localStorage.setItem(STORAGE_KEY, JSON.stringify(doctors));
}

function renderTable() {
  const q = (searchInput.value || '').toLowerCase().trim();
  const dept = deptFilter.value;
  const status = statusFilter.value;

  const filtered = doctors.filter(d => {
    if (dept && d.specialization !== dept) return false;
    if (status && d.status !== status) return false;
    if (!q) return true;
    return (d.name || '').toLowerCase().includes(q) ||
           (d.specialization || '').toLowerCase().includes(q) ||
           (d.email || '').toLowerCase().includes(q) ||
           (d.phone || '').toLowerCase().includes(q);
  });

  tbody.innerHTML = '';
  filtered.forEach(d => {
    const tr = document.createElement('tr');

    tr.innerHTML = `
      <td style="width:64px"><img src="${escapeHtml(d.avatar || DEFAULT_AVATAR)}" class="table-avatar" alt=""></td>
      <td><div class="fw-semibold">${escapeHtml(d.name)}</div></td>
      <td>${escapeHtml(d.specialization)}</td>
      <td>${escapeHtml(d.phone)}</td>
      <td><a href="mailto:${escapeHtml(d.email)}">${escapeHtml(d.email)}</a></td>
      <td>${escapeHtml(d.experience ?? '')} yrs</td>
      <td>${renderStatusBadge(d.status)}</td>
      <td class="text-end">
        <div class="btn-group btn-group-sm" role="group" aria-label="actions">
          <button class="btn btn-outline-primary" onclick="onView(${d.id})" title="View"><i class="bi bi-eye"></i></button>
          <button class="btn btn-outline-secondary" onclick="onEdit(${d.id})" title="Edit"><i class="bi bi-pencil"></i></button>
          <button class="btn btn-outline-danger" onclick="onDelete(${d.id})" title="Delete"><i class="bi bi-trash"></i></button>
        </div>
      </td>
    `;
    tbody.appendChild(tr);
  });

  totalCount.textContent = doctors.length;
}

// helpers
function renderStatusBadge(s) {
  if (!s) return '';
  const map = {
    'Active': 'success',
    'On Leave': 'warning',
    'Inactive': 'secondary'
  };
  const cls = map[s] || 'secondary';
  return `<span class="badge bg-${cls}">${escapeHtml(s)}</span>`;
}

function escapeHtml(str) {
  if (str === null || str === undefined) return '';
  return String(str).replaceAll('&','&amp;').replaceAll('<','&lt;').replaceAll('>','&gt;').replaceAll('"','&quot;');
}

// events: filters
searchInput.addEventListener('input', renderTable);
deptFilter.addEventListener('change', renderTable);
statusFilter.addEventListener('change', renderTable);

// Add button opens empty form
document.getElementById('openAddBtn').addEventListener('click', () => {
  doctorModalTitle.textContent = 'Add Doctor';
  doctorForm.reset();
  fldId.value = '';
  avatarPreview.src = DEFAULT_AVATAR;
  editId = null;
});

// Avatar upload preview
avatarFile.addEventListener('change', (e) => {
  const f = e.target.files[0];
  if (!f) return;
  const reader = new FileReader();
  reader.onload = () => {
    avatarPreview.src = reader.result;
    avatarPreview.dataset.custom = '1';
  };
  reader.readAsDataURL(f);
});
removeAvatarBtn.addEventListener('click', () => {
  avatarPreview.src = DEFAULT_AVATAR;
  avatarPreview.removeAttribute('data-custom');
  avatarFile.value = '';
});

// Submit Add/Edit
doctorForm.addEventListener('submit', (e) => {
  e.preventDefault();
  const id = fldId.value;
  const payload = {
    id: id ? Number(id) : Date.now(),
    name: fldName.value.trim(),
    email: fldEmail.value.trim(),
    phone: fldPhone.value.trim(),
    specialization: fldSpec.value.trim(),
    experience: Number(fldExp.value) || 0,
    status: fldStatus.value,
    bio: fldBio.value.trim(),
    avatar: avatarPreview.src || DEFAULT_AVATAR
  };

  if (!payload.name || !payload.email) {
    alert('Please provide name and email.');
    return;
  }

  if (id) {
    // edit
    const idx = doctors.findIndex(d => d.id === Number(id));
    if (idx > -1) {
      doctors[idx] = payload;
    }
  } else {
    // add
    doctors.unshift(payload);
  }

  saveData();
  renderTable();
  bsDoctorModal.hide();
});

// Edit
function onEdit(id) {
  const d = doctors.find(x => x.id === id);
  if (!d) return alert('Doctor not found');
  doctorModalTitle.textContent = 'Edit Doctor';
  fldId.value = d.id;
  fldName.value = d.name;
  fldEmail.value = d.email;
  fldPhone.value = d.phone;
  fldSpec.value = d.specialization;
  fldExp.value = d.experience;
  fldStatus.value = d.status;
  fldBio.value = d.bio;
  avatarPreview.src = d.avatar || DEFAULT_AVATAR;
  avatarPreview.dataset.custom = d.avatar && d.avatar !== DEFAULT_AVATAR ? '1' : '';
  bsDoctorModal.show();
}

// View
function onView(id) {
  const d = doctors.find(x => x.id === id);
  if (!d) return;
  document.getElementById('viewAvatar').src = d.avatar || DEFAULT_AVATAR;
  document.getElementById('viewName').textContent = d.name;
  document.getElementById('viewSpec').textContent = d.specialization;
  document.getElementById('viewEmail').textContent = d.email;
  document.getElementById('viewPhone').textContent = d.phone;
  document.getElementById('viewExp').textContent = d.experience;
  document.getElementById('viewStatus').innerHTML = renderStatusBadge(d.status);
  document.getElementById('viewBio').textContent = d.bio;
  bsViewModal.show();

  // wire edit from view
  document.getElementById('viewEditBtn').onclick = () => {
    bsViewModal.hide();
    setTimeout(()=> onEdit(id), 250);
  };
}

// Delete
function onDelete(id) {
  deleteId = id;
  bsDeleteModal.show();
}
confirmDeleteBtn.addEventListener('click', () => {
  if (deleteId == null) return;
  doctors = doctors.filter(d => d.id !== deleteId);
  saveData();
  renderTable();
  deleteId = null;
  bsDeleteModal.hide();
});

// clicking nav link inside offcanvas should close - this page doesn't have offcanvas sidebar but kept behavior if used in layout

// Export CSV
exportCsvBtn.addEventListener('click', () => {
  if (!doctors.length) return alert('No doctors to export');
  const rows = [
    ['id','name','email','phone','specialization','experience','status','bio']
  ];
  doctors.forEach(d => {
    rows.push([d.id, d.name, d.email, d.phone, d.specialization, d.experience, d.status, d.bio.replaceAll(/\r?\n/g,' ')]);
  });
  const csv = rows.map(r => r.map(c => `"${String(c).replaceAll('"','""')}"`).join(',')).join('\n');
  const blob = new Blob([csv], {type: 'text/csv'});
  const url = URL.createObjectURL(blob);
  const a = document.createElement('a');
  a.href = url;
  a.download = 'doctors.csv';
  document.body.appendChild(a);
  a.click();
  a.remove();
  URL.revokeObjectURL(url);
});

// Utility: clicking a nav link (if offcanvas present) will close it - handled in parent layout script if needed




</script>
       <a href="javascript:history.back()" 
   style="padding:8px 18px; position:absolute;
   bottom:16px;background-color:whitesmoke; text-decoration:none; margin-right:auto;">
    Back
</a>
</body>
</html>
