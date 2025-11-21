<?php
session_start();

// If no user session, redirect (optional)
if (!isset($_SESSION['user'])) {
    echo "No user session found!";
    exit;
}

$user = $_SESSION['user'];

$userName      = $user['name'];
$userEmail     = $user['email'];
$userPhone     = $user['phone'];
$userAddress   = $user['address'];
$user_gender    = $user['gender'];
$user_dob       = $user['dob'];
$userId =$user['id'];
$latest_tests   = $user['latest_tests'];
$appointments   = $user['appointments'];
?>





<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Patient Profile — Dashboard</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

  <!-- Chart.js for stats -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

  <style>
    :root{
      --sky-1:#E0F6FF;
      --sky-2:#C9EEFF;
      --accent:#38BDF8;
      --muted:#6b7280;
      --glass-bg: rgba(255,255,255,0.55);
      --card-blur: 8px;
    }

    body{
      background: linear-gradient(180deg, #f6fbff 0%, #eef9ff 100%);
      font-family: Inter, ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
      color: #0f172a;
      padding: 24px;
    }

    .page-wrap{
      max-width: 1200px;
      margin: 0 auto;
    }

    /* Header */
    .page-title {
      display:flex;
      align-items:center;
      gap:14px;
      margin-bottom:18px;
    }
    .page-title h1{ font-size:20px; margin:0; color:#0b1220; font-weight:700; }
    .page-title p{ margin:0; color:var(--muted); font-size:0.95rem; }

    /* Glass card */
    .glass-card{
      background: var(--glass-bg);
      border-radius: 14px;
      padding:18px;
      box-shadow: 0 6px 24px rgba(14,30,50,0.06);
      backdrop-filter: blur(var(--card-blur));
      border: 1px solid rgba(255,255,255,0.6);
    }

    .profile-left .glass-card {
      text-align:left;
    }

    .avatar {
      width:96px;
      height:96px;
      border-radius:12px;
      object-fit:cover;
      border: 3px solid rgba(255,255,255,0.7);
      box-shadow: 0 6px 18px rgba(14,30,50,0.06);
    }

    .name { font-weight:700; font-size:1.1rem; margin-top:8px; }
    .meta { color:var(--muted); font-size:0.95rem; margin-bottom:8px; }

    .muted-small { color:var(--muted); font-size:0.9rem; }

    /* Tests & reports list */
    .list-item{
      display:flex;
      align-items:flex-start;
      gap:12px;
      padding:10px;
      border-radius:10px;
      background: linear-gradient(180deg, rgba(255,255,255,0.6), rgba(255,255,255,0.45));
      border:1px solid rgba(200,230,250,0.6);
      margin-bottom:10px;
    }

    .chip{
      width:44px; height:44px; border-radius:10px; display:grid; place-items:center;
      background:linear-gradient(140deg, rgba(56,189,248,0.12), rgba(56,189,248,0.06));
      color:var(--accent);
      font-weight:700;
      font-size:1.1rem;
    }

    /* grid tiles */
    .tile {
      border-radius:12px;
      padding:14px;
      text-align:left;
      background: linear-gradient(180deg, rgba(255,255,255,0.6), rgba(255,255,255,0.45));
      border: 1px solid rgba(200,230,250,0.6);
      box-shadow: 0 6px 16px rgba(14,30,50,0.04);
    }
    .tile .title { font-weight:700; color:#0b1220; }
    .tile .sub { color:var(--muted); font-size:0.9rem; }

    /* appointment history table */
    .table thead th {
      border-bottom: none;
      color: var(--muted);
      font-size:0.9rem;
      font-weight:600;
    }
    .table tbody td {
      vertical-align: middle;
      border-top: none;
      background: transparent;
    }

    /* small stat cards */
    .stat {
      display:flex;
      align-items:center;
      gap:12px;
      padding:12px;
      border-radius:12px;
      background: linear-gradient(90deg, rgba(255,255,255,0.6), rgba(255,255,255,0.5));
      border: 1px solid rgba(200,230,250,0.6);
    }
    .stat .num { font-weight:800; font-size:1.2rem; color:#06283D; }
    .stat .lbl { color:var(--muted); font-size:0.9rem; }

    /* responsive tweaks */
    @media (max-width: 991px){
      .avatar { width:86px; height:86px; }
    }
    @media (max-width: 767px){
      body{ padding:12px; }
    }
  </style>
</head>
<body>
  <div class="page-wrap">

    <!-- PAGE TITLE -->
    <div class="page-title">
      <div style="background:linear-gradient(135deg,var(--sky-2),#fff); width:46px;height:46px;border-radius:10px;display:grid;place-items:center;box-shadow:0 8px 20px rgba(3,102,214,0.06);">
        <i class="bi bi-person-badge" style="color:var(--accent); font-size:20px;"></i>
      </div>
      <div>
        <h1>MyProfile</h1>
        <!-- <p class="text-muted">Overview, recent tests, appointment history and clinical statistics</p> -->
      </div>
    </div>

    <div class="row g-4">

      <!-- LEFT COLUMN -->
      <div class="col-lg-4 profile-left">
        <div class="glass-card d-flex flex-column align-items-start">
          <div class="d-flex align-items-center gap-3 w-100">
            <img src="<?php echo $avatar; ?>" alt="avatar" class="avatar">
            <div>
              <div class="name"><?php echo $userName; ?></div>
              <div class="meta"><?php echo $userEmail; ?></div>
             
            </div>
          </div>

          <hr style="width:100%; border-top:1px solid rgba(15,23,42,0.05); margin:12px 0;">

          <div class="w-100">
            <h6 class="fw-bold mb-2">Contact Details</h6>
            <div class="muted-small mb-2"><i class="bi bi-telephone me-2"></i> <?php echo $userPhone; ?></div>
            <div class="muted-small mb-2"><i class="bi bi-envelope me-2"></i> <?php echo $userEmail; ?></div>
            <div class="muted-small"><i class="bi bi-house me-2"></i> <?php echo $userAddress; ?></div>
          </div>

          <div class="w-100 mt-3 d-flex gap-2">
            <a href="#" class="btn btn-outline-primary btn-sm">Edit Profile</a>
           
          </div>
        </div>

        <!-- Latest Tests -->
        <div class="glass-card mt-4">
          <h6 class="fw-bold mb-3">Latest Tests</h6>
<?php foreach ($latest_tests as $test): ?>
<div class="list-item">
    <div class="chip"></div>
    <div class="flex-grow-1">
      <div class="fw-semibold"><?= $test['name'] ?></div>
      <div class="muted-small"><?= $test['date'] ?></div>
    </div>
    <div class="text-end">
      <a class="btn btn-sm btn-outline-primary" href="<?= $test['file'] ?>">View report</a>
    </div>
</div>
<?php endforeach; ?>


          <div class="mt-2 text-center">
            <a class="btn btn-sm btn-outline-secondary" href="#">View All</a>
          </div>
        </div>

        <!-- Reports quick -->


      <!-- RIGHT COLUMN -->
      <div class="col-lg-8">

        <!-- Overview + Stats -->
        <div class="d-flex gap-3 mb-4 flex-column flex-md-row">
          <div class="flex-grow-1 tile glass-card">
            <div class="d-flex justify-content-between align-items-start">
              <div>
                <div class="title">Overview</div>
                <div class="sub">Quick patient details</div>
              </div>
              <div class="text-end muted-small">ID: <strong><?php echo $userId; ?></strong></div>
            </div>

            <div class="row mt-3">
              <div class="col-sm-6 mb-2">
                <div class="muted-small">Gender</div>
                <div class="fw-semibold"><?php echo $user_gender; ?></div>
              </div>
              <div class="col-sm-6 mb-2">
                <div class="muted-small">Date of Birth</div>
                <div class="fw-semibold"><?php echo $user_dob; ?></div>
              </div>
              <div class="col-sm-6 mb-2">
                <div class="muted-small">Next of Kin</div>
                <div class="fw-semibold">Dan Stevens</div>
              </div>
              <div class="col-sm-6 mb-2">
                <div class="muted-small">Allergies</div>
                <div class="fw-semibold">Hayfever, crayfish</div>
              </div>
            </div>
          </div>

          <div style="width:260px;" class="tile glass-card">
            <div class="title">Statistics</div>
            <div class="sub mb-2">Summary of clinical activity</div>

            <div class="d-flex gap-2 flex-column">
              <div class="stat">
                <div>
                  <div class="num">8</div>
                  <div class="lbl">Appointments</div>
                </div>
                <div class="ms-auto"><i class="bi bi-calendar2-check" style="font-size:20px;color:var(--accent)"></i></div>
              </div>

              <div class="stat">
                <div>
                  <div class="num">14</div>
                  <div class="lbl">Tests</div>
                </div>
                <div class="ms-auto"><i class="bi bi-file-medical" style="font-size:20px;color:var(--accent)"></i></div>
              </div>

              <div class="stat">
                <div>
                  <div class="num">3</div>
                  <div class="lbl">Lab Alerts</div>
                </div>
                <div class="ms-auto"><i class="bi bi-exclamation-triangle" style="font-size:20px;color:var(--accent)"></i></div>
              </div>
            </div>

          </div>
        </div>

        <!-- Appointment history -->
        <div class="glass-card mb-4">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
              <h5 class="mb-0">Appointment History</h5>
              <div class="muted-small">Recent visits and statuses</div>
            </div>
            <div>
              <a class="btn btn-sm btn-outline-primary" href="#">Export</a>
            </div>
          </div>

          <div class="table-responsive">
            <table class="table align-middle">
              <thead>
                <tr>
                  <th scope="col">Date</th>
                  <th scope="col">Department</th>
                  <th scope="col">Doctor</th>
                  <th scope="col">Status</th>
                  <th scope="col">Notes</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>25/11/2024</td>
                  <td>Cardiology</td>
                  <td>Dr. Raj Patel</td>
                  <td><span class="badge bg-success">Completed</span></td>
                  <td>Follow up in 3 months</td>
                </tr>
                <tr>
                  <td>09/12/2024</td>
                  <td>Gynaecology</td>
                  <td>Dr. S. Kumar</td>
                  <td><span class="badge bg-warning text-dark">Pending</span></td>
                  <td>Ultrasound scheduled</td>
                </tr>
                <tr>
                  <td>12/12/2024</td>
                  <td>Pathology</td>
                  <td>Lab</td>
                  <td><span class="badge bg-info text-dark">Report Ready</span></td>
                  <td>Blood & urine tests</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <!-- Reports / visual statistics -->
        <div class="glass-card">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
              <h5 class="mb-0">Clinical Statistics</h5>
              <div class="muted-small">Visual summary of tests performed</div>
            </div>
            <div>
              <a class="btn btn-sm btn-outline-primary" href="#">View Full Report</a>
            </div>
          </div>

          <div class="row align-items-center">
            <div class="col-md-6">
              <canvas id="testsChart" height="220"></canvas>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <div class="fw-semibold">Most common tests</div>
                <div class="muted-small">Percentage breakdown</div>
              </div>

              <ul class="list-unstyled">
                <li class="d-flex justify-content-between mb-2">
                  <div><i class="bi bi-droplet me-2 text-info"></i> Blood Tests</div>
                  <div class="fw-bold">45%</div>
                </li>
                <li class="d-flex justify-content-between mb-2">
                  <div><i class="bi bi-heart-pulse me-2 text-danger"></i> ECG</div>
                  <div class="fw-bold">25%</div>
                </li>
                <li class="d-flex justify-content-between mb-2">
                  <div><i class="bi bi-file-earmark-text me-2 text-warning"></i> Imaging</div>
                  <div class="fw-bold">20%</div>
                </li>
                <li class="d-flex justify-content-between mb-2">
                  <div><i class="bi bi-thermometer-sun me-2 text-success"></i> Others</div>
                  <div class="fw-bold">10%</div>
                </li>
              </ul>

            </div>
          </div>
        </div>

      </div>
    </div>

  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    // Chart: tests per month (dummy data)
    const ctx = document.getElementById('testsChart');
    if (ctx) {
      new Chart(ctx, {
        type: 'line',
        data: {
          labels: ['Jul','Aug','Sep','Oct','Nov','Dec'],
          datasets: [{
            label: 'Tests',
            data: [8, 10, 7, 12, 14, 9],
            fill: true,
            tension: 0.35,
            backgroundColor: 'rgba(56,189,248,0.12)',
            borderColor: '#38BDF8',
            pointBackgroundColor: '#fff',
            pointRadius: 4,
            borderWidth: 2
          }]
        },
        options: {
          plugins: {
            legend: { display: false }
          },
          scales: {
            x: { grid: { display:false } },
            y: { beginAtZero:true, ticks: { stepSize: 5 } }
          },
          maintainAspectRatio: false
        }
      });
    }
  </script>

</body>
</html>
