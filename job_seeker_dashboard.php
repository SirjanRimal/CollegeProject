<?php 
session_start();
include('navbar.php');
include('config.php');

// Uncomment this for authentication
// if (!isset($_SESSION['user_id'])) {
//     header("Location: login.php");
//     exit;
// }

// Fetch job applications securely using a prepared statement
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("
    SELECT jobs.title, jobs.company, applications.applied_at 
    FROM applications 
    JOIN jobs ON applications.job_id = jobs.job_id 
    WHERE applications.user_id = ?
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$applications = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Seeker Dashboard</title>
    <link rel="stylesheet" type="text/css" href="jobseeker.css">
</head>
<body>
    <div class="container">
        <h1>Welcome, Job Seeker</h1>
        <h2>Your Applications</h2>
        
        <div class="job-list">
            <?php if ($applications->num_rows > 0): ?>
                <?php while ($app = $applications->fetch_assoc()): ?>
                    <div class="job-card">
                        <h3><?= htmlspecialchars($app['title']) ?></h3>
                        <p><strong>Company:</strong> <?= htmlspecialchars($app['company']) ?></p>
                        <p><strong>Applied at:</strong> <?= htmlspecialchars($app['applied_at']) ?></p>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="no-data">No applications found.</p>
            <?php endif; ?>
        </div>

        <div class="button-group">
            <a href="search.php" class="btn">🔍 Browse Jobs</a>
            <a href="logout.php" class="logout-btn">🚪 Logout</a>
        </div>
    </div>
</body>
</html>
