<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <title>Document</title>
     <style>
        :root{
            --bg-1:#071029;
            --bg-2:#0b3b6a;
            --card:#ffffff;
            --muted:#64748b;
            --accent:#3b82f6;
            --accent-2:#8b5cf6;
            --danger:#ef4444;
            --radius:12px;
            --max-width:1100px;
        }
        *{box-sizing:border-box}
        html,body{height:100%}
        body{
            margin:0;
            font-family:Inter,system-ui,Segoe UI,Roboto,Arial,sans-serif;
            background:linear-gradient(135deg,var(--bg-1) 0%, rgba(8,60,120,0.85) 50%, var(--bg-2) 100%);
            color:#0b1320;
            padding:20px;
            display:flex;
            align-items:center;
            justify-content:center;
        }

        .layout{
            margin-top:40px;
            width:100%;
            height:100%;
            max-width:var(--max-width);
            display:grid;
            gap:20px;
            grid-template-columns: 1fr;
            align-items:stretch;
        }

        /* Hero (left) */
        .hero{
            margin-top:60px;
            color:#fff;
            background:linear-gradient(180deg, rgba(255,255,255,0.04), rgba(255,255,255,0.02));
            border-radius:var(--radius);
            padding:20px;
            display:flex;
            flex-direction:column;
            justify-content:space-between;
            box-shadow: 0 10px 30px rgba(2,6,23,0.6);
            min-height:320px;
        }
        .brand{display:flex;gap:14px;align-items:center}
        .logo{width:56px;height:56px;border-radius:10px;background:linear-gradient(135deg,var(--accent),var(--accent-2));display:flex;align-items:center;justify-content:center;flex-shrink:0}
        .brand h1{margin:0;font-size:18px}
        .brand p{margin:0;font-size:13px;color:rgba(255,255,255,0.9)}
        .info{margin-top:14px;font-size:14px;line-height:1.45;color:rgba(255,255,255,0.92)}
        .stats{display:flex;gap:8px;margin-top:16px;flex-wrap:wrap}
        .stat{background:rgba(255,255,255,0.04);padding:10px 12px;border-radius:10px;min-width:100px}
        .stat b{display:block}
        .hero-footer{margin-top:16px;font-size:13px;display:flex;gap:8px;align-items:center;flex-wrap:wrap}
        .chip{padding:6px 10px;border-radius:999px;background:#f6f9ff;font-size:13px;border:1px solid rgba(255,255,255,0.06);color:#fff}

        /* Card (form) */
        .card{
            background:var(--card);
            border-radius:var(--radius);
            padding:20px;
            box-shadow:0 10px 30px rgba(2,6,23,0.12);
        }

        h2{margin:0 0 8px 0;font-size:20px;color:#0b1320}
        p.lead{margin:0 0 14px 0;color:var(--muted);font-size:14px}

        form{display:grid;gap:12px}
        .row{display:flex;gap:12px;flex-wrap:wrap}
        .col{flex:1;min-width:140px;display:flex;flex-direction:column;gap:8px}
        label{font-size:12px;color:var(--muted)}
        input[type="text"],input[type="email"],input[type="tel"],select,textarea,input[type="date"],input[type="time"]{
            padding:12px 14px;border-radius:10px;border:1px solid #e6eef8;background:#fbfdff;font-size:14px;outline:none;transition:box-shadow .14s,border-color .14s;
        }
        input:focus,select:focus,textarea:focus{border-color:var(--accent);box-shadow:0 6px 18px rgba(59,130,246,0.12)}
        textarea{min-height:100px;resize:vertical}
        .helper{font-size:12px;color:var(--muted)}

        .actions{display:flex;gap:12px;align-items:center;margin-top:6px}
        .btn{
            padding:10px 14px;border-radius:10px;border:0;cursor:pointer;font-weight:600;
        }
        .primary{background:linear-gradient(90deg,var(--accent),var(--accent-2));color:#fff;box-shadow:0 8px 22px rgba(59,130,246,0.12)}
        .ghost{background:transparent;border:1px solid #dfe9f6;color:var(--muted)}

        /* Modal */
        .modal{position:fixed;inset:0;display:none;align-items:center;justify-content:center;background:rgba(6,10,22,0.6);padding:20px;z-index:60}
        .modal.show{display:flex}
        .modal .box{background:#fff;padding:20px;border-radius:12px;max-width:520px;width:100%;text-align:center}
        .close{background:transparent;border:0;color:var(--accent);font-weight:600;cursor:pointer}

        /* small view adjustments */
        @media (min-width:900px){
            .layout{
                grid-template-columns: 420px 1fr;
                gap:28px;
            }
            .hero{min-height:420px;padding:28px}
            .card{padding:26px}
        }

        /* very small devices */
        @media (max-width:420px){
            body{padding:12px}
            .brand h1{font-size:16px}
            .logo{width:48px;height:48px}
            .stat{min-width:88px;padding:8px}
        }

        /* error state helper (used by JS) */
        .invalid{border-color:var(--danger) !important}
    </style>
</head>
<body>
        
         <!-- form -->
<!-- <form class="row g-3">
  <div class="col-md-6">
    <label for="inputEmail4" class="form-label">Email</label>
    <input type="email" class="form-control" id="inputEmail4">
  </div>
  <div class="col-md-6">
    <label for="inputPassword4" class="form-label">Password</label>
    <input type="password" class="form-control" id="inputPassword4">
  </div>
  <div class="col-12">
    <label for="inputAddress" class="form-label">Address</label>
    <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St">
  </div>
  <div class="col-12">
    <label for="inputAddress2" class="form-label">Address 2</label>
    <input type="text" class="form-control" id="inputAddress2" placeholder="Apartment, studio, or floor">
  </div>
  <div class="col-md-6">
    <label for="inputCity" class="form-label">City</label>
    <input type="text" class="form-control" id="inputCity">
  </div>
  <div class="col-md-4">
    <label for="inputState" class="form-label">State</label>
    <select id="inputState" class="form-select">
      <option selected>Choose...</option>
      <option>...</option>
    </select>
  </div>
  <div class="col-md-2">
    <label for="inputZip" class="form-label">Zip</label>
    <input type="text" class="form-control" id="inputZip">
  </div>
  <div class="col-12">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" id="gridCheck">
      <label class="form-check-label" for="gridCheck">
        Check me out
      </label>
    </div>
  </div>
  <div class="col-12">
    <button type="submit" class="btn btn-primary">Sign in</button>
  </div>
</form> --><button style="position:absolute; padding:12px;border:none; border-radius:4px; cursor:pointer; text-decoration:none; color:black;
            right:16px;top:16px;"class="btn-primary"><a href="../home.php">Back</a></button>
          <!-- form -->
           <main class="card" aria-live="polite">
            <h2>Book an Appointment</h2>
            <p class="lead">Fill the form below and we’ll reach out to confirm your visit.</p>

            <form id="appointmentForm" novalidate>
                <div class="row">
                    <div class="col">
                        <label for="firstName">First name</label>
                        <input id="firstName" name="firstName" type="text" placeholder="Jane" required aria-required="true">
                    </div>
                    <div class="col">
                        <label for="lastName">Last name</label>
                        <input id="lastName" name="lastName" type="text" placeholder="Doe" required aria-required="true">
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <label for="email">Email</label>
                        <input id="email" name="email" type="email" placeholder="you@example.com" required>
                    </div>
                    <div class="col">
                        <label for="phone">Phone</label>
                        <input id="phone" name="phone" type="tel" placeholder="+1 (555) 000-0000" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <label for="specialty">Specialty</label>
                        <select id="specialty" name="specialty" required>
                            <option value="">Choose specialty</option>
                            <option>General Medicine</option>
                            <option>Cardiology</option>
                            <option>Dermatology</option>
                            <option>Pediatrics</option>
                            <option>Orthopedics</option>
                            <option>Neurology</option>
                        </select>
                    </div>
                    <div class="col">
                        <label for="doctor">Preferred doctor (optional)</label>
                        <select id="doctor" name="doctor">
                            <option value="">No preference</option>
                            <option>Dr. Alan Smith</option>
                            <option>Dr. Maria Lopez</option>
                            <option>Dr. Chen Wei</option>
                            <option>Dr. Priya Nair</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <label for="date">Preferred date</label>
                        <input id="date" name="date" type="date" required>
                    </div>
                    <div class="col">
                        <label for="time">Preferred time</label>
                        <input id="time" name="time" type="time" required>
                        <div class="helper">Clinic hours: 08:00 — 18:00</div>
                    </div>
                </div>

                <div>
                    <label for="reason">Reason for visit</label>
                    <textarea id="reason" name="reason" placeholder="Brief description (symptoms, concerns, etc.)"></textarea>
                </div>

                <div class="row" style="align-items:center;margin-top:6px">
                    <div class="col" style="flex:0 0 220px;min-width:160px">
                        <label for="insurance">Insurance</label>
                        <select id="insurance" name="insurance">
                            <option value="">Self-pay</option>
                            <option>HealthPlus</option>
                            <option>Medicover</option>
                            <option>CareAssist</option>
                        </select>
                    </div>

                    <div style="flex:1;display:flex;align-items:center;justify-content:flex-end">
                        <div style="display:flex;gap:8px">
                            <button type="button" class="btn ghost" id="clearBtn">Clear</button>
                            <button type="submit" class="btn primary">Request Appointment</button>
                        </div>
                    </div>
                </div>

                <div class="note" style="font-size:13px;color:var(--muted);margin-top:8px">By submitting, you agree to our privacy policy and terms. We will contact you to confirm your appointment.</div>
            </form>
        </main>
        

 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>