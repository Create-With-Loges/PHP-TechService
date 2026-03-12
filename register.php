<?php
require 'inc/db.php';

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $contact = $_POST['contact'];

    if ($password != $confirm_password) {
        $error = "Passwords do not match!";
    } else {
        if ($role == 'user') {
            $model = $_POST['model'];
            $company = $_POST['company'];
            
            $stmt = $conn->prepare("INSERT INTO users (username, password, email, contact, model, company) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $username, $password, $email, $contact, $model, $company);
        
        } elseif ($role == 'provider') {
            $shop_reg_num = $_POST['shop_reg_num'];
            $prof_link = $_POST['prof_link'];
            $service_type = $_POST['service_type'];
            $short_info = $_POST['short_info'];
            
            $stmt = $conn->prepare("INSERT INTO providers (username, password, email, contact, shop_reg_num, prof_link, service_type, short_info) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssss", $username, $password, $email, $contact, $shop_reg_num, $prof_link, $service_type, $short_info);
        }

        if (isset($stmt) && $stmt->execute()) {
            header("Location: login.php");
            exit;
        } else {
            $error = "Error: " . $conn->error;
        }
        if(isset($stmt)) $stmt->close();
    }
}
?>

<?php include 'inc/header.php'; ?>
<div class="card">
    <h2>Registration</h2>
    <?php if(isset($error)): ?>
        <p style="color:red;"><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="POST" action="register.php">
        <label>Role</label>
        <select name="role" id="roleSelect" onchange="toggleFields()">
            <option value="user">User</option>
            <option value="provider">Service Provider</option>
        </select>

        <label>Username</label>
        <input type="text" name="username" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <label>Confirm Password</label>
        <input type="password" name="confirm_password" required>

        <label>Email</label>
        <input type="email" name="email" required>
        
        <label>Contact Number</label>
        <input type="text" name="contact" required>

        <!-- User Fields -->
        <div id="userFields">
            <label>Laptop/PC Model</label>
            <input type="text" name="model">

            <label>Company</label>
            <input type="text" name="company">
        </div>

        <!-- Provider Fields -->
        <div id="providerFields" style="display:none;">
            <label>Shop Registration Number (if any)</label>
            <input type="text" name="shop_reg_num">

            <label>Freelancer Profile Link (if any)</label>
            <input type="text" name="prof_link">

            <label>Service Type</label>
            <select name="service_type">
                <option value="Hardware">Hardware</option>
                <option value="Software">Software</option>
                <option value="Both">Both</option>
            </select>

            <label>Short Info</label>
            <textarea name="short_info" rows="4"></textarea>
        </div>

        <button type="submit" name="submit" class="button">Register</button>
    </form>
</div>

<script>
function toggleFields() {
    var role = document.getElementById('roleSelect').value;
    var userFields = document.getElementById('userFields');
    var providerFields = document.getElementById('providerFields');

    if (role === 'user') {
        userFields.style.display = 'block';
        providerFields.style.display = 'none';
    } else {
        userFields.style.display = 'none';
        providerFields.style.display = 'block';
    }
}
</script>

<?php include 'inc/footer.php'; ?>
