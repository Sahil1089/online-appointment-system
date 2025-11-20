<?php
// /c:/xampp/htdocs/hospital/pages/services.php
// Simple frontend for Services page with booking UI.
// Note: This file is a static frontend. Integrate with your backend endpoints as needed.
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Our Services — Hospital</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root{
            --brand:#0d6efd;
            --muted:#6c757d;
        }
        body{background:#f8f9fa; color:#212529; font-family:Inter,system-ui,-apple-system,Segoe UI,Roboto,"Helvetica Neue",Arial;}
        .hero{background:linear-gradient(120deg, rgba(13,110,253,0.06), rgba(13,110,253,0.02)); padding:48px 0;}
        .service-card {border:1px solid rgba(0,0,0,0.06); background:#fff;}
        .feature-list li {margin-bottom:8px;}
        .badge-feature {background:rgba(13,110,253,0.08); color:var(--brand); font-weight:600;}
        .footer {padding:28px 0; color:var(--muted);}
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
    <main class="container py-4">
        <!-- Header / Hero -->
        <header class="hero rounded-3 mb-4">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-7">
                        <h1 class="display-6">Our Services</h1>
                        <p class="lead text-muted mb-3">
                            We provide accessible, reliable, and professional healthcare services—right at your doorstep or through our partnered clinics and hospitals. Your health, comfort, and convenience are our top priorities.
                        </p>
                        <p class="mb-0"><strong class="me-2">24/7 online appointment booking</strong> — Book anytime from your device.</p>
                    </div>
                    <div class="col-lg-5 text-lg-end mt-3 mt-lg-0">
                        <button id="quickBookBtn" class="btn btn-primary btn-lg" type="button" data-bs-toggle="modal" data-bs-target="#bookingModal">
                            <i class="bi bi-calendar-check me-1"></i> Book Appointment
                        </button>
                    </div>
                </div>
            </div>
        </header>

        <div class="row g-3">
            <!-- Services list -->
            <section class="col-lg-7">
                <div class="row g-3">
                    <div class="col-12">
                        <div class="card service-card p-3">
                            <div class="d-flex align-items-start">
                                <div class="me-3">
                                    <span class="fs-2 badge-feature rounded-pill px-3 py-2"><i class="bi bi-house-heart"></i> Home Care</span>
                                </div>
                                <div class="flex-fill">
                                    <h5 class="mb-1">Home-Based Healthcare Services</h5>
                                    <p class="text-muted mb-2">Certified nurses and medical staff deliver injections, sample collection, and more — safely and conveniently at your home.</p>

                                    <div class="row g-2">
                                        <div class="col-md-6">
                                            <div class="p-2 border rounded">
                                                <h6 class="mb-1"><i class="bi bi-droplet-half me-2 text-primary"></i> Home Injection Service</h6>
                                                <p class="mb-0 small text-muted">Safe, hygienic injections: antibiotics, insulin, vitamins, and routine medication.</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="p-2 border rounded">
                                                <h6 class="mb-1"><i class="bi bi-clipboard-data me-2 text-primary"></i> Home Blood Sample Collection</h6>
                                                <p class="mb-0 small text-muted">Accredited lab processing, digital delivery of reports — no queues.</p>
                                            </div>
                                        </div>
                                        <div class="col-12 mt-2">
                                            <div class="p-2 border rounded">
                                                <h6 class="mb-1"><i class="bi bi-droplet me-2 text-primary"></i> Home Urine Test Collection</h6>
                                                <p class="mb-0 small text-muted">Convenient collection and secure transport to partner labs.</p>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="card service-card p-3">
                            <h5 class="mb-2">Clinic & Hospital Appointment Booking</h5>
                            <p class="text-muted mb-3">Find and book appointments at top clinics and hospitals. Choose a doctor, specialty, or facility and schedule your visit.</p>

                            <ul class="list-unstyled feature-list mb-0">
                                <li><i class="bi bi-check-circle-fill text-success me-2"></i> Trusted and certified healthcare professionals</li>
                                <li><i class="bi bi-check-circle-fill text-success me-2"></i> Fast and convenient home services</li>
                                <li><i class="bi bi-check-circle-fill text-success me-2"></i> Affordable and transparent pricing</li>
                                <li><i class="bi bi-check-circle-fill text-success me-2"></i> Partnered with reliable clinics and diagnostic labs</li>
                                <li><i class="bi bi-check-circle-fill text-success me-2"></i> Quick delivery of medical reports</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Booking card -->
            <aside class="col-lg-5">
                <div class="card p-3 service-card sticky-top" style="top:24px;">
                    <h5 class="mb-3">Book a Service</h5>

                    <form id="bookingForm" novalidate>
                        <div class="mb-2">
                            <label class="form-label small">Service</label>
                            <select id="service" class="form-select" required>
                                <option value="">Select a service</option>
                                <option value="home_injection">Home Injection Service</option>
                                <option value="home_blood">Home Blood Sample Collection</option>
                                <option value="home_urine">Home Urine Test Collection</option>
                                <option value="clinic_appointment">Clinic/Hospital Appointment</option>
                            </select>
                        </div>

                        <div class="mb-2">
                            <label class="form-label small">Preferred Date</label>
                            <input id="date" type="date" class="form-control" required>
                        </div>

                        <div class="mb-2">
                            <label class="form-label small">Preferred Time</label>
                            <input id="time" type="time" class="form-control" required>
                        </div>

                        <div id="locationGroup" class="mb-2 d-none">
                            <label class="form-label small">Address (for home service)</label>
                            <textarea id="address" class="form-control" rows="2" placeholder="Street, City, Landmark"></textarea>
                        </div>

                        <div id="clinicGroup" class="mb-2 d-none">
                            <label class="form-label small">Clinic / Doctor</label>
                            <select id="clinic" class="form-select">
                                <option value="">Choose clinic or doctor</option>
                                <option>Central Health Clinic — Dr. A. Kumar (General)</option>
                                <option>Sunrise Diagnostics — Dr. N. Patel (Internal Medicine)</option>
                                <option>GreenCare Hospital — Dr. S. Rao (Pediatrics)</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small">Contact Phone</label>
                            <input id="phone" type="tel" class="form-control" placeholder="+1 555 555 5555" required>
                        </div>

                        <div class="d-grid">
                            <button id="submitBtn" type="submit" class="btn btn-primary">Request Booking</button>
                        </div>
                        <div id="formAlert" class="mt-3" role="status" aria-live="polite"></div>
                    </form>
                </div>

                <div class="card p-3 mt-3 service-card">
                    <h6 class="mb-1">Need help?</h6>
                    <p class="small text-muted mb-0">Call our support team: <strong>+1 (800) 123-4567</strong></p>
                </div>
            </aside>
        </div>

        <!-- Modal: Detailed booking -->
        <div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <form id="modalBookingForm" class="needs-validation" novalidate>
                        <div class="modal-header">
                            <h5 class="modal-title" id="bookingModalLabel"><i class="bi bi-calendar-plus me-2"></i> Book Appointment / Home Service</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <label class="form-label">Full name</label>
                                    <input id="modalName" type="text" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Phone</label>
                                    <input id="modalPhone" type="tel" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Service</label>
                                    <select id="modalService" class="form-select" required>
                                        <option value="">Choose</option>
                                        <option value="home_injection">Home Injection Service</option>
                                        <option value="home_blood">Home Blood Sample Collection</option>
                                        <option value="home_urine">Home Urine Test Collection</option>
                                        <option value="clinic_appointment">Clinic/Hospital Appointment</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Date</label>
                                    <input id="modalDate" type="date" class="form-control" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Time</label>
                                    <input id="modalTime" type="time" class="form-control" required>
                                </div>

                                <div id="modalAddressGroup" class="col-12 d-none">
                                    <label class="form-label">Address</label>
                                    <textarea id="modalAddress" class="form-control" rows="2"></textarea>
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Notes (optional)</label>
                                    <textarea id="modalNotes" class="form-control" rows="2" placeholder="Allergies, mobility needs, preferred nurse..."></textarea>
                                </div>
                            </div>
                            <div id="modalFeedback" class="mt-3" aria-live="polite"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button id="modalSubmit" type="submit" class="btn btn-primary">Confirm Booking</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <footer class="footer mt-5">
            <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted">© <?php echo date('Y'); ?> Hospital — Trusted healthcare at your convenience.</small>
                <small class="text-muted">Partners: Accredited Labs & Clinics</small>
            </div>
        </footer>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Minimal JS to handle UI interactions and mock submission.
        (function(){
            const serviceEl = document.getElementById('service');
            const locationGroup = document.getElementById('locationGroup');
            const clinicGroup = document.getElementById('clinicGroup');
            const addressEl = document.getElementById('address');
            const bookingForm = document.getElementById('bookingForm');
            const formAlert = document.getElementById('formAlert');

            function updateFormFields() {
                const v = serviceEl.value;
                if (v.startsWith('home_')) {
                    locationGroup.classList.remove('d-none');
                    clinicGroup.classList.add('d-none');
                    addressEl.required = true;
                } else if (v === 'clinic_appointment') {
                    clinicGroup.classList.remove('d-none');
                    locationGroup.classList.add('d-none');
                    addressEl.required = false;
                } else {
                    locationGroup.classList.add('d-none');
                    clinicGroup.classList.add('d-none');
                    addressEl.required = false;
                }
            }
            serviceEl.addEventListener('change', updateFormFields);

            bookingForm.addEventListener('submit', function(e){
                e.preventDefault();
                formAlert.innerHTML = '';
                // simple validation
                const service = serviceEl.value;
                const date = document.getElementById('date').value;
                const time = document.getElementById('time').value;
                const phone = document.getElementById('phone').value.trim();

                if (!service || !date || !time || !phone) {
                    formAlert.innerHTML = '<div class="alert alert-danger py-2">Please complete the required fields.</div>';
                    return;
                }

                // Build payload
                const payload = {
                    service, date, time, phone,
                    address: document.getElementById('address').value || null,
                    clinic: document.getElementById('clinic').value || null,
                    source: 'services_frontend'
                };

                // Mock network request
                document.getElementById('submitBtn').disabled = true;
                formAlert.innerHTML = '<div class="alert alert-info py-2">Submitting booking...</div>';

                // Replace with real endpoint (e.g. /api/book) when backend is ready.
                setTimeout(function(){
                    document.getElementById('submitBtn').disabled = false;
                    formAlert.innerHTML = '<div class="alert alert-success py-2">Booking requested successfully. We will contact you shortly to confirm.</div>';
                    console.log('Booking payload (mock):', payload);
                    bookingForm.reset();
                    updateFormFields();
                }, 900);
            });

            // Modal form logic
            const modalService = document.getElementById('modalService');
            const modalAddressGroup = document.getElementById('modalAddressGroup');
            const modalBookingForm = document.getElementById('modalBookingForm');
            const modalFeedback = document.getElementById('modalFeedback');
            const bookingModalEl = document.getElementById('bookingModal');

            modalService.addEventListener('change', function(){
                if (modalService.value.startsWith('home_')) {
                    modalAddressGroup.classList.remove('d-none');
                    document.getElementById('modalAddress').required = true;
                } else {
                    modalAddressGroup.classList.add('d-none');
                    document.getElementById('modalAddress').required = false;
                }
            });

            modalBookingForm.addEventListener('submit', function(e){
                e.preventDefault();
                modalFeedback.innerHTML = '';
                const name = document.getElementById('modalName').value.trim();
                const phone = document.getElementById('modalPhone').value.trim();
                const service = modalService.value;
                const date = document.getElementById('modalDate').value;
                const time = document.getElementById('modalTime').value;

                if (!name || !phone || !service || !date || !time) {
                    modalFeedback.innerHTML = '<div class="alert alert-danger py-2">Please complete the required fields.</div>';
                    return;
                }

                const payload = {
                    name, phone, service, date, time,
                    address: document.getElementById('modalAddress').value || null,
                    notes: document.getElementById('modalNotes').value || null,
                    source: 'services_modal'
                };

                document.getElementById('modalSubmit').disabled = true;
                modalFeedback.innerHTML = '<div class="alert alert-info py-2">Submitting booking...</div>';

                setTimeout(function(){
                    document.getElementById('modalSubmit').disabled = false;
                    modalFeedback.innerHTML = '<div class="alert alert-success py-2">Booking confirmed (mock). Our team will contact you shortly.</div>';
                    console.log('Modal booking payload (mock):', payload);
                    // Auto close modal after a short delay
                    setTimeout(function(){
                        const modal = bootstrap.Modal.getInstance(bookingModalEl);
                        modal.hide();
                        modalBookingForm.reset();
                        modalFeedback.innerHTML = '';
                        modalAddressGroup.classList.add('d-none');
                    }, 1200);
                }, 900);
            });

            // Initialize UI state
            updateFormFields();
        })();
    </script>
</body>
</html>