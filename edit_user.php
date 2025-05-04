<?php
session_start();
include('config.php');

// Only admin can access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

// Check if user ID is provided
if (!isset($_GET['id'])) {
    echo "No user ID provided.";
    exit;
}

$id = intval($_GET['id']);

// Fetch user data
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    echo "User not found.";
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $role = $_POST['role'];

    $update = $conn->prepare("UPDATE users SET username = ?, email = ?, role = ? WHERE id = ?");
    $update->bind_param("sssi", $username, $email, $role, $id);
    $update->execute();

    header("Location: admin_dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
</head>
<body>
    <h1>Edit User</h1>
    <form method="post">
        <label>Username:</label><br>
        <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required><br><br>

        <label>Role:</label><br>
        <select name="role" required>
            <option value="jobseeker" <?= $user['role'] === 'jobseeker' ? 'selected' : '' ?>>Jobseeker</option>
            <option value="employer" <?= $user['role'] === 'employer' ? 'selected' : '' ?>>Employer</option>
            <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
        </select><br><br>

        <button type="submit">Save Changes</button>
        <a href="admin_dashboard.php">Cancel</a>
    </form>
</body>
</html>
