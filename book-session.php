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

$message = '';
$messageType = '';

// Handle form submission
if ($_POST) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $service_id = $_POST['service_id'];
    $appointment_date = $_POST['appointment_date'];
    $appointment_time = $_POST['appointment_time'];
    $appointment_message = $_POST['message'];

    // Validate required fields
    if (!empty($first_name) && !empty($last_name) && !empty($email) && !empty($phone) && !empty($service_id) && !empty($appointment_date) && !empty($appointment_time)) {
        
        // Check if appointment slot is available
        $check_query = "SELECT COUNT(*) as count FROM appointments WHERE appointment_date = ? AND appointment_time = ? AND status != 'cancelled'";
        $check_stmt = $db->prepare($check_query);
        $check_stmt->bindParam(1, $appointment_date);
        $check_stmt->bindParam(2, $appointment_time);
        $check_stmt->execute();
        $result = $check_stmt->fetch(PDO::FETCH_ASSOC);

        if ($result['count'] == 0) {
            // Insert appointment
            $query = "INSERT INTO appointments (first_name, last_name, email, phone, service_id, appointment_date, appointment_time, message) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $db->prepare($query);
            $stmt->bindParam(1, $first_name);
            $stmt->bindParam(2, $last_name);
            $stmt->bindParam(3, $email);
            $stmt->bindParam(4, $phone);
            $stmt->bindParam(5, $service_id);
            $stmt->bindParam(6, $appointment_date);
            $stmt->bindParam(7, $appointment_time);
            $stmt->bindParam(8, $appointment_message);

            if ($stmt->execute()) {
                $message = "Your appointment has been booked successfully! We will contact you within 24 hours to confirm your appointment.";
                $messageType = "success";
            } else {
                $message = "Sorry, there was an error booking your appointment. Please try again.";
                $messageType = "error";
            }
        } else {
            $message = "Sorry, this time slot is already booked. Please choose a different time.";
            $messageType = "error";
        }
    } else {
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
    <title>Book a Session - Munibality PhysioCo</title>
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
            <h1 class="section-title">Book Your Physiotherapy Session</h1>
            
            <?php if ($message): ?>
                <div class="alert alert-<?php echo $messageType; ?>">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <div class="appointment-form">
                <form method="POST" action="">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="first_name">First Name *</label>
                            <input type="text" id="first_name" name="first_name" required>
                        </div>
                        <div class="form-group">
                            <label for="last_name">Last Name *</label>
                            <input type="text" id="last_name" name="last_name" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="email">Email Address *</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone Number *</label>
                            <input type="tel" id="phone" name="phone" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="service_id">Select Service *</label>
                        <select id="service_id" name="service_id" required>
                            <option value="">Choose a service...</option>
                            <?php foreach($services as $service): ?>
                                <option value="<?php echo $service['id']; ?>">
                                    <?php echo htmlspecialchars($service['name']); ?> - Rs <?php echo number_format($service['price'], 0); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="appointment_date">Preferred Date *</label>
                            <input type="date" id="appointment_date" name="appointment_date" required min="<?php echo date('Y-m-d'); ?>">
                        </div>
                        <div class="form-group">
                            <label for="appointment_time">Preferred Time *</label>
                            <select id="appointment_time" name="appointment_time" required>
                                <option value="">Select time...</option>
                                <option value="16:00:00">4:00 PM</option>
                                <option value="17:00:00">5:00 PM</option>
                                <option value="18:00:00">6:00 PM</option>
                                <option value="16:00:00">7:00 PM</option>
                                <option value="17:00:00">8:00 PM</option>
                                <option value="18:00:00">9:00 PM</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="message">Additional Message (Optional)</label>
                        <textarea id="message" name="message" placeholder="Please describe your condition or any specific requirements..."></textarea>
                    </div>

                    <button type="submit" class="btn-primary">Book Appointment</button>
                </form>
            </div>

            <div style="margin-top: 3rem; padding: 2rem; background: var(--lightest-pink); border-radius: 15px;">
                <h3>What to Expect</h3>
                <ul style="margin-left: 2rem; color: var(--gray-text);">
                    <li>Comprehensive initial assessment (45-60 minutes)</li>
                    <li>Personalized treatment plan</li>
                    <li>Professional and caring environment</li>
                    <li>State-of-the-art equipment and techniques</li>
                    <li>Follow-up care and home exercise programs</li>
                </ul>
                
                <h3 style="margin-top: 2rem;">Payment Information</h3>
                <p style="color: var(--gray-text);">Payment is due at the time of service. We accept cash, credit/debit cards, and bank transfers. Insurance claims can be processed upon request.</p>
                
                <h3 style="margin-top: 2rem;">Cancellation Policy</h3>
                <p style="color: var(--gray-text);">Please provide at least 24 hours advance notice for appointment cancellations. Late cancellations or no-shows may result in a charge of 50% of the session fee.</p>
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
            <div class="footer-bottom">
                <p>&copy; 2025 Munibality PhysioCo. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
