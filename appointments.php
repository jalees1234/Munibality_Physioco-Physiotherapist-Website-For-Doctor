<?php
require_once 'config/database.php';

$database = new Database();
$db = $database->getConnection();

// This page could be used for appointment management or just information
// For now, let's make it an informational page about booking appointments
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointments - Munibality PhysioCo</title>
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
                <h1>Book Your Appointment</h1>
                <p>Schedule your physiotherapy session with our expert team. We're here to help you on your journey to better health and mobility.</p>
                <div class="cta-buttons">
                    <a href="book-session.php" class="btn-primary">Book Now</a>
                    <a href="contact.php" class="btn-secondary">Contact Us</a>
                </div>
            </div>
        </section>

        <!-- Appointment Info Section -->
        <section class="services">
            <div class="container">
                <h2 class="section-title">Appointment Information</h2>
                
                <div class="services-grid">
                    <div class="service-card">
                        <h3>📅 Easy Booking</h3>
                        <p>Book your appointment online 24/7 through our convenient booking system. Choose your preferred date, time, and service.</p>
                        <a href="book-session.php" class="btn-primary">Book Online</a>
                    </div>
                    
                    <div class="service-card">
                        <h3>⏰ Flexible Hours</h3>
                        <p>We offer flexible appointment times to accommodate your busy schedule, including evening and weekend slots.</p>
                        <div class="price">Mon-Sat: 4PM-10PM</div>
                        <div class="price">Sun: Closed</div>
                    </div>
                    
                    <div class="service-card">
                        <h3>📞 Phone Booking</h3>
                        <p>Prefer to speak with someone? Call us directly to schedule your appointment and ask any questions.</p>
                        <div class="price">+92-307-4069625</div>
                        <a href="tel:+923074069625" class="btn-primary">Call Now</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Appointment Process -->
        <section class="about">
            <div class="container">
                <h2 class="section-title">What to Expect</h2>
                <div class="about-content">
                    <div class="about-text">
                        <h3>Before Your Visit</h3>
                        <ul style="margin-left: 1.5rem; color: var(--gray-text); margin-bottom: 2rem;">
                            <li>Arrive 15 minutes early for paperwork</li>
                            <li>Bring a valid ID and insurance card</li>
                            <li>Wear comfortable, loose-fitting clothing</li>
                            <li>Bring any relevant medical reports or X-rays</li>
                            <li>Prepare a list of current medications</li>
                        </ul>

                        <h3>During Your Session</h3>
                        <ul style="margin-left: 1.5rem; color: var(--gray-text); margin-bottom: 2rem;">
                            <li>Comprehensive assessment and evaluation</li>
                            <li>Discussion of your symptoms and goals</li>
                            <li>Personalized treatment plan development</li>
                            <li>Hands-on therapy and exercises</li>
                            <li>Home exercise program instruction</li>
                        </ul>

                        <h3>After Your Visit</h3>
                        <ul style="margin-left: 1.5rem; color: var(--gray-text);">
                            <li>Follow-up appointment scheduling</li>
                            <li>Home exercise program materials</li>
                            <li>Progress tracking and adjustments</li>
                            <li>24/7 support for any questions</li>
                        </ul>
                    </div>
                    <div class="about-image">
                        <img src="/placeholder.svg?height=400&width=500" alt="Physiotherapy Session" style="width: 100%; border-radius: 15px;">
                    </div>
                </div>
            </div>
        </section>

        <!-- Policies Section -->
        <section class="services">
            <div class="container">
                <h2 class="section-title">Appointment Policies</h2>
                
                <div style="background: var(--lightest-pink); padding: 3rem; border-radius: 15px; margin-bottom: 2rem;">
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
                        <div>
                            <h3 style="color: var(--primary-color); margin-bottom: 1rem;">Cancellation Policy</h3>
                            <p style="color: var(--gray-text);">We require at least 24 hours advance notice for appointment cancellations. Late cancellations or no-shows may result in a charge of 50% of the session fee.</p>
                        </div>
                        
                        <div>
                            <h3 style="color: var(--primary-color); margin-bottom: 1rem;">Payment Policy</h3>
                            <p style="color: var(--gray-text);">Payment is due at the time of service. We accept cash, credit/debit cards, and bank transfers. Insurance claims can be processed upon request.</p>
                        </div>
                        
                        <div>
                            <h3 style="color: var(--primary-color); margin-bottom: 1rem;">Rescheduling</h3>
                            <p style="color: var(--gray-text);">Appointments can be rescheduled up to 24 hours in advance without penalty. We'll do our best to accommodate your preferred new time slot.</p>
                        </div>
                        
                        <div>
                            <h3 style="color: var(--primary-color); margin-bottom: 1rem;">Emergency Appointments</h3>
                            <p style="color: var(--gray-text);">For urgent cases, we offer same-day appointments when available. Please call us directly for emergency scheduling.</p>
                        </div>
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
