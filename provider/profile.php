<?php
require '../inc/db.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'provider') {
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$msg = "";

if (isset($_POST['update'])) {
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $shop_reg_num = $_POST['shop_reg_num'];
    $prof_link = $_POST['prof_link'];
    $service_type = $_POST['service_type'];
    $short_info = $_POST['short_info'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("UPDATE providers SET email=?, contact=?, shop_reg_num=?, prof_link=?, service_type=?, short_info=?, password=? WHERE id=?");
    $stmt->bind_param("sssssssi", $email, $contact, $shop_reg_num, $prof_link, $service_type, $short_info, $password, $user_id);
    
    if ($stmt->execute()) {
        $msg = "Profile updated successfully!";
    } else {
        $msg = "Error updating profile: " . $conn->error;
    }
}

// Fetch current data
$stmt = $conn->prepare("SELECT * FROM providers WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$res = $stmt->get_result();
$user = $res->fetch_assoc();

include '../inc/header.php';
?>

<div class="card">
    <h2>Update Profile / Service Details</h2>
    <?php if($msg): ?>
        <p style="color:green;"><?php echo $msg; ?></p>
    <?php endif; ?>
    <form method="POST" action="profile.php">
        <label>Email</label>
        <input type="email" name="email" value="<?php echo $user['email']; ?>" required>
        
        <label>Contact</label>
        <input type="text" name="contact" value="<?php echo $user['contact']; ?>" required>

        <label>Shop Reg Number</label>
        <input type="text" name="shop_reg_num" value="<?php echo $user['shop_reg_num']; ?>">
        
        <label>Profile Link</label>
        <input type="text" name="prof_link" value="<?php echo $user['prof_link']; ?>">

        <label>Service Type</label>
        <select name="service_type">
            <option value="Hardware" <?php if($user['service_type']=='Hardware') echo 'selected'; ?>>Hardware</option>
            <option value="Software" <?php if($user['service_type']=='Software') echo 'selected'; ?>>Software</option>
            <option value="Both" <?php if($user['service_type']=='Both') echo 'selected'; ?>>Both</option>
        </select>

        <label>Short Info</label>
        <textarea name="short_info" rows="4"><?php echo $user['short_info']; ?></textarea>

        <label>Password (Plain Text)</label>
        <input type="text" name="password" value="<?php echo $user['password']; ?>" required>

        <button type="submit" name="update" class="button">Update Profile</button>
    </form>
    <br>
    <a href="dashboard.php" class="button btn-back">&larr; Back to Dashboard</a>
</div>

<?php include '../inc/footer.php'; ?>
