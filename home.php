<?php
session_start();

$_SESSION['user'] = [
    'id'=>'u1',
    'name' => 'sahil kumar',
    'email' => 'sahil@example.com',
    'phone' => '9876543210',
    'address' => '123 Street, delhi',
    'gender' => 'Male',
    'dob' => '1995-06-12',
    'latest_tests' => [
        ['name' => 'Blood Test', 'date' => '2024-11-10', 'file' => 'blood_report.pdf'],
        ['name' => 'X-Ray', 'date' => '2024-11-01', 'file' => 'xray.pdf']
    ],
  
    'appointments' => [
        ['doctor' => 'Dr. Smith', 'date' => '2024-12-01', 'status' => 'Completed'],
        ['doctor' => 'Dr. Amy', 'date' => '2024-12-15', 'status' => 'Upcoming']
    ]
];
?>

<!--  -->


<?php
// /c:/xampp/htdocs/hospital/pages/home.php
?><!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Hospital — Quality Healthcare at Your Fingertips</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        :root{
            --bg: #f7fafc;
            --card: #ffffff;
            --muted: #6b7280;
            --primary: #0b6efd; /* calm blue */
            --accent: #10b981;  /* green */
            --soft-blue: #e6f4ff;
            --radius: 18px;
            --shadow: 0 6px 20px rgba(15,23,42,0.08);
            --glass: rgba(255,255,255,0.6);
            font-family: "Inter", system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
            color-scheme: light;
        }

        html,body{height:100%; margin:0; background:var(--bg); color:#0f172a; -webkit-font-smoothing:antialiased; -moz-osx-font-smoothing:grayscale;}

        /* NAV */
        .nav{
            position:sticky;
            top:0;
            z-index:50;
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:20px;
            padding:14px 28px;
            background:linear-gradient(180deg, rgba(255,255,255,0.75), rgba(255,255,255,0.6));
            backdrop-filter: blur(6px);
            transition:box-shadow .2s, padding .2s;
        }
        .nav.scrolled{ box-shadow: var(--shadow); padding:10px 28px; }

        .logo{ display:flex; align-items:center; gap:12px; font-weight:700; color:var(--primary); text-decoration:none; }
        .logo .mark{
            width:40px;height:40px;border-radius:10px;background:linear-gradient(135deg,var(--primary),#1b82ff);
            display:inline-grid;place-items:center;color:#fff;font-weight:700;box-shadow:0 6px 18px rgba(11,110,253,0.18);
        }

        .menu{ display:flex; gap:18px; align-items:center; margin-left:12px; }
        .menu a{ color:var(--muted); text-decoration:none; font-weight:600; font-size:15px; padding:8px 6px; border-radius:8px; }
        .menu a:hover{ color:var(--primary); background:rgba(11,110,253,0.06); }

        .actions{ display:flex; gap:12px; align-items:center; }
        .btn{
            display:inline-flex; align-items:center; gap:8px; padding:10px 16px; border-radius:12px; font-weight:600; cursor:pointer;
            border:0; text-decoration:none;
        }
        .btn-outline{ background:transparent; color:var(--primary); border:1px solid rgba(11,110,253,0.12); }
        .btn-primary{ background:var(--primary); color:#fff; box-shadow: 0 8px 24px rgba(11,110,253,0.12); }

        /* HERO */
        .hero{
            padding:64px 28px 36px;
            display:grid;
            grid-template-columns: 1fr 440px;
            gap:36px;
            align-items:center;
            max-width:1200px;
            margin:24px auto;
        }
        .hero-card{
            background:linear-gradient(180deg, rgba(255,255,255,0.9), rgba(255,255,255,0.85));
            border-radius:20px;
            padding:42px;
            box-shadow: var(--shadow);
        }
        .hero h1{ margin:0 0 14px; font-size:36px; line-height:1.05; letter-spacing:-0.4px;}
        .hero p{ color:var(--muted); margin:0 0 22px; font-size:16px;}
        .hero .ctas{ display:flex; gap:12px; margin-top:10px; }
        .hero-visual{
            border-radius:20px; padding:34px; display:flex; align-items:center; justify-content:center;
            background:linear-gradient(135deg,var(--soft-blue), #f3fbff); box-shadow: var(--shadow);
        }
        .hero-visual .badge{
            width:380px; height:240px; border-radius:14px; background:linear-gradient(180deg,#fff, #f7fbff); display:flex; flex-direction:column; gap:14px; padding:18px;
            box-shadow: 0 8px 30px rgba(6,78,115,0.06);
        }
        .small-meta{ display:flex; gap:12px; align-items:center; color:var(--muted); font-size:13px; }

        /* SERVICES */
        .section{ max-width:1200px; margin:28px auto; padding:0 28px 36px; }
        .grid{
            display:grid; gap:20px;
        }
        .services{ grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); }
        .card{
            background:var(--card); border-radius:var(--radius); padding:20px; box-shadow:var(--shadow); transition:transform .22s ease, box-shadow .22s ease;
            display:flex; gap:14px; align-items:flex-start;
        }
        .card:hover{ transform:translateY(-8px); box-shadow:0 12px 28px rgba(15,23,42,0.12); }
        .icon{
            width:56px; height:56px; border-radius:12px; display:grid; place-items:center; flex-shrink:0;
            background:linear-gradient(180deg, rgba(16,185,129,0.12), rgba(11,110,253,0.06));
        }
        .card h4{ margin:0 0 6px; font-size:16px; }
        .card p{ margin:0; color:var(--muted); font-size:14px; }

        /* APPOINTMENT */
        .appoint{
            margin-top:18px;
            background: linear-gradient(90deg, rgba(14,165,233,0.06), rgba(16,185,129,0.04));
            border-radius:16px; padding:20px; display:flex; align-items:center; justify-content:space-between;
            gap:18px; box-shadow: inset 0 1px 0 rgba(255,255,255,0.6);
        }
        .appoint .left{ display:flex; gap:14px; align-items:center; }
        .pill{ background:#fff; padding:10px 12px; border-radius:12px; box-shadow:0 6px 20px rgba(16,185,129,0.06); font-weight:700; color:var(--accent); }
        .appoint p{ margin:0; color:var(--muted); }
        .appoint .cta{ min-width:160px; }

        /* ABOUT & CONTACT */
        .split{ display:grid; grid-template-columns: 1fr 1fr; gap:20px; align-items:start; }
        .contact .row{ display:flex; gap:12px; align-items:center; margin-bottom:12px; color:var(--muted); }
        .contact .icon-round{ width:46px;height:46px;border-radius:10px;display:grid;place-items:center;background:#fff; box-shadow:var(--shadow); }

        /* FOOTER */
        footer{ margin-top:36px; padding:22px 28px; background:#f1f5f9; border-top:1px solid rgba(15,23,42,0.03); color:var(--muted); border-radius:12px; max-width:1200px; margin-left:auto; margin-right:auto; }

        /* Animations */
        .fade-up{ opacity:0; transform:translateY(12px); transition:all .6s cubic-bezier(.2,.9,.2,1); will-change:transform,opacity; }
        .is-visible{ opacity:1; transform:none; }
        .btn:hover{ transform:translateY(-1px); }

        /* Responsive */
        @media (max-width:980px){
            .hero{ grid-template-columns:1fr; padding:32px 18px; }
            .hero-visual{ order:-1; }
            .split{ grid-template-columns:1fr; }
            .menu{ display:none; }
        }

    </style>
</head>
<body>

    <header class="nav" id="nav">
        

       <section>
   <div class="head" style="position:absolute;top:0;left:0;
   height:60px;
   background-color:white;color:red;width:100%">
   <?php include './components/navbar.php'; ?>
   
</div>
     </section>

    </header>


    <!-- HERO -->
    <main>
        <section  class="hero">
            <div style="width:90%;" class="hero-card fade-up">
                <h1>Quality Healthcare at Your Fingertips</h1>
                <p>We provide trusted medical services, online appointments, and patient-centered care. Fast, secure, and compassionate — all in one place.</p>

                <div style="display:flex;gap:12px;flex-wrap:wrap;">
                    <a href="./components/bookingform.php" class="btn btn-primary">Book an Appointment</a>
                    <a href="./pages/services.php" class="btn btn-outline">Explore Services</a>
                </div>

                <div style="margin-top:20px;">
                    <div class="small-meta">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" style="flex-shrink:0;">
                            <path d="M12 8v4l3 3" stroke="#0b6efd" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                            <circle cx="12" cy="12" r="9" stroke="#c7defd" stroke-width="1.6"/>
                        </svg>
                        <div>Open hours: Mon–Sat • 8:00 — 18:00</div>
                    </div>
                </div>

                <div style="margin-top:20px; display:grid; grid-template-columns:repeat(3,1fr); gap:8px;">
                    <div style="background:#fff;border-radius:10px;padding:10px;box-shadow:var(--shadow);font-size:13px;">
                        <strong style="display:block;">24/7 Care</strong><span style="color:var(--muted);">Emergency & telehealth</span>
                    </div>
                    <div style="background:#fff;border-radius:10px;padding:10px;box-shadow:var(--shadow);font-size:13px;">
                        <strong style="display:block;">Experienced Staff</strong><span style="color:var(--muted);">Certified professionals</span>
                    </div>
                    <div style="background:#fff;border-radius:10px;padding:10px;box-shadow:var(--shadow);font-size:13px;">
                        <strong style="display:block;">Secure Records</strong><span style="color:var(--muted);">HIPAA-compliant</span>
                    </div>
                </div>
            </div>

           
        </section>

        <!-- SERVICES -->
        <section id="services" class="section">
            <h2 style="margin:0 0 14px;">Our Services</h2>
            <p style="margin:0 0 18px;color:var(--muted);max-width:760px;">Easy-to-scan service cards let patients find what they need quickly. Click any service to learn more or schedule an appointment.</p>

            <div class="grid services">
                <div class="card fade-up">
                    <div class="icon" style="background:linear-gradient(180deg, rgba(11,110,253,0.12), rgba(11,110,253,0.04));">
                        <!-- stethoscope -->
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M9 2v6a6 6 0 0 0 6 6v4a3 3 0 1 1-6 0" stroke="#0b6efd" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <div>
                        <h4>Primary Care</h4>
                        <p>Comprehensive routine exams, chronic disease management, and preventive services.</p>
                    </div>
                </div>

                <div class="card fade-up">
                    <div class="icon" style="background:linear-gradient(180deg, rgba(16,185,129,0.12), rgba(16,185,129,0.04));">
                        <!-- heart -->
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M20.8 8.6a4.3 4.3 0 0 0-6.1 0L12 11.3l-2.7-2.7a4.3 4.3 0 0 0-6.1 6.1L12 22l8.8-7.3a4.3 4.3 0 0 0 0-6.1z" stroke="#10b981" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" fill="rgba(16,185,129,0.06)"/></svg>
                    </div>
                    <div>
                        <h4>Cardiology</h4>
                        <p>State-of-the-art diagnostics and care plans tailored for heart health.</p>
                    </div>
                </div>

                <div class="card fade-up">
                    <div class="icon" style="background:linear-gradient(180deg, rgba(99,102,241,0.12), rgba(99,102,241,0.04));">
                        <!-- pills -->
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M20.5 7.5l-4-4a4 4 0 0 0-5.6 0L6.9 7.5" stroke="#6b63ff" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <div>
                        <h4>Pharmacy</h4>
                        <p>On-site pharmacy with fast pickup and secure prescription management.</p>
                    </div>
                </div>

                <div class="card fade-up">
                    <div class="icon" style="background:linear-gradient(180deg, rgba(250,204,21,0.08), rgba(250,204,21,0.02));">
                        <!-- telehealth -->
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M21 15a2 2 0 0 0-2-2h-6l-4 4v4h-1a3 3 0 0 1-3-3v-2" stroke="#f5c151" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <div>
                        <h4>Telehealth</h4>
                        <p>Virtual visits for consultations, follow-ups, and remote monitoring.</p>
                    </div>
                </div>
            </div>

            <!-- Appointment highlight -->
            <div class="appoint fade-up" style="margin-top:18px;" id="book">
                <div class="left">
                    <div class="pill">Need an appointment?</div>
                    <div>
                        <div style="font-weight:700">Book online in minutes</div>
                        <div style="color:var(--muted);font-size:13px">Choose a time, pick a provider, and get confirmations instantly.</div>
                    </div>
                </div>
                <div class="cta">
                    <a href="./components/minibook.php" 
                    
                    class="btn btn-primary">Schedule Now</a>
                </div>
            </div>

        </section>

        <!-- ABOUT + CONTACT -->
        <section class="section" id="about">
            <div class="split">
                <div class="fade-up">
                    <h3>About Us</h3>
                    <p style="color:var(--muted);">We are a multidisciplinary healthcare provider focused on delivering personalized, efficient, and compassionate care. Our mission is to improve patient outcomes through modern technology and evidence-based practice.</p>

                    <ul style="margin-top:12px;color:var(--muted);line-height:1.7;">
                        <li>Patient-first approach</li>
                        <li>Fast, secure online bookings</li>
                        <li>Experienced clinical staff</li>
                    </ul>
                </div>

                <div class="contact fade-up" id="contact">
                    <h3>Contact</h3>
                    <div class="row">
                        <div class="icon-round">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M21 10.3v4.4a2 2 0 0 1-2 2h-2" stroke="#0b6efd" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </div>
                        <div>
                            <div style="font-weight:700">Phone</div>
                            <div style="color:var(--muted);font-size:13px">+1 (555) 234-5678</div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="icon-round">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M3 8.5v7a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" stroke="#10b981" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </div>
                        <div>
                            <div style="font-weight:700">Email</div>
                            <div style="color:var(--muted);font-size:13px">hello@hospital.example</div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="icon-round">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M12 21s8-4.5 8-11a8 8 0 1 0-16 0c0 6.5 8 11 8 11z" stroke="#6b7280" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </div>
                        <div>
                            <div style="font-weight:700">Address</div>
                            <div style="color:var(--muted);font-size:13px">120 Health Ave, Suite 400, Cityville</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <footer>
            <div style="display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap;">
                <div style="font-size:14px;">© <?php echo date('Y'); ?> HospitalSys. All rights reserved.</div>
                <div style="display:flex;gap:12px;">
                    <a href="#" style="color:var(--muted);text-decoration:none;font-size:13px;">Privacy</a>
                    <a href="#" style="color:var(--muted);text-decoration:none;font-size:13px;">Terms</a>
                    <a href="#" style="color:var(--muted);text-decoration:none;font-size:13px;">Careers</a>
                </div>
            </div>
        </footer>
    </main>

    <script>
        // Sticky-ish nav shadow toggle
        (function(){
            const nav = document.getElementById('nav');
            const obsTargets = document.querySelectorAll('.fade-up');

            const onScroll = () => {
                if(window.scrollY > 8) nav.classList.add('scrolled');
                else nav.classList.remove('scrolled');
            };
            window.addEventListener('scroll', onScroll, {passive:true});
            onScroll();

            // IntersectionObserver for fade-in
            const io = new IntersectionObserver((entries)=>{
                entries.forEach(e=>{
                    if(e.isIntersecting) { e.target.classList.add('is-visible'); io.unobserve(e.target); }
                });
            }, {root:null,threshold:0.12});

            obsTargets.forEach(t=>io.observe(t));
        })();
    </script>
</body>
</html>