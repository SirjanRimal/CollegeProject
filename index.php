
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HireYou - Your Job Portal</title>
    <link rel="stylesheet" href="index.css">
    <link rel="icon" href="./foricons/ren.png">
</head>
<body>
    <!-- Navbar -->
    <header>
        <div class="logo"><a href="#">HireYou</a></div>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="#">About Us</a></li>
                <li class="dropdown">
                    <a href="#">Help</a>
                    <ul class="dropdown-content">
                        <li><a href="#">FAQ</a></li>
                    </ul>
                </li>
                <li><a href="#">Contact Us</a></li>
                <li><a href="login.php" class="btn">Log in</a></li>
                <li><a href="register.php" class="btn">Sign Up</a></li>
            </ul>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <h1>Find Your Dream Job or Post One!</h1>
        <p>Connecting job seekers and employers for a better future.</p>
        <div class="search-bar">
            <input type="text" placeholder="Search for jobs..." />
            <button>Search</button>
        </div>
    </section>

    <!-- About HireYou -->
    <section class="about">
        <h2>What is HireYou?</h2>
        <p>HireYou is a modern job portal designed to connect **job seekers** with **employers**. Whether you're looking for a job or trying to hire skilled professionals, we make the process simple and effective.</p>
        
        <div class="features">
            <div class="feature">
               <a href="register.php"> <h3>For Job Seekers</h3>
                <p>Search for jobs in various industries, apply easily, and build your career.</p></a>
            </div>
            <div class="feature">
            <a href="register.php"> <h3>For Employers</h3>
                <p>Post job listings, find the right candidates, and grow your company with top talent.</p></a>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="cta">
        <h2>Join HireYou Today!</h2>
        <p>Sign up now and take your career or business to the next level.</p>
        <a href="register.php" class="cta-btn">Get Started</a>
    </section>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 HireYou. All rights reserved.</p>
    </footer>
</body>
</html>
