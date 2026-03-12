<?php
require '../inc/db.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user') {
    header("Location: ../login.php");
    exit;
}

if (isset($_POST['submit'])) {
    $provider_id = $_POST['provider_id'];
    $details = $_POST['details'];
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO requests (user_id, provider_id, details) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $user_id, $provider_id, $details);

    if ($stmt->execute()) {
        header("Location: track.php");
        exit;
    } else {
        $error = "Error: " . $stmt->error;
    }
}

$provider_id = isset($_GET['provider_id']) ? $_GET['provider_id'] : 0;
// Fetch provider name
$app_stmt = $conn->prepare("SELECT username FROM providers WHERE id = ?");
$app_stmt->bind_param("i", $provider_id);
$app_stmt->execute();
$res = $app_stmt->get_result();
$provider = $res->fetch_assoc();


// Fetch user details for default value
$user_id = $_SESSION['user_id'];
$u_stmt = $conn->prepare("SELECT model, company FROM users WHERE id = ?");
$u_stmt->bind_param("i", $user_id);
$u_stmt->execute();
$u_res = $u_stmt->get_result();
$user_data = $u_res->fetch_assoc();

include '../inc/header.php';
?>

<div class="card">
    <h2>Request Support from <?php echo $provider ? $provider['username'] : 'Unknown'; ?></h2>
    <?php if(isset($error)): ?>
        <p style="color:red;"><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="POST" action="request.php">
        <input type="hidden" name="provider_id" value="<?php echo $provider_id; ?>">
        
        <label>My Laptop/PC Details (From Profile)</label>
        <p><strong>Model:</strong> <?php echo $user_data['model']; ?> | <strong>Company:</strong> <?php echo $user_data['company']; ?></p>

        <label>Issue Details / Description</label>
        <textarea name="details" rows="5" required>Model: <?php echo $user_data['model']; ?>

Description of issue: </textarea>

        <button type="submit" name="submit" class="button">Submit Request</button>
    </form>
    <br>
    <a href="providers.php" class="button btn-back">&larr; Back to Providers</a>
</div>

<?php include '../inc/footer.php'; ?>
