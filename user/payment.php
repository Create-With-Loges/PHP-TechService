<?php
require '../inc/db.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user') {
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$request_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$error = '';
$success = '';

// Verify request belongs to this user and is unpaid
$sql = "SELECT * FROM requests WHERE id = $request_id AND user_id = $user_id";
$result = $conn->query($sql);
if ($result->num_rows == 0) {
    die("Invalid request or you don't have permission to access it.");
}
$request = $result->fetch_assoc();

if ($request['payment_status'] == 'Paid') {
    header("Location: track.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $card_name = $_POST['card_name'];
    $card_number = $_POST['card_number'];
    $expiry = $_POST['expiry'];
    $cvv = $_POST['cvv'];

    if (empty($card_name) || empty($card_number) || empty($expiry) || empty($cvv)) {
        $error = "All fields are required.";
    } elseif (strlen(str_replace(' ', '', $card_number)) < 16) {
        $error = "Invalid Card Number.";
    } else {
        // Dummy processing
        $stmt = $conn->prepare("UPDATE requests SET payment_status = 'Paid' WHERE id = ?");
        $stmt->bind_param("i", $request_id);
        if ($stmt->execute()) {
            $success = "Payment Successful! Redirecting...";
            echo "<script>setTimeout(function(){ window.location.href = 'track.php'; }, 2000);</script>";
        } else {
            $error = "Payment failed. Please try again.";
        }
    }
}

include '../inc/header.php';
?>

<div class="card" style="max-width: 500px; margin: auto;">
    <h2>Secure Payment</h2>
    <p><strong>Request ID:</strong> #<?php echo $request['id']; ?></p>
    <p><strong>Amount Due:</strong> $<?php echo $request['amount']; ?></p>
    
    <?php if ($error): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>
    <?php if ($success): ?>
        <p class="success"><?php echo $success; ?></p>
    <?php else: ?>
        <form method="POST" action="">
            <div class="form-group">
                <label>Name on Card</label>
                <input type="text" name="card_name" placeholder="John Doe" required>
            </div>
            <div class="form-group">
                <label>Card Number</label>
                <input type="text" name="card_number" placeholder="1234 5678 9101 1121" required>
            </div>
            <div style="display: flex; gap: 10px;">
                <div class="form-group" style="flex: 1;">
                    <label>Expiry Date</label>
                    <input type="text" name="expiry" placeholder="MM/YY" required>
                </div>
                <div class="form-group" style="flex: 1;">
                    <label>CVV</label>
                    <input type="password" name="cvv" placeholder="123" required>
                </div>
            </div>
            <button type="submit" class="button" style="width: 100%; background-color: #27ae60;">Pay Now</button>
        </form>
    <?php endif; ?>
    <br>
    <a href="track.php" class="button btn-back">&larr; Cancel</a>
</div>

<?php include '../inc/footer.php'; ?>
