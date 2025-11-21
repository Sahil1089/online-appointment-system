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




    
</head>
<body>
   <div class="container my-4">
  <div class="p-4 shadow rounded-4 booking-form">

    <h4 class="fw-bold mb-4">Book Appointment / Home Service</h4>

    <form>
      <div class="row g-3">

        <!-- Full Name -->
        <div class="col-md-6">
          <label class="form-label">Full name</label>
          <input type="text" class="form-control" placeholder="Enter full name">
        </div>

        <!-- Phone -->
        <div class="col-md-6">
          <label class="form-label">Phone</label>
          <input type="text" class="form-control" placeholder="Enter phone number">
        </div>

        <!-- Service -->
        <div class="col-md-4">
          <label class="form-label">Service</label>
          <select class="form-select">
            <option selected disabled>Choose</option>
            <option>Home Service</option>
            <option>In-Clinic appointment</option>
            <option>Teleconsultation</option>
          </select>
        </div>

        <!-- Date -->
        <div class="col-md-4">
          <label class="form-label">Date</label>
          <input type="date" class="form-control">
        </div>

        <!-- Time -->
        <div class="col-md-4">
          <label class="form-label">Time</label>
          <input type="time" class="form-control">
        </div>

        <!-- Notes -->
        <div class="col-12">
          <label class="form-label">Notes (optional)</label>
          <textarea class="form-control" rows="3"
            placeholder="Allergies, mobility needs, preferred nurse..."></textarea>
        </div>

      </div>

      <div class="d-flex justify-content-end gap-2 mt-4">
        <a href="../home.php" style="padding:8px 18px ;background-color:whitesmoke;text-decoration:none;margin-right:auto">back</a>
        <button type="reset" class="btn btn-light px-4">Cancel</button>
        <button type="submit" class="btn btn-primary px-4">Confirm Booking</button>
      </div>

    </form>

  </div>
</div>
 
 

</body>
</html>