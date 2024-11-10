<?php
include '../controller/database.php';
session_start();
if (!isset($_SESSION['name'])) {
    header('location: login.php');
} else {

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
            overflow: hidden;
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
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand px-5" href="dashboard.php">Adz Taskly</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle"></i> <?php echo $_SESSION['name']; ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-5">
        <!-- Add Task Button -->
        <div class="d-flex justify-content-between align-items-center mt-4">
            <h3>Task List</h3>
            <button class="btn btn-outline-dark fw-bold" data-bs-toggle="modal" data-bs-target="#addTaskModal"><i class="bi bi-plus-circle fw-bold"></i> Add Task</button>
        </div>

        <!-- Task List -->
        <div class="card mt-3 shadow-lg">
            <div class="card-header bg-primary text-white">
                <p class="mt-3 fw-bold">My Task</p>
            </div>
            <?php
                // Query untuk mengambil data dari tabel 'task'
                $query = "SELECT * FROM task WHERE id_created = '".$_SESSION['id_user']."'";
                $result = mysqli_query($conn, $query);

                // Cek jika ada data yang ditemukan
                if (mysqli_num_rows($result) > 0) {
                    echo '<ul class="list-group list-group-flush">';

                    // Loop untuk setiap data yang diambil
                    while ($row = mysqli_fetch_assoc($result)) {
                        $id_task = $row['id_task'];
                        $name_task = htmlspecialchars($row['name_task']);
                        $detail = htmlspecialchars($row['detail']);
                        $status = htmlspecialchars($row['status']);
                        $deadline = date("d F Y", strtotime($row['deadline']));

                        echo '<li class="list-group-item d-flex align-items-center">';
                        
                        // Konten Task
                            echo '<div class="task-content ms-3 flex-grow-1">';
                            
                            echo '<span class="fw-bold"><i class="bi bi-clipboard-check me-2"></i> ' . $name_task . '</span>';
                            echo '<small class="text-muted d-block"><i class="bi bi-calendar3 me-2"></i> Deadline: ' . $deadline . '</small>';
                            echo '</div>';

                            // Tentukan warna badge berdasarkan status
                            $badgeStatus = '';
                            
                            
                        switch ($status) {
                            case 'Completed':
                                $badgeStatus = 'bg-success text-white';
                            break; 

                            case 'In Progress':
                                $badgeStatus = 'bg-warning text-dark';
                            break;

                            case 'Not In Progress':
                                $badgeStatus = 'bg-danger text-white';     
                            break;

                            default:
                                $badgeStatus = 'bg-secondary text-white';
                            break;
                        }

                        // Status atau Kategori Task dengan badge berwarna
                        echo '<div class="badge ' . $badgeStatus . ' me-3 p-2 shadow-sm">' . $status . '</div>|';

                        // Aksi Task
                        echo '<div class="task-actions m-2">';
                        echo '<button class="btn btn-light btn-sm ms-2 me-2" data-bs-toggle="modal" data-bs-target="#viewModal' . $id_task . '"><i class="bi bi-eye"></i></button>
                                <!-- Modal View -->
                                <div class="modal fade" id="viewModal' . $id_task . '" tabindex="-1" aria-labelledby="viewModalLabel' . $id_task . '" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg"> <!-- Ukuran modal diperbesar untuk tampilan yang lebih luas -->
                                        <div class="modal-content rounded-4 shadow">
                                            <!-- Modal Header dengan tampilan warna gradien -->
                                            <div class="modal-header" style="background: linear-gradient(135deg, #4A90E2, #9013FE); color: white;">
                                                <h5 class="modal-title" id="viewModalLabel' . $id_task . '">
                                                    <i class="bi bi-list-task me-2"></i> Task Details
                                                </h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            
                                            <!-- Modal Body dengan gaya konten yang lebih jelas dan rapi -->
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <p class="mb-1"><strong>Task Name:</strong></p>
                                                        <p class="text-muted">' . $name_task . '</p>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <p class="mb-1"><strong>Deadline:</strong></p>
                                                        <p class="text-muted">' . $deadline . '</p>
                                                    </div>
                                                    <div class="col-12 mb-3">
                                                        <p class="mb-1"><strong>Detail:</strong></p>
                                                        <p class="text-muted">' . $detail . '</p>
                                                    </div>
                                                    <div class="col-12">
                                                        <p class="mb-1"><strong>Status:</strong></p>
                                                        <span class="badge ' . $badgeStatus . ' p-2 shadow-sm fs-6">' . $status . '</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Modal Footer -->
                                            <div class="modal-footer bg-light">
                                                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            ';
                        echo '<a href="edit.php?id=' . $id_task . '"><button class="btn btn-light btn-sm me-2"><i class="bi bi-pencil"></i></button></a>';
                        echo '<button class="btn btn-light btn-sm" onclick="confirmDelete(' . $id_task . ')"><i class="bi bi-trash"></i></button>';
                        echo '</div>';

                        echo '</li>';
                    }

                    echo '</ul>';
                } else {
                    echo '<div style="text-align: center; padding: 20px;">';
                    echo '<img src="../assets/images/nodata.jpg" alt="No tasks" style="max-width: 200px; height: auto; display: block; margin: 0 auto;">';
                    echo '<p>No tasks found.</p>';
                    echo '</div>';
                }
            ?>
        </div>
    </div>



    <!-- Add Task Modal -->
    <div class="modal fade" id="addTaskModal" tabindex="-1" aria-labelledby="addTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTaskModalLabel">Add New Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST">
                        <div class="mb-4">
                            <label for="taskName" class="form-label">Task Name</label>
                            <input type="text" class="form-control" name="taskName" placeholder="Enter task name">
                        </div>
                        <div class="form-floating mb-3">
                            <textarea class="form-control" placeholder="detail your task" name="detail"></textarea>
                            <label for="detail">Detail task</label>
                        </div>
                        <div class="mb-3">
                            <label for="taskStatus" class="form-label">Status</label>
                            <select class="form-select" name="taskStatus">
                                <option selected>Choose Status</option>
                                <option value="Not In Progress">Not in Progress</option>
                                <option value="In Progress">In Progress</option>
                                <option value="Completed">Completed</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="taskDeadline" class="form-label">Deadline</label>
                            <input type="date" class="form-control" name="taskDeadline">
                        </div>
                        <hr>
                        <button type="submit" name="add" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Add Task</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
            <?php
                if(isset($_POST['add'])){
                    $name_task = $_POST['taskName'];
                    $detail = $_POST['detail'];
                    $tgl = $_POST['taskDeadline'];
                    $status = $_POST['taskStatus'];
                    $id_created = $_SESSION['id_user'];

                        $addTask = mysqli_query($conn, "INSERT INTO task(id_task, name_task, detail, status, deadline, id_created) VALUES(NULL, '$name_task', '$detail', '$status', '$tgl', '$id_created')");

                        if ($addTask) {
                            echo '<script>';
                            echo 'Swal.fire({
                                    title: "Good job!",
                                    text: "Add task success!",
                                    icon: "success"
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                         window.location.href = "dashboard.php";
                                    }
                                });';
                            echo '</script>';
                        }else {
                            echo '<script>';
                            echo 'Swal.fire({
                                    title: "Oops!",
                                    text: "Add task failed!",
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




    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: "Are you sure?",
                text: "This action cannot be undone!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {

            if (result.isConfirmed) {
            // Jika user menekan "Yes", redirect ke PHP delete
                        window.location.href = "delete.php?id=" + id;
                    }
                });
            }
    </script>
</body>
</html>
<?php } ?>