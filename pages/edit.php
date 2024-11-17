<?php
include '../controller/database.php';
session_start();

$data = mysqli_query($conn, "SELECT * FROM task WHERE id_task = '".$_GET['id']."'" );
$ambil = mysqli_fetch_array($data);
$name_task = $ambil['name_task'];
$detail = $ambil['detail'];
$status = $ambil['status'];
$deadline = $ambil['deadline'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adz Taskly</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body{
            padding: 0;
            margin: 0;
            background-image: url(../assets/images/image.jpg);
            background-size: 100%;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            height: 100vh;
        }
        .btn-light{
            transition: transform 0.3s;
        }
        .btn-light:hover{
            transform: scale(1.05);
        }
    </style>
</head>
<body>

    <!-- Main Content -->
    <div class="container mt-5">

        <!-- Task List edit -->
        <div class="card shadow-lg W-50">
            <div class="card-header bg-primary text-white">
                <p class="mt-2 fw-bold">My Task / Edit</p>
            </div>
            <div class="card-body p-5">
                <form method="POST">
                            <div class="mb-3">
                                <label for="taskName" class="form-label">Task Name</label>
                                <input type="text" class="form-control" name="taskName" placeholder="Enter task name" value="<?php echo $name_task ?>">
                            </div>
                            <div class="form-floating mb-3">
                                <textarea class="form-control" placeholder="detail your task" name="detail"><?php echo $detail; ?></textarea>
                                <label for="detail">Detail task</label>
                            </div>
                            <div class="mb-3">
                                <label for="taskStatus" class="form-label">Status</label>
                                <select class="form-select" name="taskStatus">
                                    <option selected value="<?php echo $status; ?>"><?php echo $status; ?></option>
                                    <option value="Not In Progress">Not in Progress</option>
                                    <option value="In Progress">In Progress</option>
                                    <option value="Completed">Completed</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label for="taskDeadline" class="form-label">Deadline</label>
                                <input type="date" class="form-control" name="taskDeadline" value="<?php echo date("d-m-Y"); ?>">
                            </div>
                            <hr>
                            <button type="submit" name="edit" class="btn btn-warning me-2">Save Change</button>
                            <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>


            <?php
                if(isset($_POST['edit'])){
                    $name_task = $_POST['taskName'];
                    $detail = $_POST['detail'];
                    $tgl = $_POST['taskDeadline'];
                    $status = $_POST['taskStatus'];

                    // Buat query UPDATE tergantung apakah deadline diisi atau tidak
                    if (!empty($tgl)) {
                        // Jika deadline diisi, update semua kolom
                        $query = "UPDATE task SET name_task = '$name_task', detail = '$detail', status = '$status', deadline = '$tgl' WHERE id_task = '" . $_GET['id'] . "'";
                    } else {
                        // Jika deadline kosong, update hanya kolom selain deadline
                        $query = "UPDATE task SET name_task = '$name_task', detail = '$detail', status = '$status' WHERE id_task = '" . $_GET['id'] . "'";
                    }

                    // Eksekusi query
                    $editTask = mysqli_query($conn, $query);

                    if ($editTask) {
                        echo '<script>';
                        echo 'Swal.fire({
                                title: "Edit Task!",
                                text: "Edit Task Successfully!",
                                icon: "success"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "dashboard.php";
                                }
                            });';
                        echo '</script>';
                    } else {
                        echo '<script>';
                        echo 'Swal.fire({
                                title: "Oops!",
                                text: "Edit Task Failed!",
                                icon: "error"
                            });';
                        echo '</script>';
                    }
                }            
            ?>







    <!-- Bootstrap and Icons -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></scri
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>
</html>
