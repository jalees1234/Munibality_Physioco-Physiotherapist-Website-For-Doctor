<?php
require_once 'config/database.php';

$database = new Database();
$db = $database->getConnection();

// Initialize FAQs array
$faqs = [];

// Check if faqs table exists and fetch data
try {
    $query = "SELECT * FROM faqs WHERE is_active = 1 ORDER BY category, id";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $faqs = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <title>Frequently Asked Questions - Munibality PhysioCo</title>
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

    <main style="margin-top: 100px; padding: 40px 5%;">
        <div class="container">
            <h1 class="section-title">Frequently Asked Questions</h1>
            
            <div class="faq-container">
                <?php foreach($faqs as $faq): ?>
                <div class="faq-item">
                    <button class="faq-question" onclick="toggleFAQ(this)">
                        <?php echo htmlspecialchars($faq['question']); ?>
                        <span>+</span>
                    </button>
                    <div class="faq-answer">
                        <?php echo htmlspecialchars($faq['answer']); ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <div style="margin-top: 3rem; text-align: center; padding: 3rem; background: var(--lightest-pink); border-radius: 5px;">
            <h3>Still Have Questions?</h3>
            <p style="margin-bottom: 1.5rem;">Can't find the answer you're looking for? Our friendly team is here to help!</p>
            <a href="contact.php" class="btn-primary" style="margin-top: 0.5rem; display: inline-block;">Contact Us</a>
            </div>
        </div>
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

    <script>
        function toggleFAQ(element) {
            const answer = element.nextElementSibling;
            const icon = element.querySelector('span');
            
            if (answer.classList.contains('active')) {
                answer.classList.remove('active');
                icon.textContent = '+';
            } else {
                // Close all other FAQs
                document.querySelectorAll('.faq-answer.active').forEach(item => {
                    item.classList.remove('active');
                });
                document.querySelectorAll('.faq-question span').forEach(span => {
                    span.textContent = '+';
                });
                
                // Open clicked FAQ
                answer.classList.add('active');
                icon.textContent = '-';
            }
        }
    </script>
</body>
</html>
