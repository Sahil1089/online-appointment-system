<?php
// appointment.php - Responsive appointment booking frontend
// No server-side processing in this page (frontend only). Add server handlers as needed.
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Book an Appointment — CityCare Hospital</title>
   
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
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
    <section>
   <div class="head" style="position:absolute;top:0;left:0;
   height:60px;
   background-color:white;color:red;width:100%">
   <?php include '../components/navbar.php'; ?>
   
</div>
     </section>
    <div class="layout" role="main" aria-label="Appointment booking">
        <aside class="hero" aria-labelledby="heroTitle">
            <div>
                <div class="brand">
                    <div class="logo" aria-hidden="true">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="3" y="6" width="18" height="12" rx="2" fill="white" opacity="0.14"/>
                            <path d="M12 8v6" stroke="white" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M9 11h6" stroke="white" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div>
                        <h1 id="heroTitle">CityCare Hospital</h1>
                        <p>Compassionate care, advanced medicine</p>
                    </div>
                </div>

                <p class="info">
                    <br>Schedule your appointment with ease. Choose a specialist, pick a convenient date and time, and provide a few details — our team will confirm shortly.</p>

                <div class="stats" aria-hidden="true">
                    <div class="stat"><b>120+</b><span>Doctors</span></div>
                    <div class="stat"><b>8.9</b><span>Patient rating</span></div>
                    <div class="stat"><b>24/7</b><span>Emergency</span></div>
                </div>
            </div>

            <div class="hero-footer">
                <span style="color:black;"   class="chip">Fast confirmation</span>
                <span  style="color:black;" class="chip">Free cancellation</span>
                <div style="margin-left:auto;font-size:13px;color:rgba(247, 247, 247, 0.92)">Need help? Call +1 (555) 123-4567</div>
            </div>
        </aside>

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
    </div>

    <div class="modal" id="successModal" role="dialog" aria-modal="true" aria-hidden="true">
        <div class="box" role="document">
            <svg width="56" height="56" viewBox="0 0 24 24" fill="none" style="margin-bottom:12px">
                <circle cx="12" cy="12" r="11" fill="#ECFDF5"/>
                <path d="M7 12.5l2.6 2.6L17 8.7" stroke="#059669" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <h3>Appointment requested</h3>
            <p style="color:var(--muted);margin-bottom:16px">We've received your request. Our team will contact you to confirm the appointment.</p>
            <button class="close" id="modalClose">Close</button>
        </div>
    </div>

    <script>
        (function(){
            const form = document.getElementById('appointmentForm');
            const modal = document.getElementById('successModal');
            const closeBtn = document.getElementById('modalClose');
            const clearBtn = document.getElementById('clearBtn');
            const timeInput = document.getElementById('time');
            const dateInput = document.getElementById('date');

            // set min date to today
            (function setMinDate(){
                if(!dateInput) return;
                const today = new Date();
                const yyyy = today.getFullYear();
                const mm = String(today.getMonth()+1).padStart(2,'0');
                const dd = String(today.getDate()).padStart(2,'0');
                dateInput.min = `${yyyy}-${mm}-${dd}`;
            })();

            function markInvalid(el){
                el.classList.add('invalid');
                el.setAttribute('aria-invalid','true');
            }
            function clearInvalid(el){
                el.classList.remove('invalid');
                el.removeAttribute('aria-invalid');
            }

            form.addEventListener('submit', function(e){
                e.preventDefault();
                const required = Array.from(form.querySelectorAll('[required]'));
                let ok = true;
                required.forEach(fn => {
                    clearInvalid(fn);
                    if(!fn.value || !String(fn.value).trim()){
                        markInvalid(fn);
                        ok = false;
                    }
                });

                // additional time business rule: clinic hours 08:00-18:00
                const timeEl = timeInput;
                if(timeEl && timeEl.value){
                    const parts = timeEl.value.split(':').map(Number);
                    if(parts.length === 2){
                        const [h,m] = parts;
                        if(h < 8 || h > 18 || (h === 18 && m > 0)){
                            markInvalid(timeEl);
                            ok = false;
                        }
                    }
                }

                if(!ok){
                    const firstInvalid = form.querySelector('.invalid');
                    if(firstInvalid) firstInvalid.focus();
                    return;
                }

                // simulated submit (replace with fetch to server in production)
                modal.classList.add('show');
                modal.setAttribute('aria-hidden','false');
                // move focus to modal close for accessibility
                if(closeBtn) closeBtn.focus();

                // clear form after a short delay to avoid disrupting focus immediately
                setTimeout(()=> form.reset(), 300);
            });

            if(closeBtn){
                closeBtn.addEventListener('click', function(){
                    modal.classList.remove('show');
                    modal.setAttribute('aria-hidden','true');
                    // return focus to first input
                    const firstInput = form.querySelector('input, select, textarea, button');
                    if(firstInput) firstInput.focus();
                });
            }

            if(clearBtn){
                clearBtn.addEventListener('click', function(){
                    if(confirm('Clear all fields?')) form.reset();
                });
            }

            // quick time suggestion
            if(timeInput){
                timeInput.addEventListener('focus', ()=> {
                    if(!timeInput.value) timeInput.value = '10:00';
                });
            }

            // close modal on ESC
            document.addEventListener('keydown', function(e){
                if(e.key === 'Escape' && modal.classList.contains('show')){
                    modal.classList.remove('show');
                    modal.setAttribute('aria-hidden','true');
                }
            });

            // remove invalid styling when user edits a field
            form.addEventListener('input', function(e){
                const target = e.target;
                if(target && target.classList && target.classList.contains('invalid')){
                    clearInvalid(target);
                }
            });
        })();
    </script>
</body>
</html>