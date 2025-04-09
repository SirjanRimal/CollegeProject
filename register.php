<?php
 include('config.php');
 include('navbar.php');


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="register.css">
</head>
<body>
    <div class="container">
        <h2>Register</h2>
        <form method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <select name="role" required>
                <option value="job_seeker">Job Seeker</option>
                <option value="employer">Employer</option>
            </select>
            <button type="submit" name="register">Register</button>
        </form>

        <?php
        if (isset($_POST['register'])) {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $role = $_POST['role'];

            $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $username, $email, $password, $role);
            
            if ($stmt->execute()) {
                header("Location: login.php");
                exit();
            } else {
                echo "<p class='error-message'>Error: " . $conn->error . "</p>";
            }
        }
        ?>

        <p class="redirect-link">Already have an account? <a href="login.php">Login here</a></p>
    </div>
</body>
</html>
