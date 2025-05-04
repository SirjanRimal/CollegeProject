<?php include('config.php'); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Job Search</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background-color: #f4f6f8;
            color: #333;
        }

        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
        }

        h2 {
            text-align: center;
            margin-bottom: 24px;
            font-size: 24px;
            font-weight: 700;
        }

        form {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: center;
            margin-bottom: 30px;
        }

        input[type="text"], input[type="number"] {
            padding: 12px 14px;
            border: 1px solid #ccc;
            border-radius: 8px;
            flex: 1 1 200px;
            font-size: 14px;
        }

        button {
            padding: 12px 24px;
            background-color: #3b82f6;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #2563eb;
        }

        .job-list {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .job-card {
            background-color: #f9fafb;
            border: 1px solid #e2e8f0;
            padding: 20px;
            border-radius: 12px;
            transition: 0.3s ease;
        }

        .job-card:hover {
            box-shadow: 0 6px 14px rgba(0, 0, 0, 0.08);
        }

        .job-card h3 {
            margin-top: 0;
            font-size: 18px;
            font-weight: 600;
            color: #2d3748;
        }

        .job-card p {
            margin: 6px 0;
            font-size: 14px;
            color: #4a5568;
        }

        .job-card a {
            display: inline-block;
            margin-top: 10px;
            padding: 10px 16px;
            background-color: #10b981;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }

        .job-card a:hover {
            background-color: #059669;
        }

        @media (max-width: 600px) {
            form {
                flex-direction: column;
                align-items: stretch;
            }
        }
    </style>
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
            <div class="job-card">
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
