<?php
require_once 'config/database.php';

if ($_POST) {
    $database = new Database();
    $db = $database->getConnection();

    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'] ?? '';
    $subject = $_POST['subject'] ?? '';
    $message = $_POST['message'];

    if (!empty($name) && !empty($email) && !empty($message)) {
        try {
            $query = "INSERT INTO contact_messages (name, email, phone, subject, message) VALUES (?, ?, ?, ?, ?)";
            $stmt = $db->prepare($query);
            $stmt->bindParam(1, $name);
            $stmt->bindParam(2, $email);
            $stmt->bindParam(3, $phone);
            $stmt->bindParam(4, $subject);
            $stmt->bindParam(5, $message);

            if ($stmt->execute()) {
                header("Location: contact.php?success=1");
            } else {
                header("Location: contact.php?error=1");
            }
        } catch(PDOException $e) {
            header("Location: contact.php?error=1");
        }
    } else {
        header("Location: contact.php?error=2");
    }
} else {
    header("Location: contact.php");
}
?>
