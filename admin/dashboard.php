<?php
require '../inc/db.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}
include '../inc/header.php';
?>

<div class="card">
    <h2>Admin Dashboard</h2>
    <p>Welcome, <strong>Admin</strong>.</p>
    <ul class="dashboard-menu">
        <li><a href="review_contacts.php">Review Support Contacts / Requests</a></li>
        <li><a href="profile.php">Update Profile</a></li>
    </ul>
</div>

<?php include '../inc/footer.php'; ?>
