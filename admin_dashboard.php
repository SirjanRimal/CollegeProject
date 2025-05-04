<?php 
session_start();
include('config.php');

// Uncomment this for authentication
// if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
//     header("Location: login.php");
//     exit;
// }

// Get pending job approvals 
$jobs = $conn->query("SELECT * FROM jobs WHERE is_approved = 0");  

// Get jobseekers 
$jobseekers = $conn->query("SELECT * FROM users WHERE role = 'job_seeker'");

// Check if jobseekers data is fetched correctly
if ($jobseekers === false) {
    echo "Error fetching jobseekers data: " . $conn->error;
    exit;
}

// Check if jobs data is fetched correctly
if ($jobs === false) {
    echo "Error fetching jobs data: " . $conn->error;
    exit;
}
?> 

<!DOCTYPE html> 
<html lang="en"> 
<head>     
    <meta charset="UTF-8">     
    <title>Admin Dashboard</title>     
    <link rel="stylesheet" href="admin.css"> 
</head> 
<body>     
    <div class="container">         
        <h1>Admin Dashboard</h1>          

        <!-- Pending Job Approvals Section -->
        <h2>Pending Job Approvals</h2>
        <div class="job-list">
            <?php if ($jobs->num_rows > 0): ?>
                <table border="1">
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Salary</th>
                        <th>Actions</th>
                    </tr>
                    <?php while ($job = $jobs->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($job['title']) ?></td>
                            <td><?= nl2br(htmlspecialchars($job['description'])) ?></td>
                            <td>$<?= number_format($job['salary']) ?></td>
                            <td>
                                <a href="approve_job.php?id=<?= $job['job_id'] ?>" class="approve">Approve</a>
                                <a href="delete_job.php?id=<?= $job['job_id'] ?>" class="delete">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </table>
            <?php else: ?>
                <p>No pending job approvals found.</p>
            <?php endif; ?>
        </div>

        <!-- Jobseeker Section -->
        <h2>Jobseekers</h2>
        <table class="jobseekers" border="1" cellpadding="10" cellspacing="0">
        <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
            <?php if ($jobseekers->num_rows > 0): ?>
                <?php while ($user = $jobseekers->fetch_assoc()): ?>
                    <tr>
                        <td><?= $user['id'] ?></td>
                        <td><?= htmlspecialchars($user['username']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td>
                            <a href="edit_user.php?id=<?= $user['id'] ?>">Edit</a> |
                            <a href="delete_user.php?id=<?= $user['id'] ?>" onclick="return confirm('Are you sure you want to delete this jobseeker?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="4">No jobseekers found.</td></tr>
            <?php endif; ?>
        </table>

    </div> 
</body>   
</html>
