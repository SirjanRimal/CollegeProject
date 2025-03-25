<?php
session_start();
include('config.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

if (isset($_GET['id'])) {
    $job_id = $_GET['id'];
    $conn->query("DELETE FROM jobs WHERE job_id = $job_id");
}
header("Location: admin_dashboard.php");