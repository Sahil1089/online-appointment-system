<?php
// /c:/xampp/htdocs/hospital/pages/doctors.php
// Simple "product-like" doctors listing with "Book Appointment" and "Details" buttons.
// Replace the sample $doctors array with DB queries as needed.

$doctors = [
    [
        'id' => 1,
        'name' => 'Dr. Alice Morgan',
        'specialty' => 'Cardiology',
        'avatar' => 'https://via.placeholder.com/300x200?text=Dr+Alice',
        'fee' => 80,
        'rating' => 4.7,
        'bio' => 'Experienced cardiologist focusing on preventive cardiology and heart failure management.',
        'locations' => 'Building A — Room 210',
        'times' => ['2025-11-24 09:00', '2025-11-24 11:00', '2025-11-25 15:00'],
    ],
    [
        'id' => 2,
        'name' => 'Dr. Brian Chen',
        'specialty' => 'Dermatology',
        'avatar' => 'https://via.placeholder.com/300x200?text=Dr+Brian',
        'fee' => 60,
        'rating' => 4.4,
        'bio' => 'Skin specialist treating acne, eczema, and cosmetic dermatology procedures.',
        'locations' => 'Building B — Room 108',
        'times' => ['2025-11-24 10:30', '2025-11-26 14:00', '2025-11-27 09:00'],
    ],
    [
        'id' => 3,
        'name' => 'Dr. Carla Iqbal',
        'specialty' => 'Pediatrics',
        'avatar' => 'https://via.placeholder.com/300x200?text=Dr+Carla',
        'fee' => 50,
        'rating' => 4.9,
        'bio' => 'Pediatrician providing newborn care, vaccinations and developmental follow-ups.',
        'locations' => 'Building C — Room 5',
        'times' => ['2025-11-24 08:30', '2025-11-25 12:00', '2025-11-26 16:00'],
    ],
    // Add more doctors...
];

function e($v){ return htmlspecialchars($v, ENT_QUOTES, 'UTF-8'); }
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Doctors — Book an Appointment</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card-img-top { height: 160px; object-fit: cover; }
        .rating { color: #f5b301; font-weight: 600; }
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

<div class="container py-4">
    <div style="margin-top:2.45rem;" class="d-flex align-items-center mb-4">
        <h1 class="me-auto">Our Doctors</h1>
        <div class="text-muted">Find a specialist and book an appointment</div>
    </div>

    <div class="row g-3">
        <?php foreach ($doctors as $doc): ?>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="card h-100">
                    <img src="<?php echo e($doc['avatar']); ?>" class="card-img-top" alt="<?php echo e($doc['name']); ?>">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title mb-1"><?php echo e($doc['name']); ?></h5>
                        <p class="text-muted small mb-2"><?php echo e($doc['specialty']); ?></p>
                        <p class="mb-2"><strong>$<?php echo e(number_format($doc['fee'], 2)); ?></strong> per consult</p>
                        <div class="mb-3">
                            <span class="rating"><?php echo e($doc['rating']); ?> ★</span>
                            <span class="text-muted small">• <?php echo e($doc['locations']); ?></span>
                        </div>

                        <div class="mt-auto d-flex gap-2">
                            <!-- Details button opens details modal and passes data attributes -->
                            <button
                                class="btn btn-outline-primary btn-sm flex-fill"
                                data-bs-toggle="modal"
                                data-bs-target="#detailsModal"
                                data-id="<?php echo e($doc['id']); ?>"
                                data-name="<?php echo e($doc['name']); ?>"
                                data-specialty="<?php echo e($doc['specialty']); ?>"
                                data-bio="<?php echo e($doc['bio']); ?>"
                                data-avatar="<?php echo e($doc['avatar']); ?>"
                                data-fee="<?php echo e(number_format($doc['fee'], 2)); ?>"
                                data-rating="<?php echo e($doc['rating']); ?>"
                                data-locations="<?php echo e($doc['locations']); ?>"
                                data-times="<?php echo e(json_encode($doc['times'])); ?>"
                            >Details</button>

                            <!-- Book appointment button opens booking modal -->
                            <button
                                class="btn btn-primary btn-sm flex-fill"
                                data-bs-toggle="modal"
                                data-bs-target="#bookModal"
                                data-id="<?php echo e($doc['id']); ?>"
                                data-name="<?php echo e($doc['name']); ?>"
                                data-fee="<?php echo e(number_format($doc['fee'], 2)); ?>"
                                data-times="<?php echo e(json_encode($doc['times'])); ?>"
                            >Book Appointment</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Details Modal -->
<div class="modal fade" id="detailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Doctor details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-5">
                        <img id="detailsAvatar" src="" alt="" class="img-fluid rounded">
                    </div>
                    <div class="col-md-7">
                        <h4 id="detailsName"></h4>
                        <p class="text-muted" id="detailsSpecialty"></p>
                        <p id="detailsBio"></p>
                        <p><strong>Fee:</strong> $<span id="detailsFee"></span></p>
                        <p><strong>Location:</strong> <span id="detailsLocation"></span></p>
                        <p><strong>Rating:</strong> <span id="detailsRating"></span> ★</p>
                        <div>
                            <strong>Next available:</strong>
                            <ul id="detailsTimes" class="mb-0"></ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</div>

<!-- Book Appointment Modal -->
<div class="modal fade" id="bookModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <form method="post" action="/hospital/actions/book_appointment.php" id="bookForm">
                <div class="modal-header">
                    <h5 class="modal-title">Book Appointment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="doctor_id" id="bookDoctorId">
                    <div class="mb-3">
                        <label class="form-label">Doctor</label>
                        <input type="text" id="bookDoctorName" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Choose time</label>
                        <select name="appointment_time" id="bookTimeSelect" class="form-select" required>
                            <!-- options populated by JS -->
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Your name</label>
                        <input type="text" name="patient_name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Phone / Contact</label>
                        <input type="tel" name="patient_contact" class="form-control" required>
                    </div>

                    <div class="mb-2 text-muted small">Consult fee: $<span id="bookFee"></span></div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm">Confirm Booking</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Details modal population
    var detailsModal = document.getElementById('detailsModal');
    detailsModal.addEventListener('show.bs.modal', function (event) {
        var btn = event.relatedTarget;
        if (!btn) return;
        var name = btn.dataset.name;
        var specialty = btn.dataset.specialty;
        var bio = btn.dataset.bio;
        var avatar = btn.dataset.avatar;
        var fee = btn.dataset.fee;
        var rating = btn.dataset.rating;
        var locations = btn.dataset.locations;
        var times = [];

        try { times = JSON.parse(btn.dataset.times || '[]'); } catch (e) { times = []; }

        document.getElementById('detailsAvatar').src = avatar;
        document.getElementById('detailsName').textContent = name;
        document.getElementById('detailsSpecialty').textContent = specialty;
        document.getElementById('detailsBio').textContent = bio;
        document.getElementById('detailsFee').textContent = fee;
        document.getElementById('detailsRating').textContent = rating;
        document.getElementById('detailsLocation').textContent = locations;

        var timesList = document.getElementById('detailsTimes');
        timesList.innerHTML = '';
        if (times.length === 0) {
            timesList.innerHTML = '<li class="text-muted">No available times</li>';
        } else {
            times.forEach(function(t){
                // format ISO-like string for display
                var d = new Date(t);
                timesList.innerHTML += '<li>' + (isNaN(d) ? t : d.toLocaleString()) + '</li>';
            });
        }
    });

    // Book modal population
    var bookModal = document.getElementById('bookModal');
    bookModal.addEventListener('show.bs.modal', function (event) {
        var btn = event.relatedTarget;
        if (!btn) return;
        var id = btn.dataset.id;
        var name = btn.dataset.name;
        var fee = btn.dataset.fee;
        var times = [];

        try { times = JSON.parse(btn.dataset.times || '[]'); } catch (e) { times = []; }

        document.getElementById('bookDoctorId').value = id;
        document.getElementById('bookDoctorName').value = name;
        document.getElementById('bookFee').textContent = fee;

        var select = document.getElementById('bookTimeSelect');
        select.innerHTML = '';
        if (times.length === 0) {
            var opt = document.createElement('option');
            opt.value = '';
            opt.text = 'No available times';
            opt.disabled = true;
            opt.selected = true;
            select.appendChild(opt);
        } else {
            times.forEach(function(t){
                var d = new Date(t);
                var text = isNaN(d) ? t : d.toLocaleString();
                var opt = document.createElement('option');
                opt.value = t;
                opt.text = text;
                select.appendChild(opt);
            });
        }
    });

    // Optional: intercept booking form submit to do client-side validation or AJAX.
    // document.getElementById('bookForm').addEventListener('submit', function(e){
    //     // e.preventDefault();
    //     // perform AJAX POST to book_appointment.php
    // });
});
</script>
</body>
</html>