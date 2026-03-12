<?php
require 'inc/db.php';
include 'inc/header.php';
?>

<div class="card" style="text-align: center; padding: 50px 20px; background: linear-gradient(to right, #3498db, #2c3e50); color: white;">
    <h1 style="font-size: 2.5rem; margin-bottom: 10px;">Welcome to Tech Service Support</h1>
    <p style="font-size: 1.2rem; opacity: 0.9;">Professional Hardware & Software Solutions for your devices</p>
    <?php if(!isset($_SESSION['user_id'])): ?>
        <br>
        <a href="register.php" class="button" style="background: white; color: #2c3e50;">Get Started</a>
        <a href="login.php" class="button" style="background: transparent; border: 2px solid white;">Login</a>
        <a href="contact.php" class="button" style="background: transparent; border: 2px solid white;">Contact Us</a>
    <?php else: ?>
        <br>
        <a href="contact.php" class="button" style="background: transparent; border: 2px solid white;">Contact Us</a>
    <?php endif; ?>
</div>

<div class="grid-2">
    <div class="card">
        <h3>Hardware Support</h3>
        <p>Expert technicians for laptop repairs, screen replacements, battery issues, and component upgrades. Most reliable service for all major brands.</p>
        <div style="margin-top: 20px; color: var(--secondary-color); font-weight: bold;">&#10003; Screen Replacement</div>
        <div style="color: var(--secondary-color); font-weight: bold;">&#10003; Motherboard Repair</div>
        <div style="color: var(--secondary-color); font-weight: bold;">&#10003; Battery & Charging</div>
    </div>

    <div class="card">
        <h3>Software Support</h3>
        <p>Get instant help with OS installation, virus removal, driver updates, and software troubleshooting. Remote and onsite support available.</p>
        <div style="margin-top: 20px; color: var(--accent-color); font-weight: bold;">&#10003; OS Installation</div>
        <div style="color: var(--accent-color); font-weight: bold;">&#10003; Virus Removal</div>
        <div style="color: var(--accent-color); font-weight: bold;">&#10003; Data Recovery</div>
    </div>
</div>

<?php include 'inc/footer.php'; ?>
