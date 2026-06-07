<?php
require_once 'config/database.php';

$database = new Database();
$db = $database->getConnection();

// Initialize services array
$services = [];

// Check if services table exists and fetch data
try {
    $query = "SELECT * FROM services LIMIT 6";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $services = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    // If table doesn't exist, use default services
    $services = [
        ['id' => 1, 'name' => 'Orthopedic Physiotherapy', 'description' => 'Comprehensive treatment for musculoskeletal conditions, joint pain, and mobility issues.', 'price' => 3500],
        ['id' => 2, 'name' => 'Sports Physiotherapy', 'description' => 'Specialized treatment for sports injuries and performance enhancement.', 'price' => 4000],
        ['id' => 3, 'name' => 'Neurological Physiotherapy', 'description' => 'Treatment for neurological conditions affecting movement and function.', 'price' => 4500],
        ['id' => 4, 'name' => 'Pediatric Physiotherapy', 'description' => 'Specialized care for children with developmental and movement disorders.', 'price' => 3000],
        ['id' => 5, 'name' => 'Geriatric Physiotherapy', 'description' => 'Tailored treatment for elderly patients focusing on mobility and independence.', 'price' => 3200],
        ['id' => 6, 'name' => 'Manual Therapy', 'description' => 'Hands-on treatment techniques for pain relief and improved mobility.', 'price' => 3800]
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Munibality PhysioCo - Premier Physiotherapy Clinic in Pakistan</title>
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

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>Expert Physiotherapy Care in Pakistan</h1>
            <p>At Munibality PhysioCo, we provide comprehensive physiotherapy services to help you recover, strengthen, and achieve optimal physical health. Our experienced team is dedicated to your wellness journey.</p>
            <div class="cta-buttons">
                <a href="book-session.php" class="btn-primary">Book Your Session</a>
                <a href="services.php" class="btn-secondary">View Services</a>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="services">
        <div class="container">
            <h2 class="section-title">Our Specialized Services</h2>
            <div class="services-grid">
                <?php foreach($services as $service): ?>
                <div class="service-card">
                    <h3><?php echo htmlspecialchars($service['name']); ?></h3>
                    <p><?php echo htmlspecialchars($service['description']); ?></p>
                    <div class="price">Rs <?php echo number_format($service['price'], 0); ?></div>
                    <a href="book-session.php?service=<?php echo $service['id']; ?>" class="btn-primary">Book Now</a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about">
        <div class="container">
            <div class="about-content">
                <div class="about-text">
                    <h2>Why Choose Munibality PhysioCo?</h2>
                    <p>With over a decade of experience in physiotherapy, we are Pakistan's leading physiotherapy clinic dedicated to providing exceptional care and treatment outcomes.</p>
                    <p>Our state-of-the-art facility and evidence-based treatment approaches ensure that you receive the highest quality care tailored to your specific needs.</p>
                    <p>We specialize in treating a wide range of conditions from sports injuries to chronic pain management, helping thousands of patients regain their mobility and quality of life.</p>
                    <a href="about.php" class="btn-primary">Learn More About Us</a>
                </div>
                <div class="about-image">
                    <img src="/placeholder.svg?height=400&width=500" alt="Munibality PhysioCo Clinic" style="width: 100%; border-radius: 15px;">
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact">
        <div class="container">
            <h2 class="section-title">Get In Touch</h2>
            <div class="contact-content">
                <div class="contact-info">
                    <h3>Visit Our Clinic</h3>
                    <p><strong>Address:</strong> 256 MB Sector J DHA phase 6, Lahore, Pakistan</p>
                    <p><strong>Phone:</strong> +92-307-4069625</p>
                    <p><strong>Email:</strong> info@munibality-physioco.com</p>
                    <p><strong>Hours:</strong></p>
                    <ul>
                        <li>Monday - Saturday: 4:00 PM - 10:00 PM</li>
                        <li>Sunday: Closed</li>
                    </ul>
                </div>
                <div class="contact-form">
                    <h3>Send us a Message</h3>
                    <form action="contact-handler.php" method="POST">
                        <div class="form-group">
                            <label for="name">Full Name</label>
                            <input type="text" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="tel" id="phone" name="phone">
                        </div>
                        <div class="form-group">
                            <label for="subject">Subject</label>
                            <input type="text" id="subject" name="subject">
                        </div>
                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea id="message" name="message" required></textarea>
                        </div>
                        <button type="submit" class="btn-primary">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>Munibality PhysioCo</h3>
                    <p>Pakistan's premier physiotherapy clinic dedicated to your health and wellness journey.</p>
                    <p>Empowering you to live pain-free and move with confidence.</p>
                </div>
                <div class="footer-section">
                    <h3>Quick Links</h3>
                    <a href="index.php">Home</a>
                    <a href="services.php">Services</a>
                    <a href="treatments.php">Treatments</a>
                    <a href="appointments.php">Appointments</a>
                    <a href="about.php">About</a>
                    <a href="contact.php">Contact</a>
                    <a href="faqs.php">FAQs</a>
                </div>
                <div class="footer-section">
                    <h3>Services</h3>
                    <a href="services.php#orthopedic">Orthopedic Physiotherapy</a>
                    <a href="services.php#sports">Sports Physiotherapy</a>
                    <a href="services.php#neurological">Neurological Physiotherapy</a>
                    <a href="services.php#pediatric">Pediatric Physiotherapy</a>
                    <a href="services.php#geriatric">Geriatric Physiotherapy</a>
                    <a href="services.php#manual">Manual Therapy</a>
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

    <script src="assets/js/script.js"></script>
</body>
</html>
