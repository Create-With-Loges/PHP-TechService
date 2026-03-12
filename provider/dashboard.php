<?php
require '../inc/db.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'provider') {
    header("Location: ../login.php");
    exit;
}
include '../inc/header.php';
?>

<div class="card">
    <h2>Provider Dashboard</h2>
    <p>Welcome, <strong><?php echo $_SESSION['username']; ?></strong></p>
    <ul class="dashboard-menu">
        <li><a href="requests.php">Manage Support Requests</a></li>
        <li><a href="profile.php">Update Service Details / Profile</a></li>
    </ul>
</div>

<?php include '../inc/footer.php'; ?>
