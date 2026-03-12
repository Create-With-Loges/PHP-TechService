<?php
require '../inc/db.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user') {
    header("Location: ../login.php");
    exit;
}
include '../inc/header.php';
?>

<div class="card">
    <h2>User Dashboard</h2>
    <p>Welcome, <strong><?php echo $_SESSION['username']; ?></strong></p>
    <ul class="dashboard-menu">
        <li><a href="providers.php">View Service Providers</a></li>
        <li><a href="track.php">Track My Requests</a></li>
        <li><a href="profile.php">Update Profile</a></li>
    </ul>
</div>

<?php include '../inc/footer.php'; ?>
