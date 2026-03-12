<?php
require '../inc/db.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}
include '../inc/header.php';

// List all requests with user and provider info
$sql = "SELECT r.id, r.status, r.created_at, 
        u.username as user_name, u.contact as user_contact,
        p.username as provider_name, p.contact as provider_contact
        FROM requests r 
        JOIN users u ON r.user_id = u.id 
        JOIN providers p ON r.provider_id = p.id 
        ORDER BY r.created_at DESC";
$result = $conn->query($sql);
?>

<div class="card">
    <h2>Review Support Contacts</h2>
    <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Req ID</th>
                    <th>User (Contact)</th>
                    <th>Provider (Contact)</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td>#<?php echo $row['id']; ?></td>
                        <td><?php echo $row['user_name']; ?> <br><small><?php echo $row['user_contact']; ?></small></td>
                        <td><?php echo $row['provider_name']; ?> <br><small><?php echo $row['provider_contact']; ?></small></td>
                        <td>
                             <?php 
                                $statusClass = '';
                                if($row['status'] == 'Pending') $statusClass = 'status-pending';
                                elseif($row['status'] == 'Accepted') $statusClass = 'status-accepted';
                                elseif($row['status'] == 'In Progress') $statusClass = 'status-progress';
                                elseif($row['status'] == 'Completed') $statusClass = 'status-completed';
                                elseif($row['status'] == 'Rejected') $statusClass = 'status-rejected';
                            ?>
                            <span class="status-badge <?php echo $statusClass; ?>"><?php echo $row['status']; ?></span>
                        </td>
                        <td><?php echo $row['created_at']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No support contacts found.</p>
    <?php endif; ?>
    <br><br>
    <a href="dashboard.php" class="button btn-back">&larr; Back to Dashboard</a>
</div>

<?php include '../inc/footer.php'; ?>
