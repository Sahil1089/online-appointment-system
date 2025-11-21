<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Hospital Admin Dashboard</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

  <style>
    :root{
      --bg: #f4fbff;
      --card-bg: rgba(255,255,255,0.88);
      --accent: #38bdf8;
      --muted: #6b7280;
      --glass-border: rgba(255,255,255,0.7);
    }

    body { background: linear-gradient(180deg,#f7fbff 0%, #eef9ff 100%); font-family: Inter, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial; color:#0b1220; }

    /* layout */
    .app {
      min-height: 100vh;
      display: grid;
      grid-template-columns: 260px 1fr 320px;
      gap: 24px;
      padding: 24px;
      max-width: 1400px;
      margin: 0 auto;
    }

    /* desktop sidebar (visible lg and up) */
    .sidebar {
      background: var(--card-bg);
      border-radius: 12px;
      padding: 18px;
      box-shadow: 0 8px 30px rgba(9,30,66,0.06);
      border: 1px solid var(--glass-border);
      position: sticky;
      top: 24px;
      height: calc(100vh - 48px);
      overflow: auto;
    }
    .brand { display:flex; align-items:center; gap:12px; margin-bottom:18px; text-decoration:none; color:inherit; }
    .brand img { width:40px; height:40px; border-radius:8px; object-fit:cover; box-shadow: 0 6px 18px rgba(3,102,214,0.06); }
    .nav-link { color:var(--muted); font-weight:600; padding:10px 12px; border-radius:8px; display:flex; gap:10px; align-items:center; }
    .nav-link.active, .nav-link:hover { background: rgba(56,189,248,0.08); color:var(--accent); }

    /* main content */
    .main {
      padding: 6px 0;
    }

    .topbar {
      display:flex;
      justify-content:space-between;
      align-items:center;
      gap:12px;
      margin-bottom:14px;
    }

    .search {
      background:var(--card-bg);
      padding:10px 12px;
      border-radius:12px;
      min-width: 320px;
      border: 1px solid var(--glass-border);
    }

    .card-glass {
      background: var(--card-bg);
      border-radius: 12px;
      padding: 16px;
      border: 1px solid var(--glass-border);
      box-shadow: 0 8px 24px rgba(9,30,66,0.04);
    }

    .stats-grid { display:grid; grid-template-columns: repeat(4,1fr); gap:14px; margin-bottom:14px; }
    .stat { padding:14px; border-radius:10px; background: linear-gradient(180deg, rgba(255,255,255,0.7), rgba(255,255,255,0.6)); display:flex; flex-direction:column; gap:6px; }
    .stat .n { font-weight:800; font-size:1.25rem; }
    .stat .l { color:var(--muted); font-weight:600; font-size:0.9rem; }

    .grid-2 { display:grid; grid-template-columns: 1fr 340px; gap:14px; margin-bottom:14px; }
    .grid-3 { display:grid; grid-template-columns: 1fr 1fr; gap:14px; }

    /* right column */
    .rightcol {
      position: sticky;
      top:24px;
      height: calc(100vh - 48px);
      overflow:auto;
    }
    .calendar { border-radius:12px; padding:12px; background:var(--card-bg); border:1px solid var(--glass-border); }

    /* table */
    .table thead th { background: transparent; border-bottom: none; color:var(--muted); font-weight:700; font-size:0.9rem; }
    .table tbody td { vertical-align: middle; border-top:none; }

    /* responsive */
    @media (max-width: 1200px) {
      .app { grid-template-columns: 220px 1fr; }
      .rightcol { display:none; }
    }
    @media (max-width: 991px) {
      /* mobile: full-screen offcanvas will be used. hide desktop sidebar */
      .app { grid-template-columns: 1fr; padding:12px; max-width: 100%; }
      .sidebar-desktop { display: none; }
      .rightcol { display:none; }
      .search { min-width: 100%; }
      .stats-grid { grid-template-columns: repeat(2,1fr); }
      .grid-2 { grid-template-columns: 1fr; }
      .grid-3 { grid-template-columns: 1fr; }
    }

    /* Offcanvas customization (mobile full-screen) */
    .offcanvas-mobile .offcanvas-body {
      padding: 0;
    }
    /* full-screen width */
    @media (max-width: 991px) {
      .offcanvas-mobile.offcanvas-start {
        width: 100% !important;
        max-width: 100% !important;
      }
      .offcanvas-mobile .sidebar {
        height: 100vh;
        border-radius: 0;
      }
    }
  </style>
</head>
<body>

<div class="app">

  <!-- DESKTOP SIDEBAR (visible >=992px) -->
  <aside class="sidebar sidebar-desktop">
    <a href="#" class="brand">
      <img src="/mnt/data/5bd7db93-95f2-430d-8271-afa40a244bc6.png" alt="logo">
      <div>
        <div style="font-weight:800; font-size:1rem;">WellNest</div>
        <div style="font-size:0.82rem; color:var(--muted)">Hospital Admin</div>
      </div>
    </a>

    <hr style="border:none; height:1px; background:linear-gradient(90deg, rgba(0,0,0,0.04), rgba(255,255,255,0.4)); margin:10px 0;">

    <nav class="nav flex-column">
      <a class="nav-link active" href="#"><i class="bi bi-speedometer2"></i> Dashboard</a>
      <a class="nav-link" href="#"><i class="bi bi-people"></i> Patients</a>
      <a class="nav-link" href="#"><i class="bi bi-person-badge"></i> Doctors</a>
      <a class="nav-link" href="#"><i class="bi bi-clipboard-data"></i> Departments</a>
      <a class="nav-link" href="#"><i class="bi bi-calendar3"></i> Appointments</a>
      <a class="nav-link" href="#"><i class="bi bi-file-medical"></i> Tests & Labs</a>
      <a class="nav-link" href="#"><i class="bi bi-wallet2"></i> Billing</a>
      <a class="nav-link" href="#"><i class="bi bi-gear"></i> Settings</a>
    </nav>

    <div style="margin-top:18px;">
      <div class="small text-uppercase text-muted mb-2">Quick actions</div>
      <div class="d-flex flex-column gap-2">
        <button class="btn btn-sm btn-outline-primary">New Appointment</button>
        <button class="btn btn-sm btn-outline-success">Upload Report</button>
      </div>
    </div>

  </aside>

  <!-- MOBILE OFFCANVAS SIDEBAR (visible <992px) -->
  <div class="offcanvas offcanvas-start offcanvas-mobile d-lg-none" tabindex="-1" id="mobileSidebar" aria-labelledby="mobileSidebarLabel">
    <div class="offcanvas-header">
      <div class="d-flex align-items-center gap-2">
        <img src="/mnt/data/5bd7db93-95f2-430d-8271-afa40a244bc6.png" width="44" height="44" style="border-radius:8px; object-fit:cover;" alt="logo">
        <div>
          <div style="font-weight:800;">WellNest</div>
          <div style="font-size:0.82rem; color:var(--muted)">Hospital Admin</div>
        </div>
      </div>
      <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body p-0">
      <!-- reuse same sidebar content -->
      <aside class="sidebar">
        <nav class="nav flex-column p-2">
          <a class="nav-link active" href="#"><i class="bi bi-speedometer2"></i> Dashboard</a>
          <a class="nav-link" href="#"><i class="bi bi-people"></i> Patients</a>
          <a class="nav-link" href="#"><i class="bi bi-person-badge"></i> Doctors</a>
          <a class="nav-link" href="#"><i class="bi bi-clipboard-data"></i> Departments</a>
          <a class="nav-link" href="#"><i class="bi bi-calendar3"></i> Appointments</a>
          <a class="nav-link" href="#"><i class="bi bi-file-medical"></i> Tests & Labs</a>
          <a class="nav-link" href="#"><i class="bi bi-wallet2"></i> Billing</a>
          <a class="nav-link" href="#"><i class="bi bi-gear"></i> Settings</a>
        </nav>

        <div style="margin:18px;">
          <div class="small text-uppercase text-muted mb-2">Quick actions</div>
          <div class="d-flex flex-column gap-2">
            <button class="btn btn-sm btn-outline-primary">New Appointment</button>
            <button class="btn btn-sm btn-outline-success">Upload Report</button>
          </div>
        </div>
      </aside>
    </div>
  </div>

  <!-- MAIN CONTENT -->
  <main class="main">

    <!-- topbar -->
    <div class="topbar">
      <div class="d-flex align-items-center gap-3">
        <!-- Mobile hamburger (visible <992px) -->
        <button class="btn btn-outline-secondary d-lg-none me-1" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar" aria-controls="mobileSidebar" aria-label="Open menu">
          <i class="bi bi-list"></i>
        </button>

        <div class="search d-flex align-items-center gap-2">
          <i class="bi bi-search text-muted"></i>
          <input class="form-control form-control-borderless" style="border:0; background:transparent; outline:none;" placeholder="Search patients, doctors, tests..." />
        </div>
        <div class="ms-2 d-none d-md-flex">
          <button class="btn btn-outline-secondary btn-sm"><i class="bi bi-bell"></i></button>
          <button class="btn btn-outline-secondary btn-sm"><i class="bi bi-chat-dots"></i></button>
        </div>
      </div>

      <div class="d-flex align-items-center gap-3">
        <div class="text-end me-2 d-none d-sm-block">
          <div style="font-weight:700;">Admin Name</div>
          <div style="font-size:0.85rem; color:var(--muted)">WellNest</div>
        </div>
        <img src="/mnt/data/5bd7db93-95f2-430d-8271-afa40a244bc6.png" width="44" height="44" style="border-radius:8px; object-fit:cover; box-shadow:0 6px 18px rgba(3,102,214,0.06);" alt="avatar">
      </div>
    </div>

    <!-- stats -->
    <div class="stats-grid">
      <div class="stat card-glass">
        <div class="l">Total Patients</div>
        <div class="n">1,287</div>
        <div class="muted" style="color:var(--muted); font-size:0.85rem;">+3.2% vs last month</div>
      </div>
      <div class="stat card-glass">
        <div class="l">Active Doctors</div>
        <div class="n">965</div>
        <div class="muted" style="color:var(--muted); font-size:0.85rem;">+1.6%</div>
      </div>
      <div class="stat card-glass">
        <div class="l">Appointments</div>
        <div class="n">128</div>
        <div class="muted" style="color:var(--muted); font-size:0.85rem;">12 today</div>
      </div>
      <div class="stat card-glass">
        <div class="l">Beds Available</div>
        <div class="n">315</div>
        <div class="muted" style="color:var(--muted); font-size:0.85rem;">25 in ICU</div>
      </div>
    </div>

    <!-- charts + small stats -->
    <div class="grid-2">
      <div class="card-glass">
        <div class="d-flex justify-content-between align-items-start mb-2">
          <div>
            <h6 class="mb-0">Patient Overview</h6>
            <small class="text-muted">Admissions & discharges — last 6 months</small>
          </div>
          <div>
            <button class="btn btn-sm btn-outline-secondary">Last 6 months</button>
          </div>
        </div>
        <div style="height:260px;">
          <canvas id="overviewChart"></canvas>
        </div>
      </div>

      <div class="card-glass">
        <h6 class="mb-2">Quick Stats</h6>
        <div class="grid-3">
          <div class="card-glass mb-2">
            <div style="font-weight:700; font-size:1.4rem;">1,890</div>
            <div class="text-muted">Patient Overview</div>
          </div>
          <div class="card-glass mb-2">
            <div style="font-weight:700; font-size:1.4rem;">120</div>
            <div class="text-muted">Doctors On Duty</div>
          </div>
          <div class="card-glass mb-2">
            <div style="font-weight:700; font-size:1.4rem;">24</div>
            <div class="text-muted">Operations Today</div>
          </div>
        </div>

        <h6 class="mt-3">Doctors' Schedule</h6>
        <ul class="list-unstyled">
          <li class="d-flex justify-content-between align-items-center py-2 border-bottom">
            <div><strong>Dr. Peter Whitby</strong><div class="text-muted small">Cardiology • 9:00 - 17:00</div></div>
            <div><span class="badge bg-success">On duty</span></div>
          </li>
          <li class="d-flex justify-content-between align-items-center py-2 border-bottom">
            <div><strong>Dr. Amrita Kumar</strong><div class="text-muted small">Gynaecology • 10:00 - 18:00</div></div>
            <div><span class="badge bg-warning text-dark">Away</span></div>
          </li>
          <li class="d-flex justify-content-between align-items-center py-2">
            <div><strong>Dr. Chloe Martin</strong><div class="text-muted small">Paediatrics • 8:00 - 16:00</div></div>
            <div><span class="badge bg-info text-dark">On Call</span></div>
          </li>
        </ul>

      </div>
    </div>

    <!-- appointment history -->
    <div class="card-glass mt-3 mb-3">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
          <h5 class="mb-0">Recent Appointments</h5>
          <small class="text-muted">Latest visits & results</small>
        </div>
        <div>
          <button class="btn btn-sm btn-outline-primary">Export</button>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table align-middle">
          <thead>
            <tr>
              <th>Date</th>
              <th>Patient</th>
              <th>Department</th>
              <th>Doctor</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>25/11/2024</td>
              <td>Jane Moore</td>
              <td>Cardiology</td>
              <td>Dr Raj Patel</td>
              <td><span class="badge bg-success">Completed</span></td>
            </tr>
            <tr>
              <td>09/12/2024</td>
              <td>Amelia Pond</td>
              <td>Gynaecology</td>
              <td>Dr S. Kumar</td>
              <td><span class="badge bg-warning text-dark">Pending</span></td>
            </tr>
            <tr>
              <td>12/12/2024</td>
              <td>Claire Foster</td>
              <td>Pathology</td>
              <td>Lab</td>
              <td><span class="badge bg-info text-dark">Report Ready</span></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

  </main>

  <!-- RIGHT COLUMN: calendar / activity -->
  <aside class="rightcol">
    <div class="calendar card-glass mb-3">
      <div class="d-flex justify-content-between align-items-center mb-2">
        <div>
          <strong>July 2028</strong>
          <div class="text-muted small">Wednesday, 12 Jul</div>
        </div>
        <div><button class="btn btn-sm btn-outline-secondary"><i class="bi bi-plus"></i> Add</button></div>
      </div>

      <div style="margin-top:10px;">
        <div class="mb-2 p-2" style="background:linear-gradient(90deg, rgba(56,189,248,0.08), rgba(56,189,248,0.03)); border-radius:8px;">
          <div style="font-weight:700;">Morning Staff Meeting</div>
          <div class="text-muted small">09:00 - 09:30</div>
        </div>

        <div class="mb-2 p-2" style="background:linear-gradient(90deg, rgba(99,102,241,0.06), rgba(99,102,241,0.02)); border-radius:8px;">
          <div style="font-weight:700;">Patient Consultation - General</div>
          <div class="text-muted small">10:30 - 11:00</div>
        </div>

        <div class="mb-2 p-2" style="background:linear-gradient(90deg, rgba(34,197,94,0.06), rgba(34,197,94,0.02)); border-radius:8px;">
          <div style="font-weight:700;">Surgery - Orthopedics</div>
          <div class="text-muted small">13:00 - 15:00</div>
        </div>
      </div>
    </div>

    <div class="card-glass">
      <h6>Recent Activity</h6>
      <ul class="list-unstyled">
        <li class="py-2 border-bottom">
          <div class="small text-muted">02 min ago</div>
          <div><strong>Lab result</strong> for John Doe uploaded</div>
        </li>
        <li class="py-2 border-bottom">
          <div class="small text-muted">1 hour ago</div>
          <div><strong>Appointment</strong> booked for Amelia Pond</div>
        </li>
        <li class="py-2">
          <div class="small text-muted">Yesterday</div>
          <div><strong>Backup</strong> complete</div>
        </li>
      </ul>
    </div>
  </aside>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
  // Close mobile offcanvas when a nav-link is clicked (improves UX)
  document.addEventListener('DOMContentLoaded', function () {
    const offcanvasEl = document.getElementById('mobileSidebar');
    if (!offcanvasEl) return;

    // Use Bootstrap 5 Offcanvas API
    const bsOffcanvas = bootstrap.Offcanvas.getOrCreateInstance(offcanvasEl);

    // close when any link inside offcanvas is clicked
    offcanvasEl.querySelectorAll('.nav-link').forEach(link => {
      link.addEventListener('click', () => {
        bsOffcanvas.hide();
      });
    });
  });

  // Overview Chart (dummy)
  const overviewCtx = document.getElementById('overviewChart').getContext('2d');
  new Chart(overviewCtx, {
    type: 'line',
    data: {
      labels: ['Jul','Aug','Sep','Oct','Nov','Dec'],
      datasets: [{
        label: 'Admissions',
        data: [60,80,75,95,110,90],
        borderColor: '#38BDF8',
        backgroundColor: 'rgba(56,189,248,0.12)',
        fill: true,
        tension: 0.35,
        borderWidth: 2,
        pointRadius: 3
      },{
        label: 'Discharges',
        data: [50,70,60,80,95,85],
        borderColor: '#6EE7B7',
        backgroundColor: 'rgba(110,231,183,0.08)',
        fill: true,
        tension: 0.35,
        borderWidth: 2,
        pointRadius: 3
      }]
    },
    options: {
      plugins:{ legend:{ position:'top' } },
      scales: {
        x: { grid: { display:false } },
        y: { beginAtZero:true }
      },
      maintainAspectRatio: false
    }
  });
</script>

</body>
</html>
