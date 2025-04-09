<?php
include("navbar.php");
include('config.php');
if (isset($_POST['contactus'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $remark = $_POST['remark'];
    

    $stmt = $conn->prepare("INSERT INTO `queries`(`name`, `email`, `remarks`) VALUES (?,?,?)");
    $stmt->bind_param("sss",$username,$email,$remark );
    
    if ($stmt->execute()) {
        echo "Query has been sucessfully registered";
        exit();
    } else {
        echo "<p class='error-message'>Error: " . $conn->error . "</p>";
    }
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="contact.css">
</head>
<body>
<div class="container">
        <h2>Contact Us</h2>
        <form class="contact-form" method="post">
            <input type="text" placeholder="Your Name" name="username" id="username"  required>
            <input type="email" placeholder="Your Email" name="email" id="email"  required>
            <textarea placeholder="Your Message" rows="5" name="remark" id="remark" > </textarea>
            <button type="submit" name="contactus">Send Message</button>
        </form>
        
        <div class="contact-info">
            <p><strong>Phone:</strong> +977 </p>
            <p><strong>Email:</strong> hireyou@gmail.com</p>
            <p><strong>Address:</strong> Kathmandu, Nepal</p>
            <p>Follow us: 
                <a href="#">Facebook</a> | 
                <a href="#">Twitter</a> | 
                <a href="#">Instagram</a>
            </p>
        </div>
         </div>
</body>
    
</body>
</html>