<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tech Support | Efficient Service</title>
    <link rel="stylesheet" href="/ts/css/style.css">
</head>
<?php
// Determine Theme based on directory or filename
$current_dir = basename(dirname($_SERVER['PHP_SELF'])); // e.g., 'user', 'provider', 'admin', 'ts'
$current_file = basename($_SERVER['PHP_SELF']);

$theme_class = 'theme-home'; // Default
if ($current_dir == 'user') {
    $theme_class = 'theme-user';
} elseif ($current_dir == 'provider') {
    $theme_class = 'theme-provider';
} elseif ($current_dir == 'admin') {
    $theme_class = 'theme-admin';
} elseif ($current_file == 'login.php' || $current_file == 'register.php') {
    $theme_class = 'theme-auth';
} elseif ($current_file == 'contact.php') {
    $theme_class = 'theme-contact';
}
?>
<body class="<?php echo $theme_class; ?>">
    <header>
        <div class="container">
            <div id="branding">
                <h1><span class="highlight">Tech</span> Support</h1>
            </div>
            <nav>
                <ul>
                    <li><a href="/ts/index.php">Home</a></li>
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <?php if($_SESSION['role'] == 'user'): ?>
                            <li><a href="/ts/user/dashboard.php">Dashboard</a></li>
                        <?php elseif($_SESSION['role'] == 'provider'): ?>
                            <li><a href="/ts/provider/dashboard.php">Dashboard</a></li>
                         <?php elseif($_SESSION['role'] == 'admin'): ?>
                            <li><a href="/ts/admin/dashboard.php">Dashboard</a></li>
                        <?php endif; ?>
                        <li><a href="/ts/logout.php">Logout</a></li>
                    <?php else: ?>
                        <li><a href="/ts/login.php">Login</a></li>
                        <li><a href="/ts/register.php">Register</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>
    <div class="container">
