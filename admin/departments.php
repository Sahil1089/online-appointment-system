<?php
// Dummy department data (replace with DB results later)
$departments = [
    [
        'id' => 1,
        'name' => 'Cardiology',
        'description' => 'Heart specialists and cardiac care unit.',
        'icon' => 'heart-pulse',
        'doctors' => 12,
        'status' => 'Active'
    ],
    [
        'id' => 2,
        'name' => 'Neurology',
        'description' => 'Brain and nervous system treatments.',
        'icon' => 'cpu',
        'doctors' => 8,
        'status' => 'Active'
    ],
    [
        'id' => 3,
        'name' => 'Orthopedics',
        'description' => 'Bone, joints, and spine specialists.',
        'icon' => 'bone',
        'doctors' => 5,
        'status' => 'Disabled'
    ]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Department Management</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<style>
/* Modern Cards */
.dept-card {
    border-radius: 18px;
    padding: 20px;
    background: rgba(255, 255, 255, 0.8);
    backdrop-filter: blur(16px);
    border: 1px solid rgba(255,255,255,0.12);
    transition: 0.3s;
}
.dept-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
}

/* Icon Circle */
.icon-badge {
    width: 60px;
    height: 60px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 26px;
    color: #fff;
    background: linear-gradient(135deg, #6a11cb, #2575fc);
}

/* Status Badges */
.badge-active {
    background-color: #28a745;
}
.badge-disabled {
    background-color: #dc3545;
}
body{
    background-color: #eafffdff;
    color:black;
}
.view:hover{
    background-color: #f8ffecff;
}
</style>
</head>

<body class=" text-black">

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Departments</h2>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDeptModal">
            <i class="bi bi-plus-circle"></i> Add Department
        </button>
    </div>

    <!-- ================= CARDS GRID ================= -->
    <div class="row g-4">
        <?php foreach ($departments as $d): ?>
        <div class="col-md-4">
            <div class="dept-card h-100">
                <div class="d-flex align-items-center mb-3">
                    <div class="icon-badge me-3">
                        <i class="bi bi-<?= $d['icon'] ?>"></i>
                    </div>
                    <div>
                        <h5 class="mb-0"><?= $d['name'] ?></h5>
                        <small><?= $d['doctors'] ?> Doctors</small>
                    </div>
                </div>
                <p><?= $d['description'] ?></p>

                <span class="badge 
                    <?= $d['status'] === 'Active' ? 'badge-active' : 'badge-disabled' ?>">
                    <?= $d['status'] ?>
                </span>

                <div class="mt-3">
                    <button class="btn btn-sm view text-black btn-outline-dark" data-bs-toggle="modal" data-bs-target="#viewDeptModal">View</button>
                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editDeptModal">Edit</button>
                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteDeptModal">Delete</button>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>


    <!-- ================= TABLE VIEW ================= -->
    <div class="mt-5">
        <h4>Department Table</h4>
        <table class="table table-light table-striped table-hover mt-3">
            <thead>
                <tr>
                    <th>Icon</th>
                    <th>Name</th>
                    <th>Doctors</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($departments as $d): ?>
                <tr>
                    <td><i class="bi bi-<?= $d['icon'] ?> fs-4"></i></td>
                    <td><?= $d['name'] ?></td>
                    <td><?= $d['doctors'] ?></td>
                    <td><span class="badge <?= $d['status']=='Active'?'badge-active':'badge-disabled' ?>"><?= $d['status'] ?></span></td>
                    <td>
                        <button class="btn btn-sm btn-info">View</button>
                        <button class="btn btn-sm btn-warning">Edit</button>
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>

<!-- ================= MODALS ================= -->

<!-- Add Department -->
<div class="modal fade" id="addDeptModal">
  <div class="modal-dialog">
    <div class="modal-content bg-white text-dark">
      <div class="modal-header">
        <h5>Add Department</h5>
        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input class="form-control mb-2" placeholder="Department Name">
        <textarea class="form-control mb-2" placeholder="Description"></textarea>
        <input class="form-control mb-2" placeholder="Icon (Bootstrap Icon name)">
        <select class="form-control mb-2">
          <option value="Active">Active</option>
          <option value="Disabled">Disabled</option>
        </select>
      </div>
      <div class="modal-footer">
        <button class="btn btn-success">Save</button>
      </div>
    </div>
  </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editDeptModal">
  <div class="modal-dialog">
    <div class="modal-content bg-white text-dark">
      <div class="modal-header">
        <h5>Edit Department</h5>
        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input class="form-control mb-2" value="Cardiology">
        <textarea class="form-control mb-2">Heart specialists.</textarea>
        <input class="form-control mb-2" value="heart-pulse">
        <select class="form-control mb-2">
          <option>Active</option>
          <option>Disabled</option>
        </select>
      </div>
      <div class="modal-footer">
        <button class="btn btn-warning">Update</button>
      </div>
    </div>
  </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteDeptModal">
  <div class="modal-dialog">
    <div class="modal-content bg-white text-dark">
      <div class="modal-header">
        <h5>Delete Department</h5>
        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete this department?
      </div>
      <div class="modal-footer">
        <button class="btn btn-danger">Yes, Delete</button>
      </div>
    </div>
  </div>
</div>

<!-- View Modal -->
<div class="modal fade" id="viewDeptModal">
  <div class="modal-dialog">
    <div class="modal-content bg-light text-dark">
      <div class="modal-header">
        <h5>Department Details</h5>
        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <h5>Cardiology</h5>
        <p>Heart specialists and cardiac care.</p>
        <p><strong>Doctors:</strong> 12</p>
        <p><strong>Status:</strong> Active</p>
      </div>
    </div>
  </div>
</div>
<?php include 'components/backbtn.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
