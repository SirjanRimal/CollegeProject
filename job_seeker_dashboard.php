<?php 
session_start();
include('navbar.php');
include('config.php');

// Enable error reporting for debugging
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Debug: Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    die("⚠️ User not logged in. Session 'user_id' is not set.");
}

$user_id = $_SESSION['user_id'];

// Debug: Show user ID
echo "<!-- Debug: Logged-in user_id = $user_id -->";

$stmt = $conn->prepare("
    SELECT jobs.title, jobs.company, applications.applied_at 
    FROM applications 
    JOIN jobs ON applications.job_id = jobs.job_id 
    WHERE applications.user_id = ?
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$applications = $stmt->get_result();

// Debug: Show number of applications found
echo "<!-- Debug: Applications found = {$applications->num_rows} -->";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Seeker Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            background: #f4f6f8;
        }

        .container {
            max-width: 900px;
            margin: 40px auto;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }

        h1 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 10px;
            color: #333;
        }

        h2 {
            font-size: 20px;
            margin-bottom: 20px;
            color: #555;
        }

        .job-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 20px;
        }

        .job-card {
            background-color: #f9fafb;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 20px;
            transition: 0.3s ease;
        }

        .job-card:hover {
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
            transform: translateY(-4px);
        }

        .job-card h3 {
            margin: 0 0 10px;
            font-size: 18px;
            color: #2d3748;
        }

        .job-card p {
            margin: 5px 0;
            font-size: 14px;
            color: #4a5568;
        }

        .no-data {
            color: #999;
            font-size: 16px;
            text-align: center;
            margin-top: 20px;
        }

        .button-group {
            margin-top: 30px;
            display: flex;
            gap: 15px;
            justify-content: center;
        }

        .btn, .logout-btn {
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            color: white;
            transition: background-color 0.3s ease;
        }

        .btn {
            background-color: #3b82f6;
        }

        .btn:hover {
            background-color: #2563eb;
        }

        .logout-btn {
            background-color: #ef4444;
        }

        .logout-btn:hover {
            background-color: #dc2626;
        }

        @media (max-width: 600px) {
            .button-group {
                flex-direction: column;
            }
        }
    </style>
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
                <p class="no-data">You haven't applied to any jobs yet.</p>
            <?php endif; ?>
        </div>

        <div class="button-group">
            <a href="search.php" class="btn">🔍 Browse Jobs</a>
            <a href="logout.php" class="logout-btn">🚪 Logout</a>
        </div>
    </div>
</body>
</html>
