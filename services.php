<?php
require_once 'config/database.php';

$database = new Database();
$db = $database->getConnection();

// Initialize services array
$services = [];

// Check if services table exists and fetch data
try {
    $query = "SELECT * FROM services ORDER BY name";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $services = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    // If table doesn't exist, redirect to setup
    header("Location: setup-database.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Services - Munibality PhysioCo</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <nav class="navbar">
            <a href="index.php" class="logo">Munibality PhysioCo</a>
            <ul class="nav-menu">
                <li><a href="index.php">Home</a></li>
                <li><a href="services.php">Services</a></li>
                <li><a href="treatments.php">Treatments</a></li>
                <li><a href="appointments.php">Appointments</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="contact.php">Contact Us</a></li>
                <li><a href="faqs.php">FAQs</a></li>
            </ul>
            <a href="book-session.php" class="book-btn">Book a Session</a>
        </nav>
    </header>

    <main style="margin-top: 100px;">
        <!-- Hero Section -->
        <section class="hero">
            <div class="hero-content">
                <h1>Our Comprehensive Physiotherapy Services</h1>
                <p>We offer a wide range of specialized physiotherapy treatments tailored to meet your unique needs and help you achieve optimal health and mobility.</p>
            </div>
        </section>

        <!-- Services Section -->
        <section class="services">
            <div class="container">
                <div class="services-grid">
                    <?php foreach($services as $service): ?>
                    <div class="service-card">
                        <h3><?php echo htmlspecialchars($service['name']); ?></h3>
                        <p><?php echo htmlspecialchars($service['description']); ?></p>
                        <div class="price">Rs <?php echo number_format($service['price'], 0); ?></div>
                        <p><strong>Duration:</strong> <?php echo $service['duration']; ?> minutes</p>
                        <a href="book-session.php?service=<?php echo $service['id']; ?>" class="btn-primary">Book Now</a>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- Additional Info Section -->
        <section class="about">
            <div class="container">
                <h2 class="section-title">Why Choose Our Services?</h2>
                <div class="about-content">
                    <div class="about-text">
                        <h3>Evidence-Based Treatment</h3>
                        <p>All our treatments are based on the latest research and proven methodologies in physiotherapy.</p>
                        
                        <h3>Personalized Care</h3>
                        <p>Each treatment plan is customized to your specific condition, goals, and lifestyle.</p>
                        
                        <h3>Experienced Professionals</h3>
                        <p>Our team consists of highly qualified and experienced physiotherapists with specialized training.</p>
                        
                        <h3>Modern Equipment</h3>
                        <p>We use state-of-the-art equipment and the latest therapeutic techniques for optimal results.</p>
                    </div>
                    <div class="about-image">
                        <img src="/placeholder.svg?height=400&width=500" alt="Modern Physiotherapy Equipment" style="width: 100%; border-radius: 15px;">
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>Munibality PhysioCo</h3>
                    <p>Pakistan's premier physiotherapy clinic dedicated to your health and wellness journey.</p>
                </div>
                <div class="footer-section">
                    <h3>Contact Info</h3>
                    <p>256 MB Sector J DHA phase 6</p>
                    <p>Lahore, Pakistan</p>
                    <p>Phone: +92-307-4069625</p>
                    <p>Email: info@munibality-physioco.com</p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 Munibality PhysioCo. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
