<?php
require 'inc/db.php';
include 'inc/header.php';

$msg = "";
$error = "";

if (isset($_POST['submit'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $subject = $conn->real_escape_string($_POST['subject']);
    $message = $conn->real_escape_string($_POST['message']);

    if (!empty($name) && !empty($email) && !empty($message)) {
        $sql = "INSERT INTO contacts (name, email, subject, message) VALUES ('$name', '$email', '$subject', '$message')";
        if ($conn->query($sql) === TRUE) {
            $msg = "Thank you! Your message has been sent.";
        } else {
            $error = "Error: " . $conn->error;
        }
    } else {
        $error = "Please fill in all required fields.";
    }
}
?>

<div class="card contact-card">
    <a href="index.php" class="button btn-back" style="margin-bottom: 20px;">&larr; Back to Home</a>
    <h2>Contact Us</h2>
    <p>We'd love to hear from you! Whether you are a user or a service provider.</p>
    
    <?php if($msg): ?>
        <div style="background-color: #d4edda; color: #155724; padding: 15px; border-radius: 4px; margin-bottom: 20px;">
            <?php echo $msg; ?>
        </div>
    <?php endif; ?>
    
    <?php if($error): ?>
        <div style="background-color: #f8d7da; color: #721c24; padding: 15px; border-radius: 4px; margin-bottom: 20px;">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="contact.php" class="contact-form">
        <label>Name:</label>
        <input type="text" name="name" required placeholder="Your Name">

        <label>Email:</label>
        <input type="email" name="email" required placeholder="Your Email">

        <label>Subject:</label>
        <input type="text" name="subject" placeholder="Subject">

        <label>Message:</label>
        <textarea name="message" rows="5" required placeholder="How can we help?" style="width: 100%; padding: 12px; margin: 10px 0 20px; border: 1px solid #ddd; border-radius: 4px;"></textarea>

        <button type="submit" name="submit" class="button btn-contact">Send Message</button>
    </form>
</div>

<?php include 'inc/footer.php'; ?>
