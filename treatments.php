<?php
require_once 'config/database.php';

$database = new Database();
$db = $database->getConnection();

// Initialize treatments array
$treatments = [];

// Check if treatments table exists and fetch data
try {
    $query = "SELECT * FROM treatments WHERE is_active = 1 ORDER BY category, name";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $treatments = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    // If table doesn't exist, use default treatments
    $treatments = [
        [
            'id' => 1,
            'name' => 'Ultrasound Therapy',
            'description' => 'Deep tissue heating using high-frequency sound waves to promote healing and reduce inflammation.',
            'benefits' => 'Reduces pain and inflammation, Improves blood circulation, Accelerates tissue healing',
            'conditions_treated' => 'Muscle strains, Tendonitis, Bursitis, Joint contractures',
            'duration' => '10-15 minutes',
            'category' => 'Electrotherapy',
            'image' => 'ultrasound.jpg'
        ],
        [
            'id' => 2,
            'name' => 'Manual Therapy',
            'description' => 'Hands-on techniques including joint mobilization and soft tissue manipulation.',
            'benefits' => 'Improves joint mobility, Reduces pain, Enhances tissue healing',
            'conditions_treated' => 'Back pain, Neck pain, Joint stiffness, Muscle tension',
            'duration' => '20-30 minutes',
            'category' => 'Manual Therapy',
            'image' => 'manual.jpg'
        ]
    ];
}

// Group treatments by category
$treatmentsByCategory = [];
foreach ($treatments as $treatment) {
    $category = $treatment['category'] ?? 'General';
    $treatmentsByCategory[$category][] = $treatment;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Treatments - Munibality PhysioCo</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .treatment-card {
            background: var(--white);
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            margin-bottom: 2rem;
        }
        
        .treatment-card:hover {
            transform: translateY(-5px);
        }
        
        .treatment-image {
            width: 100%;
            height: 200px;
            background: var(--lightest-pink);
            border-radius: 10px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gray-text);
            font-size: 1.1rem;
        }
        
        .treatment-category {
            background: var(--primary-color);
            color: var(--white);
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: bold;
            display: inline-block;
            margin-bottom: 1rem;
        }
        
        .treatment-benefits, .treatment-conditions {
            background: var(--lightest-pink);
            padding: 1rem;
            border-radius: 8px;
            margin: 1rem 0;
        }
        
        .treatment-benefits h4, .treatment-conditions h4 {
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }
        
        .treatment-duration {
            background: var(--secondary-color);
            color: var(--white);
            padding: 0.5rem 1rem;
            border-radius: 15px;
            display: inline-block;
            font-weight: bold;
            margin-top: 1rem;
        }
        
        .category-section {
            margin-bottom: 4rem;
        }
        
        .category-title {
            color: var(--primary-color);
            font-size: 2rem;
            margin-bottom: 2rem;
            padding-bottom: 0.5rem;
            border-bottom: 3px solid var(--primary-color);
        }
    </style>
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
                <h1>Our Advanced Treatment Methods</h1>
                <p>Discover our comprehensive range of physiotherapy treatments designed to address various conditions and promote optimal healing and recovery.</p>
            </div>
        </section>

        <!-- Treatments Section -->
        <section class="services">
            <div class="container">
                <?php foreach ($treatmentsByCategory as $category => $categoryTreatments): ?>
                <div class="category-section">
                    <h2 class="category-title"><?php echo htmlspecialchars($category); ?></h2>
                    
                    <div class="services-grid">
                        <?php foreach ($categoryTreatments as $treatment): ?>
                        <div class="treatment-card">
                            <div class="treatment-category"><?php echo htmlspecialchars($treatment['category']); ?></div>
                            
                            <div class="treatment-image">
                                <img src="/placeholder.svg?height=200&width=300" alt="<?php echo htmlspecialchars($treatment['name']); ?>" style="width: 100%; height: 100%; object-fit: cover; border-radius: 10px;">
                            </div>
                            
                            <h3 style="color: var(--primary-color); margin-bottom: 1rem;"><?php echo htmlspecialchars($treatment['name']); ?></h3>
                            
                            <p style="color: var(--gray-text); margin-bottom: 1.5rem;"><?php echo htmlspecialchars($treatment['description']); ?></p>
                            
                            <?php if (!empty($treatment['benefits'])): ?>
                            <div class="treatment-benefits">
                                <h4>Benefits:</h4>
                                <p><?php echo htmlspecialchars($treatment['benefits']); ?></p>
                            </div>
                            <?php endif; ?>
                            
                            <?php if (!empty($treatment['conditions_treated'])): ?>
                            <div class="treatment-conditions">
                                <h4>Conditions Treated:</h4>
                                <p><?php echo htmlspecialchars($treatment['conditions_treated']); ?></p>
                            </div>
                            <?php endif; ?>
                            
                            <?php if (!empty($treatment['duration'])): ?>
                            <div class="treatment-duration">
                                Duration: <?php echo htmlspecialchars($treatment['duration']); ?>
                            </div>
                            <?php endif; ?>
                            
                            <div style="margin-top: 2rem; text-align: center;">
                                <a href="book-session.php" class="btn-primary">Book Treatment</a>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- Treatment Process Section -->
        <section class="about">
            <div class="container">
                <h2 class="section-title">Our Treatment Process</h2>
                <div class="services-grid">
                    <div class="service-card">
                        <h3>1. Assessment</h3>
                        <p>Comprehensive evaluation of your condition, medical history, and treatment goals to determine the most appropriate treatment approach.</p>
                    </div>
                    <div class="service-card">
                        <h3>2. Treatment Plan</h3>
                        <p>Development of a personalized treatment plan combining the most effective treatments for your specific condition and needs.</p>
                    </div>
                    <div class="service-card">
                        <h3>3. Treatment Sessions</h3>
                        <p>Implementation of selected treatments by our experienced physiotherapists using state-of-the-art equipment and techniques.</p>
                    </div>
                    <div class="service-card">
                        <h3>4. Progress Monitoring</h3>
                        <p>Regular assessment of your progress and adjustment of treatment protocols to ensure optimal outcomes and recovery.</p>
                    </div>
                    <div class="service-card">
                        <h3>5. Home Program</h3>
                        <p>Customized home exercise and self-care programs to support your recovery and maintain improvements between sessions.</p>
                    </div>
                    <div class="service-card">
                        <h3>6. Follow-up Care</h3>
                        <p>Ongoing support and follow-up appointments to ensure long-term success and prevent re-injury or recurrence.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Call to Action -->
        <section class="hero">
            <div class="hero-content">
                <h2>Ready to Start Your Treatment?</h2>
                <p>Our expert team is ready to help you choose the right treatment approach for your condition. Book your consultation today.</p>
                <div class="cta-buttons">
                    <a href="book-session.php" class="btn-primary">Book Your Session</a>
                    <a href="contact.php" class="btn-secondary">Ask Questions</a>
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
                    <h3>Treatment Categories</h3>
                    <a href="treatments.php#electrotherapy">Electrotherapy</a>
                    <a href="treatments.php#manual">Manual Therapy</a>
                    <a href="treatments.php#thermal">Thermal Therapy</a>
                    <a href="treatments.php#exercise">Exercise Therapy</a>
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
