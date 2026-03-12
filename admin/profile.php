<?php
require '../inc/db.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$msg = "";

if (isset($_POST['update'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("UPDATE admins SET email=?, password=? WHERE id=?");
    $stmt->bind_param("ssi", $email, $password, $user_id);
    
    if ($stmt->execute()) {
        $msg = "Profile updated successfully!";
    } else {
        $msg = "Error updating profile: " . $conn->error;
    }
}

// Fetch current data
$stmt = $conn->prepare("SELECT * FROM admins WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$res = $stmt->get_result();
$user = $res->fetch_assoc();

include '../inc/header.php';
?>

<div class="card">
    <h2>Update Admin Profile</h2>
    <?php if($msg): ?>
        <p style="color:green;"><?php echo $msg; ?></p>
    <?php endif; ?>
    <form method="POST" action="profile.php">
        <label>Email</label>
        <input type="email" name="email" value="<?php echo $user['email']; ?>" required>

        <label>Password (Plain Text)</label>
        <input type="text" name="password" value="<?php echo $user['password']; ?>" required>

        <button type="submit" name="update" class="button">Update Profile</button>
    </form>
    <br>
    <a href="dashboard.php" class="button btn-back">&larr; Back to Dashboard</a>
</div>

<?php include '../inc/footer.php'; ?>
