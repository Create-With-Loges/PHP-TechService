<?php
require 'inc/db.php';

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $error = "Invalid username or password";

    // 1. Check Admin
    $stmt = $conn->prepare("SELECT id, username FROM admins WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = 'admin';
        header("Location: admin/dashboard.php");
        exit;
    }
    $stmt->close();

    // 2. Check Provider
    $stmt = $conn->prepare("SELECT id, username FROM providers WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = 'provider';
        header("Location: provider/dashboard.php");
        exit;
    }
    $stmt->close();

    // 3. Check User
    $stmt = $conn->prepare("SELECT id, username FROM users WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = 'user';
        header("Location: user/dashboard.php");
        exit;
    }
    $stmt->close();
}
?>

<?php include 'inc/header.php'; ?>
<div class="card" style="max-width: 400px; margin: auto;">
    <h2>Login</h2>
    <?php if(isset($error) && isset($_POST['submit'])): ?>
        <p style="color:red;"><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="POST" action="login.php">
        <label>Username</label>
        <input type="text" name="username" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <button type="submit" name="submit" class="button">Login</button>
    </form>
</div>
<?php include 'inc/footer.php'; ?>
