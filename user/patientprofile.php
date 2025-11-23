<?php
session_start();

// Simple guard: require a logged-in user
if (!isset($_SESSION['user'])) {
    // In production redirect to login page instead
    echo "No user session found!";
    exit;
}

// User data (from session)
$user = $_SESSION['user'];

// Basic fields with safe fallbacks
$userName     = $user['name'] ?? 'Unknown User';
$userEmail    = $user['email'] ?? 'noreply@example.com';
$userPhone    = $user['phone'] ?? '—';
$userAddress  = $user['address'] ?? '—';
$userGender   = $user['gender'] ?? '—';
$userDob      = $user['dob'] ?? '—';
$userId       = $user['id'] ?? '—';
$latest_tests = $user['latest_tests'] ?? [];
$appointments = $user['appointments'] ?? [];
// Avatar (optional): use provided or a placeholder
$avatar = $user['avatar'] ?? '/assets/images/avatar-placeholder.png';
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Patient Profile — Dashboard</title>
<!-- css file -->
  <link rel="stylesheet" href="../styles/profile.css">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

  <!-- Chart.js (for charts) -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

 
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
      
      </div>
       <a href="javascript:history.back()" 
   style="padding:8px 18px; position:absolute;
   color:var(--accent);
   top:4px;right:0px;background-color:var(--glass-bg);  text-decoration:none; box-shadow:1px 1px 2px var(--sky-2) , -1px -1px 4px white;margin-right:auto;">
    Back
</a>
    </div>

    <!-- GRID: left + right columns -->
    <div class="row g-4">

      <!-- LEFT COLUMN -->
      <div class="col-lg-4 profile-left">

        <!-- Profile Card -->
        <div class="glass-card d-flex flex-column align-items-start">
          <div class="d-flex align-items-center gap-3 w-100">
            <img src="<?php echo htmlspecialchars($avatar, ENT_QUOTES); ?>" alt="avatar" class="avatar">
            <div>
              <div class="name"><?php echo htmlspecialchars($userName); ?></div>
              <div class="meta"><?php echo htmlspecialchars($userEmail); ?></div>
            </div>
          </div>

          <hr style="width:100%; border-top:1px solid rgba(15,23,42,0.05); margin:12px 0;">

          <div class="w-100">
            <h6 class="fw-bold mb-2">Contact Details</h6>
            <div class="muted-small mb-2"><i class="bi bi-telephone me-2"></i> <?php echo htmlspecialchars($userPhone); ?></div>
            <div class="muted-small mb-2"><i class="bi bi-envelope me-2"></i> <?php echo htmlspecialchars($userEmail); ?></div>
            <div class="muted-small"><i class="bi bi-house me-2"></i> <?php echo htmlspecialchars($userAddress); ?></div>
          </div>

          <div class="w-100 mt-3 d-flex gap-2">
            <a href="#" class="btn btn-outline-primary btn-sm">Edit Profile</a>
          </div>
        </div>
        <!-- END PROFILE CARD -->

        <!-- LATEST TESTS -->
        <div class="glass-card mt-4">
          <h6 class="fw-bold mb-3">Latest Tests</h6>

          <?php if (empty($latest_tests)): ?>
            <div class="muted-small">No recent tests</div>
          <?php else: ?>
            <?php foreach ($latest_tests as $test): ?>
              <div class="list-item">
                <div class="chip"></div>
                <div class="flex-grow-1">
                  <div class="fw-semibold"><?php echo htmlspecialchars($test['name']); ?></div>
                  <div class="muted-small"><?php echo htmlspecialchars($test['date']); ?></div>
                </div>
                <div class="text-end">
                  <a class="btn btn-sm btn-outline-primary" href="<?php echo htmlspecialchars($test['file']); ?>" target="_blank">View report</a>
                </div>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>

          <div class="mt-2 text-center">
            <a class="btn btn-sm btn-outline-secondary" href="#">View All</a>
          </div>
        </div>
        <!-- END LATEST TESTS -->

      </div>
      <!-- END LEFT COLUMN -->


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
              <div class="text-end muted-small">ID: <strong><?php echo htmlspecialchars($userId); ?></strong></div>
            </div>

            <div class="row mt-3">
              <div class="col-sm-6 mb-2">
                <div class="muted-small">Gender</div>
                <div class="fw-semibold"><?php echo htmlspecialchars($userGender); ?></div>
              </div>
              <div class="col-sm-6 mb-2">
                <div class="muted-small">Date of Birth</div>
                <div class="fw-semibold"><?php echo htmlspecialchars($userDob); ?></div>
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

          <div class="tile glass-card" style="min-width:220px; max-width:260px;">
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
                <?php if (!empty($appointments)): ?>
                  <?php foreach ($appointments as $appt): ?>
                    <tr>
                      <td><?php echo htmlspecialchars($appt['date'] ?? '—'); ?></td>
                      <td><?php echo htmlspecialchars($appt['department'] ?? '—'); ?></td>
                      <td><?php echo htmlspecialchars($appt['doctor'] ?? '—'); ?></td>
                      <td>
                        <?php
                          $status = $appt['status'] ?? 'Unknown';
                          $badgeClass = 'bg-secondary';
                          if (strtolower($status) === 'completed') $badgeClass = 'bg-success';
                          if (strtolower($status) === 'pending') $badgeClass = 'bg-warning text-dark';
                          if (strtolower($status) === 'report ready') $badgeClass = 'bg-info text-dark';
                        ?>
                        <span class="badge <?php echo $badgeClass; ?>"><?php echo htmlspecialchars($status); ?></span>
                      </td>
                      <td><?php echo htmlspecialchars($appt['notes'] ?? ''); ?></td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr><td colspan="5" class="text-center muted-small">No appointments found</td></tr>
                <?php endif; ?>
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
                <li class="d-flex justify-content-between mb-2"><div><i class="bi bi-droplet me-2 text-info"></i> Blood Tests</div><div class="fw-bold">45%</div></li>
                <li class="d-flex justify-content-between mb-2"><div><i class="bi bi-heart-pulse me-2 text-danger"></i> ECG</div><div class="fw-bold">25%</div></li>
                <li class="d-flex justify-content-between mb-2"><div><i class="bi bi-file-earmark-text me-2 text-warning"></i> Imaging</div><div class="fw-bold">20%</div></li>
                <li class="d-flex justify-content-between mb-2"><div><i class="bi bi-thermometer-sun me-2 text-success"></i> Others</div><div class="fw-bold">10%</div></li>
              </ul>

            </div>
          </div>
        </div>

      </div>
      <!-- END RIGHT COLUMN -->

    </div>
    <!-- END GRID -->

  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    // Chart: tests per month (dummy data) — replace with dynamic data when available
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
          plugins: { legend: { display: false } },
          scales: { x: { grid: { display:false } }, y: { beginAtZero:true, ticks: { stepSize: 5 } } },
          maintainAspectRatio: false
        }
      });
    }
  </script>

</body>
</html>
