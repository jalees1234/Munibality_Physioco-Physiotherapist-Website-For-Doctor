<?php
$message = '';
$messageType = '';

// Check for success/error messages from contact form submission
if (isset($_GET['success'])) {
    if ($_GET['success'] == '1') {
        $message = "Thank you for your message! We'll get back to you within 24 hours.";
        $messageType = "success";
    }
} elseif (isset($_GET['error'])) {
    if ($_GET['error'] == '1') {
        $message = "Sorry, there was an error sending your message. Please try again.";
        $messageType = "error";
    } elseif ($_GET['error'] == '2') {
        $message = "Please fill in all required fields.";
        $messageType = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Munibality PhysioCo</title>
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
        <h1>Contact Munibality PhysioCo</h1>
        <p>Get in touch with our friendly team. We're here to answer your questions and help you schedule your physiotherapy sessions.</p>
    </div>
</section>

        <!-- Contact Information -->
        <section class="services">
            <div class="container">
                <h2 class="section-title">Get In Touch</h2>
                <div class="services-grid">
                    <div class="service-card">
                        <h3>📍 Visit Our Clinic</h3>
                        <p><strong>Address:</strong><br>
                        256 MB Sector J DHA phase 6<br>
                        Lahore, Punjab 57410<br>
                        Pakistan</p>
                        <a href="https://maps.google.com" target="_blank" class="btn-primary">Get Directions</a>
                    </div>
                    
                    <div class="service-card">
                        <h3>📞 Call Us</h3>
                        <p><strong>Main Line:</strong><br>
                        +92-307-4069625</p>
                        <p><strong>WhatsApp:</strong><br>
                        +92-336-4801508</p>
                        <a href="tel:+923074069625" class="btn-primary">Call Now</a>
                    </div>
                    
                    <div class="service-card">
                        <h3>✉️ Email Us</h3>
                        <p><strong>General Inquiries:</strong><br>
                        info@munibality-physioco.com</p>
                        <p><strong>Appointments:</strong><br>
                        appointments@munibality-physioco.com</p>
                        <a href="mailto:info@munibality-physioco.com" class="btn-primary">Send Email</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Form & Hours -->
        <section class="contact">
            <div class="container">
                <div class="contact-content">
                    <div class="contact-form">
                        <h3>Send us a Message</h3>
                        
                        <?php if ($message): ?>
                            <div class="alert alert-<?php echo $messageType; ?>">
                                <?php echo $message; ?>
                            </div>
                        <?php endif; ?>
                        
                        <form action="contact-handler.php" method="POST">
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="name">Full Name *</label>
                                    <input type="text" id="name" name="name" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email Address *</label>
                                    <input type="email" id="email" name="email" required>
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="phone">Phone Number</label>
                                    <input type="tel" id="phone" name="phone">
                                </div>
                                <div class="form-group">
                                    <label for="subject">Subject</label>
                                    <select id="subject" name="subject">
                                        <option value="">Select a subject...</option>
                                        <option value="General Inquiry">General Inquiry</option>
                                        <option value="Appointment Booking">Appointment Booking</option>
                                        <option value="Insurance Questions">Insurance Questions</option>
                                        <option value="Treatment Information">Treatment Information</option>
                                        <option value="Feedback">Feedback</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="message">Message *</label>
                                <textarea id="message" name="message" required placeholder="Please describe how we can help you..."></textarea>
                            </div>
                            
                            <button type="submit" class="btn-primary">Send Message</button>
                        </form>
                    </div>
                    
                    <div class="contact-info">
                        <h3>Clinic Hours</h3>
                        <div style="background: var(--lightest-pink); padding: 2rem; border-radius: 15px; margin-bottom: 2rem;">
                            <p><strong>Monday - Friday:</strong><br>4:00 PM - 10:00 PM</p>
                            <p><strong>Sunday:</strong><br>Closed</p>
                            <p><strong>Public Holidays:</strong><br>Closed</p>
                        </div>
                        
                        <h3>Emergency Contact</h3>
                        <div style="background: var(--light-pink); padding: 2rem; border-radius: 15px; margin-bottom: 2rem;">
                            <p>For urgent physiotherapy needs outside regular hours:</p>
                            <p><strong>Emergency Line:</strong><br>+92-300-9876543</p>
                            <p><em>Emergency services available for acute injuries and urgent care needs.</em></p>
                        </div>
                        
                        <h3>Insurance & Payment</h3>
                        <div style="background: var(--lightest-pink); padding: 2rem; border-radius: 15px;">
                            <p>We accept:</p>
                            <ul style="margin-left: 1.5rem; color: var(--gray-text);">
                                <li>Cash payments</li>
                                <li>Credit/Debit cards</li>
                                <li>Bank transfers</li>
                                <li>Most major insurance plans</li>
                                <li>Corporate health packages</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Map Section -->
        <section class="about">
            <div class="container">
                <h2 class="section-title">Find Us</h2>
                <div style="background: var(--lightest-pink); padding: 2rem; border-radius: 15px; text-align: center;">
                    <div style="background: #ddd; height: 400px; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 2rem;">
                        <p style="color: #666; font-size: 1.2rem;">Interactive Map Coming Soon</p>
                    </div>
                    <p><strong>Located in the heart of DHA Phase 6, Lahore</strong></p>
                    <p>Easily accessible by public transport and ample parking available</p>
                    <div style="margin-top: 2rem;">
                        <a href="https://maps.google.com" target="_blank" class="btn-primary">View on Google Maps</a>
                        <a href="book-session.php" class="btn-secondary">Book Appointment</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- FAQ Quick Links -->
        <section class="services">
            <div class="container">
                <h2 class="section-title">Quick Questions?</h2>
                <div class="services-grid">
                    <div class="service-card">
                        <h3>❓ Frequently Asked Questions</h3>
                        <p>Find answers to common questions about our services, appointments, and policies.</p>
                        <a href="faqs.php" class="btn-primary">View FAQs</a>
                    </div>
                    
                    <div class="service-card">
                        <h3>📋 New Patient Forms</h3>
                        <p>Download and complete our new patient forms before your first visit to save time.</p>
                        <a href="#" class="btn-primary">Download Forms</a>
                    </div>
                    
                    <div class="service-card">
                        <h3>💬 Live Chat Support</h3>
                        <p>Chat with our support team during business hours for immediate assistance.</p>
                        <a href="#" class="btn-primary">Start Chat</a>
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
                    <a href="appointments.php">Appointments</a>
                    <a href="about.php">About</a>
                    <a href="contact.php">Contact</a>
                    <a href="faqs.php">FAQs</a>
                </div>
                <div class="footer-section">
                    <h3>Services</h3>
                    <a href="services.php">Orthopedic Physiotherapy</a>
                    <a href="services.php">Sports Physiotherapy</a>
                    <a href="services.php">Neurological Physiotherapy</a>
                    <a href="services.php">Pediatric Physiotherapy</a>
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
