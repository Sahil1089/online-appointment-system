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
    .contact-box .form-control,
.contact-box textarea {
  border-radius: 10px;
  padding: 10px;
}

.contact-box {
  background: #fff;
  border-radius: 15px;
}

.contact-box button {
  border-radius: 8px;
  font-weight: 600;
}

</style>
    
</head>
<body>
<div class="container my-5">
  <div class="contact-box p-4 shadow rounded-4">

    <h3 class="fw-bold mb-3">Get in Touch</h3>
    <p class="text-muted mb-4">
      Have questions, need pricing, or want a demo? Send us a message.
    </p>

    <form>
      <div class="row g-3">

        <!-- Name -->
        <div class="col-md-6">
          <label class="form-label">Full Name</label>
          <input type="text" class="form-control" placeholder="Your name" required>
        </div>

        <!-- Email -->
        <div class="col-md-6">
          <label class="form-label">Email</label>
          <input type="email" class="form-control" placeholder="Your email" required>
        </div>

        <!-- Phone -->
        <div class="col-md-6">
          <label class="form-label">Phone</label>
          <input type="text" class="form-control" placeholder="Phone number">
        </div>

        <!-- Organization -->
        <div class="col-md-6">
          <label class="form-label">Hospital / Organization</label>
          <input type="text" class="form-control" placeholder="Clinic / Hospital name">
        </div>

        <!-- Message -->
        <div class="col-12">
          <label class="form-label">Message</label>
          <textarea class="form-control" rows="4" placeholder="Tell us what you need…"></textarea>
        </div>

      </div>

      <div class="mt-4 d-flex justify-content-end">
        
        <a href="javascript:history.back()" 
   style="padding:8px 18px; background-color:whitesmoke; text-decoration:none; margin-right:auto;">
    Back
</a>
        <button type="reset" class="btn btn-light px-4">Cancel</button>
        <button type="submit" class="btn btn-primary px-5">Send Message</button>
      </div>

    </form>
  </div>
</div>

 

</body>
</html>