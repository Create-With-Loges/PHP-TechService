<?php
require '../inc/db.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user') {
    header("Location: ../login.php");
    exit;
}
include '../inc/header.php';

$sql = "SELECT id, username, service_type, short_info, shop_reg_num, prof_link, contact FROM providers";
$result = $conn->query($sql);
?>

<div class="card">
    <h2>Service Providers</h2>
    <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Provider</th>
                    <th>Service Type</th>
                    <th>Info</th>
                    <th>Contact</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['username']; ?></td>
                        <td><?php echo $row['service_type']; ?></td>
                        <td>
                            <?php echo $row['short_info']; ?><br>
                            <small>Reg: <?php echo $row['shop_reg_num']; ?></small><br>
                            <?php if($row['prof_link']): ?>
                                <a href="<?php echo $row['prof_link']; ?>" target="_blank">Profile Link</a>
                            <?php endif; ?>
                        </td>
                        <td><?php echo $row['contact']; ?></td>
                        <td>
                            <a href="request.php?provider_id=<?php echo $row['id']; ?>" class="button">Request Support</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No service providers found.</p>
    <?php endif; ?>
    <br><br>
    <a href="dashboard.php" class="button btn-back">&larr; Back to Dashboard</a>
</div>

<?php include '../inc/footer.php'; ?>
