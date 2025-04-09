<?php 
include('config.php');
include('navbar.php');


?>
<!DOCTYPE html>
<html>
<head>
    <title>Job Search</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Find Jobs</h2>
        <form method="get" action="search.php">
            <input type="text" name="title" placeholder="Job Title">
            <input type="number" name="min_salary" placeholder="Minimum Salary">
            <button type="submit">Search</button>
        </form>
        
        <div class="job-list">
            <?php
            $title = isset($_GET['title']) ? "%".$_GET['title']."%" : "%";
            $min_salary = isset($_GET['min_salary']) ? $_GET['min_salary'] : 0;

            $stmt = $conn->prepare("SELECT * FROM jobs WHERE title LIKE ? AND salary >= ? AND is_approved = 1");
            $stmt->bind_param("sd", $title, $min_salary);
            $stmt->execute();
            $result = $stmt->get_result();

            while ($job = $result->fetch_assoc()): ?>
            <table>
                <td>
            <div class="container">
                <h3><?= $job['title'] ?></h3>
                <p><?= $job['description'] ?></p>
                <p>Salary: $<?= $job['salary'] ?></p>
                <p>Company: <?= $job['company'] ?></p>
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'job_seeker'): ?>
                  <button>  <a href="apply_job.php?job_id=<?= $job['job_id'] ?>">Apply Now</a></button>
                <?php endif; ?> 
            </div>
            </td>
            </table>
            
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>