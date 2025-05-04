<?php
session_start();
include('config.php');
include('navbar.php');

// Check if the user is logged in and is a job seeker
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'job_seeker') {
    header("Location: login.php");
    exit;
}

$upload_error = "";
$success_message = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['job_id'])) {
    $job_id = intval($_POST['job_id']);
    $user_id = $_SESSION['user_id'];

    // Validate and handle resume upload
    if (isset($_FILES['resume']) && $_FILES['resume']['error'] === 0) {
        $resume_name = basename($_FILES['resume']['name']);
        $target_dir = "uploads/";
        $unique_name = uniqid() . "_" . $resume_name;
        $target_file = $target_dir . $unique_name;

        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        if (move_uploaded_file($_FILES['resume']['tmp_name'], $target_file)) {
            // Insert application into the database
            $stmt = $conn->prepare("INSERT INTO applications (job_id, user_id, resume_path, applied_at) VALUES (?, ?, ?, NOW())");
            $stmt->bind_param("iis", $job_id, $user_id, $target_file);
            if ($stmt->execute()) {
                $success_message = "Application submitted successfully!";
                header("Location: job_seeker_dashboard.php");
                exit;
            } else {
                $upload_error = "Failed to submit application. Please try again.";
            }
        } else {
            $upload_error = "Failed to upload resume.";
        }
    } else {
        $upload_error = "Please upload a resume file.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Apply for Job</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 500px;
            margin: 40px auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 25px;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-top: 15px;
        }
        input[type="text"],
        input[type="email"],
        input[type="file"] {
            padding: 10px;
            margin-top: 5px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }
        button {
            margin-top: 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #45a049;
        }
        .message {
            margin-top: 15px;
            color: red;
            text-align: center;
        }
        .success {
            color: green;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Apply for Job</h2>
        <form action="apply.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="job_id" value="<?= htmlspecialchars($_GET['job_id'] ?? '') ?>">

            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" placeholder="Enter your name" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required>

            <label for="resume">Upload Resume</label>
            <input type="file" id="resume" name="resume" accept=".pdf,.doc,.docx" required>

            <button type="submit">Submit Application</button>

            <?php if ($upload_error): ?>
                <div class="message"><?= htmlspecialchars($upload_error) ?></div>
            <?php endif; ?>

            <?php if ($success_message): ?>
                <div class="message success"><?= htmlspecialchars($success_message) ?></div>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>
