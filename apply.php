<?php
session_start();
include('config.php');

// ✅ Make sure user is logged in and is a job seeker
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'job_seeker') {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // ✅ Validate job ID
    if (empty($_POST['job_id'])) {
        echo "Job ID is missing.";
        exit;
    }

    $job_id = (int) $_POST['job_id'];
    $user_id = (int) $_SESSION['user_id'];
    $resume_path = '';

    // ✅ Handle resume upload
    if (isset($_FILES['resume']) && $_FILES['resume']['error'] === 0) {
        $upload_dir = 'uploads/';

        // Create uploads/ if it doesn't exist
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $filename = uniqid() . "_" . basename($_FILES['resume']['name']);
        $target_file = $upload_dir . $filename;

        if (move_uploaded_file($_FILES['resume']['tmp_name'], $target_file)) {
            $resume_path = $target_file;
        } else {
            echo "Failed to upload resume.";
            exit;
        }
    } else {
        echo "Resume file is required.";
        exit;
    }

    // ✅ Insert application into database
    $stmt = $conn->prepare("INSERT INTO applications (job_id, user_id, resume_path, applied_at) VALUES (?, ?, ?, NOW())");
    if ($stmt) {
        $stmt->bind_param("iis", $job_id, $user_id, $resume_path);
        if ($stmt->execute()) {
            // ✅ Redirect to dashboard
            header("Location: job_seeker_dashboard.php");
            exit;
        } else {
            echo "Failed to save application.";
        }
        $stmt->close();
    } else {
        echo "Failed to prepare SQL statement.";
    }

} else {
    echo "Invalid request.";
}
?>
