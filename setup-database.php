<?php
require_once 'config/database.php';

echo "<h2>Setting up Munibality PhysioCo Database...</h2>";

try {
    // First, create connection without specifying database
    $host = "localhost";
    $username = "root";
    $password = "";
    
    $pdo = new PDO("mysql:host=$host", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create database if it doesn't exist
    $pdo->exec("CREATE DATABASE IF NOT EXISTS munibality_physioco");
    echo "<p>✓ Database 'munibality_physioco' created successfully!</p>";
    
    // Use the database
    $pdo->exec("USE munibality_physioco");
    
    // Create services table
    $servicesTable = "
    CREATE TABLE IF NOT EXISTS services (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        description TEXT,
        price DECIMAL(10,2),
        duration INT,
        image VARCHAR(255),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $pdo->exec($servicesTable);
    echo "<p>✓ Services table created successfully!</p>";

    // Create treatments table
    $treatmentsTable = "
    CREATE TABLE IF NOT EXISTS treatments (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        description TEXT,
        benefits TEXT,
        conditions_treated TEXT,
        duration VARCHAR(50),
        image VARCHAR(255),
        category VARCHAR(100),
        is_active BOOLEAN DEFAULT TRUE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $pdo->exec($treatmentsTable);
    echo "<p>✓ Treatments table created successfully!</p>";
    
    // Create appointments table (simplified without payment fields)
    $appointmentsTable = "
    CREATE TABLE IF NOT EXISTS appointments (
        id INT AUTO_INCREMENT PRIMARY KEY,
        first_name VARCHAR(100) NOT NULL,
        last_name VARCHAR(100) NOT NULL,
        email VARCHAR(255) NOT NULL,
        phone VARCHAR(20) NOT NULL,
        service_id INT,
        appointment_date DATE NOT NULL,
        appointment_time TIME NOT NULL,
        message TEXT,
        status ENUM('pending', 'confirmed', 'cancelled') DEFAULT 'pending',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (service_id) REFERENCES services(id)
    )";
    $pdo->exec($appointmentsTable);
    echo "<p>✓ Appointments table created successfully!</p>";
    
    // Create contact messages table
    $contactTable = "
    CREATE TABLE IF NOT EXISTS contact_messages (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        phone VARCHAR(20),
        subject VARCHAR(255),
        message TEXT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $pdo->exec($contactTable);
    echo "<p>✓ Contact messages table created successfully!</p>";
    
    // Create FAQ table
    $faqTable = "
    CREATE TABLE IF NOT EXISTS faqs (
        id INT AUTO_INCREMENT PRIMARY KEY,
        question TEXT NOT NULL,
        answer TEXT NOT NULL,
        category VARCHAR(100),
        is_active BOOLEAN DEFAULT TRUE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $pdo->exec($faqTable);
    echo "<p>✓ FAQs table created successfully!</p>";
    
    // Create payments table
    $paymentsTable = "
    CREATE TABLE IF NOT EXISTS payments (
        id INT AUTO_INCREMENT PRIMARY KEY,
        appointment_id INT,
        payment_method VARCHAR(50) NOT NULL,
        payment_gateway VARCHAR(50) NOT NULL,
        transaction_id VARCHAR(100),
        gateway_payment_id VARCHAR(100),
        amount DECIMAL(10,2) NOT NULL,
        currency VARCHAR(3) DEFAULT 'PKR',
        status ENUM('pending', 'completed', 'failed', 'cancelled', 'refunded') DEFAULT 'pending',
        gateway_response TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (appointment_id) REFERENCES appointments(id)
    )";
    $pdo->exec($paymentsTable);
    echo "<p>✓ Payments table created successfully!</p>";

    // Create payment methods table
    $paymentMethodsTable = "
    CREATE TABLE IF NOT EXISTS payment_methods (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        type VARCHAR(50) NOT NULL,
        is_active BOOLEAN DEFAULT TRUE,
        processing_fee DECIMAL(5,2) DEFAULT 0.00,
        min_amount DECIMAL(10,2) DEFAULT 0.00,
        max_amount DECIMAL(10,2) DEFAULT 999999.99,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $pdo->exec($paymentMethodsTable);
    echo "<p>✓ Payment methods table created successfully!</p>";

    // Insert payment methods
    $checkPaymentMethods = $pdo->query("SELECT COUNT(*) FROM payment_methods")->fetchColumn();
    if ($checkPaymentMethods == 0) {
        $insertPaymentMethods = "
        INSERT INTO payment_methods (name, type, processing_fee, min_amount, max_amount) VALUES
        ('JazzCash', 'mobile_wallet', 2.50, 100.00, 25000.00),
        ('EasyPaisa', 'mobile_wallet', 2.50, 100.00, 25000.00),
        ('Credit/Debit Card', 'card', 3.00, 100.00, 100000.00),
        ('Bank Transfer', 'bank_transfer', 0.00, 500.00, 500000.00),
        ('Cash on Visit', 'cash', 0.00, 0.00, 999999.99)";
        $pdo->exec($insertPaymentMethods);
        echo "<p>✓ Payment methods inserted successfully!</p>";
    }
    
    // Insert sample services
    $checkServices = $pdo->query("SELECT COUNT(*) FROM services")->fetchColumn();
    if ($checkServices == 0) {
        $insertServices = "
        INSERT INTO services (name, description, price, duration, image) VALUES
        ('Orthopedic Physiotherapy', 'Comprehensive treatment for musculoskeletal conditions, joint pain, and mobility issues.', 3500.00, 60, 'orthopedic.jpg'),
        ('Sports Physiotherapy', 'Specialized treatment for sports injuries and performance enhancement.', 4000.00, 60, 'sports.jpg'),
        ('Neurological Physiotherapy', 'Treatment for neurological conditions affecting movement and function.', 4500.00, 75, 'neuro.jpg'),
        ('Pediatric Physiotherapy', 'Specialized care for children with developmental and movement disorders.', 3000.00, 45, 'pediatric.jpg'),
        ('Geriatric Physiotherapy', 'Tailored treatment for elderly patients focusing on mobility and independence.', 3200.00, 60, 'geriatric.jpg'),
        ('Manual Therapy', 'Hands-on treatment techniques for pain relief and improved mobility.', 3800.00, 60, 'manual.jpg')";
        $pdo->exec($insertServices);
        echo "<p>✓ Sample services inserted successfully!</p>";
    }

    // Insert sample treatments
    $checkTreatments = $pdo->query("SELECT COUNT(*) FROM treatments")->fetchColumn();
    if ($checkTreatments == 0) {
        $insertTreatments = "
        INSERT INTO treatments (name, description, benefits, conditions_treated, duration, category, image) VALUES
        ('Ultrasound Therapy', 'Deep tissue heating using high-frequency sound waves to promote healing and reduce inflammation.', 'Reduces pain and inflammation, Improves blood circulation, Accelerates tissue healing, Increases tissue flexibility', 'Muscle strains, Tendonitis, Bursitis, Joint contractures, Scar tissue', '10-15 minutes', 'Electrotherapy', 'ultrasound.jpg'),
        ('Electrical Stimulation (TENS)', 'Transcutaneous Electrical Nerve Stimulation for pain relief and muscle strengthening.', 'Pain relief, Muscle strengthening, Improved circulation, Reduced muscle spasms', 'Chronic pain, Muscle weakness, Post-surgical recovery, Arthritis pain', '15-30 minutes', 'Electrotherapy', 'tens.jpg'),
        ('Hot Pack Therapy', 'Application of moist heat to increase blood flow and relax muscles before treatment.', 'Muscle relaxation, Increased blood flow, Pain reduction, Improved flexibility', 'Muscle tension, Stiffness, Chronic pain, Pre-exercise preparation', '15-20 minutes', 'Thermal Therapy', 'hotpack.jpg'),
        ('Cold Pack Therapy', 'Application of cold to reduce inflammation, swelling, and acute pain.', 'Reduces inflammation, Controls swelling, Numbs pain, Prevents tissue damage', 'Acute injuries, Post-exercise recovery, Inflammation, Swelling', '10-15 minutes', 'Thermal Therapy', 'coldpack.jpg'),
        ('Manual Lymphatic Drainage', 'Gentle massage technique to stimulate lymphatic system and reduce swelling.', 'Reduces swelling, Improves immune function, Promotes healing, Relaxation', 'Lymphedema, Post-surgical swelling, Sports injuries, Chronic fatigue', '45-60 minutes', 'Manual Therapy', 'lymphatic.jpg'),
        ('Dry Needling', 'Insertion of thin needles into trigger points to release muscle tension and pain.', 'Releases trigger points, Reduces muscle tension, Improves range of motion, Pain relief', 'Myofascial pain, Trigger points, Muscle spasms, Chronic pain', '20-30 minutes', 'Manual Therapy', 'dryneedling.jpg'),
        ('Cupping Therapy', 'Application of suction cups to improve blood flow and reduce muscle tension.', 'Improves circulation, Reduces muscle tension, Pain relief, Promotes healing', 'Muscle pain, Back pain, Neck pain, Sports injuries', '15-20 minutes', 'Alternative Therapy', 'cupping.jpg'),
        ('Spinal Mobilization', 'Gentle movement of spinal joints to improve mobility and reduce pain.', 'Improves spinal mobility, Reduces pain, Better posture, Increased flexibility', 'Back pain, Neck pain, Spinal stiffness, Disc problems', '20-30 minutes', 'Manual Therapy', 'spinal.jpg'),
        ('Exercise Therapy', 'Customized exercise programs to strengthen muscles and improve function.', 'Strengthens muscles, Improves endurance, Better balance, Prevents re-injury', 'Weakness, Poor balance, Post-injury recovery, Chronic conditions', '30-45 minutes', 'Exercise Therapy', 'exercise.jpg'),
        ('Postural Correction', 'Assessment and correction of postural imbalances through exercises and education.', 'Improves posture, Reduces pain, Prevents injuries, Better body mechanics', 'Poor posture, Neck pain, Back pain, Headaches', '30-45 minutes', 'Exercise Therapy', 'posture.jpg'),
        ('Gait Training', 'Training to improve walking patterns and mobility for better functional movement.', 'Improves walking, Better balance, Increased confidence, Reduced fall risk', 'Walking difficulties, Balance problems, Post-stroke, Neurological conditions', '30-45 minutes', 'Functional Training', 'gait.jpg'),
        ('Balance Training', 'Exercises and activities to improve balance, coordination, and stability.', 'Better balance, Improved coordination, Reduced fall risk, Increased confidence', 'Balance disorders, Dizziness, Fall prevention, Elderly care', '30-45 minutes', 'Functional Training', 'balance.jpg')";
        $pdo->exec($insertTreatments);
        echo "<p>✓ Sample treatments inserted successfully!</p>";
    }
    
    // Insert sample FAQs
    $checkFAQs = $pdo->query("SELECT COUNT(*) FROM faqs")->fetchColumn();
    if ($checkFAQs == 0) {
        $insertFAQs = "
        INSERT INTO faqs (question, answer, category) VALUES
        ('What should I expect during my first visit?', 'During your first visit, we will conduct a comprehensive assessment of your condition, discuss your medical history, and create a personalized treatment plan.', 'General'),
        ('How long is each session?', 'Most sessions last between 45-75 minutes, depending on the type of treatment required.', 'General'),
        ('Do you accept insurance?', 'Yes, we accept most major insurance plans. Please contact us to verify your coverage.', 'Payment'),
        ('How many sessions will I need?', 'The number of sessions varies depending on your condition and response to treatment. We will discuss this during your initial assessment.', 'Treatment'),
        ('What should I wear to my appointment?', 'Please wear comfortable, loose-fitting clothing that allows easy access to the area being treated.', 'General'),
        ('What is the cancellation policy?', 'We require at least 24 hours notice for cancellations. Late cancellations may incur a fee of 50% of the session cost.', 'Policy'),
        ('Do you provide home visits?', 'Yes, we offer home physiotherapy services for patients who cannot visit our clinic. Additional charges apply for home visits.', 'Services'),
        ('What are your operating hours?', 'We are open Monday-Friday 8AM-8PM, Saturday 9AM-6PM, and Sunday 10AM-4PM. We also offer emergency appointments when needed.', 'General')";
        $pdo->exec($insertFAQs);
        echo "<p>✓ Sample FAQs inserted successfully!</p>";
    }
    
    echo "<h3 style='color: green;'>🎉 Database setup completed successfully!</h3>";
    echo "<p><a href='index.php'>Go to Website</a> | <a href='book-session.php'>Test Booking System</a> | <a href='treatments.php'>View Treatments</a></p>";
    
} catch(PDOException $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}
?>
