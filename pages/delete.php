<?php
include '../controller/database.php'; 

// Cek apakah ID ada di URL
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Query untuk menghapus task berdasarkan ID
        $deleteQuery = "DELETE FROM task WHERE id_task = '$id'";

        if (mysqli_query($conn, $deleteQuery)) {
            header('location: dashboard.php');
        }
    }
?>
