<?php
// /c:/xampp/htdocs/hospital/pages/about.php
?><!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>About Us - Hospital Management System</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root{
            --brand:#0d6efd;
            --muted:#6c757d;
            --card-bg:#f8f9fa;
        }
        body{background:#fff;color:#212529;font-family:Inter, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;}
        .hero{
            background: linear-gradient(180deg, rgba(13,110,253,0.08), rgba(13,110,253,0.02));
            padding:4.5rem 0;
        }
        .feature-icon{
            width:48px;height:48px;border-radius:12px;
            display:inline-flex;align-items:center;justify-content:center;background:var(--card-bg);
            color:var(--brand);font-weight:700;margin-right:0.75rem;
            flex-shrink:0;
        }
        .card-quiet{background:transparent;border:0}
        @media (max-width:576px){
            .hero{padding:3rem 1rem}
        }
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
    <main>
        <header class="hero">
            <div style="margin-top:2.45rem;" class="container">
                <div class="row align-items-center">
                    <div class="col-lg-7">
                        <h1 class="display-6 mb-3">About Us – Hospital Management System</h1>
                        <p class="lead text-muted mb-4">
                            Welcome to our Hospital Management System, a comprehensive digital solution designed to simplify, enhance, and modernize healthcare operations. Our platform connects patients, doctors, nurses, administrators, and support staff through a secure and intelligent system that ensures seamless hospital workflow and improved quality of care.
                        </p>
                        <a href="#contact" class="btn btn-primary me-2">Contact Sales</a>
                        <a href="#features" class="btn btn-outline-primary">See Features</a>
                    </div>
                    <div class="col-lg-5 d-none d-lg-block">
                        <div class="card shadow-sm card-quiet p-4">
                            <h6 class="text-uppercase text-muted mb-3">Quick Facts</h6>
                            <div class="row g-2">
                                <div class="col-6">
                                    <div class="p-3 bg-white rounded">
                                        <div class="h1 mb-1">120+</div>
                                        <div class="text-muted small">Integrated Modules</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-3 bg-white rounded">
                                        <div class="h1 mb-1">24/7</div>
                                        <div class="text-muted small">System Availability</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-3 bg-white rounded">
                                        <div class="h1 mb-1">Secure</div>
                                        <div class="text-muted small">Data Encryption</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-3 bg-white rounded">
                                        <div class="h1 mb-1">Custom</div>
                                        <div class="text-muted small">Scalable Features</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- /.row -->
            </div><!-- /.container -->
        </header>

        <section id="who" class="py-5">
            <div class="container">
                <div class="row g-4 align-items-center">
                    <div class="col-md-6">
                        <h2 class="h4">Who We Are</h2>
                        <p class="text-muted">
                            We are a team of healthcare and technology professionals committed to transforming the way hospitals manage their daily operations. Our mission is to provide hospitals with a reliable, user-friendly, and efficient system that supports every stage of medical care—from patient registration to discharge.
                        </p>
                        <p class="mb-0">
                            Our expertise spans clinical workflows, secure software architecture, and user experience design to deliver tools that staff actually use and trust.
                        </p>
                    </div>
                    <div class="col-md-6">
                        <div class="ratio ratio-16x9 rounded overflow-hidden shadow-sm">
                            <img alt="Team working" src="https://images.unsplash.com/photo-1586773860414-1b2e4f3a37b3?q=80&w=1200&auto=format&fit=crop&ixlib=rb-4.0.3&s=000" style="width:100%;height:100%;object-fit:cover;">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="features" class="py-5 bg-white">
            <div class="container">
                <h3 class="h5 mb-4">What We Do</h3>
                <p class="text-muted mb-4">Our Hospital Management System automates essential hospital functions, including:</p>

                <div class="row gy-3">
                    <?php
                    $features = [
                        ['icon'=>'PR','title'=>'Patient registration & appointment scheduling','desc'=>'Fast registration, appointment calendars, reminders.'],
                        ['icon'=>'EM','title'=>'Electronic medical records (EMR)','desc'=>'Structured patient records with secure access controls.'],
                        ['icon'=>'DR','title'=>'Doctor & staff management','desc'=>'Schedules, roles, and access management for medical staff.'],
                        ['icon'=>'PH','title'=>'Pharmacy & laboratory management','desc'=>'Inventory, orders, and lab result integration.'],
                        ['icon'=>'BL','title'=>'Billing & payment processing','desc'=>'Accurate invoicing and multiple payment channels.'],
                        ['icon'=>'WB','title'=>'Ward & bed allocation','desc'=>'Real-time bed availability and assignments.'],
                        ['icon'=>'IN','title'=>'Inventory & equipment tracking','desc'=>'Asset tracking, stock alerts, procurement workflows.'],
                        ['icon'=>'RA','title'=>'Real-time reporting & analytics','desc'=>'Operational dashboards and exportable reports.'],
                    ];
                    foreach($features as $f):
                    ?>
                        <div class="col-sm-6 col-lg-3">
                            <div class="d-flex align-items-start">
                                <div class="feature-icon"><?php echo htmlspecialchars($f['icon'], ENT_QUOTES); ?></div>
                                <div>
                                    <h6 class="mb-1"><?php echo htmlspecialchars($f['title'], ENT_QUOTES); ?></h6>
                                    <p class="text-muted small mb-0"><?php echo htmlspecialchars($f['desc'], ENT_QUOTES); ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="mt-4">
                    <p class="text-muted">By integrating all these services into one platform, we help hospitals reduce administrative workload, minimize errors, and deliver faster and better patient service.</p>
                </div>
            </div>
        </section>

        <section id="vision-mission" class="py-5">
            <div class="container">
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">Our Vision</h5>
                                <p class="card-text text-muted">To empower healthcare facilities with advanced, secure, and scalable digital tools that support exceptional patient care and streamlined hospital operations.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">Our Mission</h5>
                                <p class="card-text text-muted">To enhance the efficiency, transparency, and productivity of healthcare systems through innovative and easy-to-use management software.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="why" class="py-5 bg-light">
            <div class="container">
                <h4 class="mb-3">Why Choose Us?</h4>
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="p-3 bg-white rounded shadow-sm">
                            <h6>Secure and reliable</h6>
                            <p class="text-muted small mb-0">Enterprise-grade security and daily backups to protect patient data.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 bg-white rounded shadow-sm">
                            <h6>Fast and accurate</h6>
                            <p class="text-muted small mb-0">Optimized workflows reduce manual errors and accelerate processes.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 bg-white rounded shadow-sm">
                            <h6>Accessible 24/7</h6>
                            <p class="text-muted small mb-0">Cloud or on-premises deployment options with round-the-clock availability.</p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="p-3 bg-white rounded shadow-sm">
                            <h6>Customizable</h6>
                            <p class="text-muted small mb-0">Features scale to hospitals of all sizes and specialties.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 bg-white rounded shadow-sm">
                            <h6>User-friendly</h6>
                            <p class="text-muted small mb-0">Designed for staff of all technical levels with clear workflows.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 bg-white rounded shadow-sm">
                            <h6>Continuous support</h6>
                            <p class="text-muted small mb-0">Ongoing updates, training resources, and dedicated support.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="contact" class="py-5">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h5>Interested in a demo or deployment?</h5>
                        <p class="text-muted mb-0">Reach out to our team to discuss needs, pricing, or a trial environment.</p>
                    </div>
                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                        <a href="mailto:sales@example.com" class="btn btn-primary">Contact Sales</a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="py-4 bg-white border-top">
        <div class="container text-center small text-muted">
            &copy; <?php echo date('Y'); ?> Hospital Management System. All rights reserved.
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>