<?php 
session_start();
include('config.php');
include('navbaremployer.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Only employers should access this page
if ($_SESSION['role'] != 'employer') {
    header("Location: job_seeker_dashboard.php");
    exit;
}

if (isset($_POST['post_job'])) {
    $title = htmlspecialchars($_POST['title']);
    $description = htmlspecialchars($_POST['description']);
    $salary = htmlspecialchars($_POST['salary']);
    $company = htmlspecialchars($_POST['company']);
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO jobs (user_id, title, description, salary, company, status) VALUES (?, ?, ?, ?, ?, 'pending')");
    $stmt->bind_param("issss", $user_id, $title, $description, $salary, $company);
    
    if ($stmt->execute()) {
        $message = "<p class='success-message'>Job posted successfully! Waiting for admin approval.</p>";
    } else {
        $message = "<p class='error-message'>Error: " . $conn->error . "</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Job</title>
    <link rel="stylesheet" href="postjob.css">
</head>
<body>
    <div class="container">
        <h2>Post a New Job</h2>

        <?php if (isset($message)) echo $message; ?>

        <form method="post">
            <label for="title">Job Title</label>
            <input type="text" id="title" name="title" placeholder="Enter job title" required>

            <label for="description">Job Description</label>
            <textarea id="description" name="description" placeholder="Enter job description" required></textarea>

            <label for="salary">Salary</label>
            <input type="number" id="salary" name="salary" placeholder="Enter salary amount" step="0.01" required>

            <label for="company">Company Name</label>
            <input type="text" id="company" name="company" placeholder="Enter company name" required>

            <button type="submit" name="post_job">Post Job</button>
        </form>
        <a href="employer_dashboard.php" class="back-link">← Back to Dashboard</a>
    </div>
</body>
</html>
