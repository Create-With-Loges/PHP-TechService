<?php
require '../inc/db.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user') {
    header("Location: ../login.php");
    exit;
}
include '../inc/header.php';

$user_id = $_SESSION['user_id'];
$sql = "SELECT r.id, r.status, r.details, r.amount, r.payment_status, r.created_at, p.username as provider_name 
        FROM requests r 
        JOIN providers p ON r.provider_id = p.id 
        WHERE r.user_id = $user_id 
        ORDER BY r.created_at DESC";
$result = $conn->query($sql);
?>

<div class="card">
    <h2>My Support Requests (Tracking)</h2>
    <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Request ID</th>
                    <th>Provider</th>
                    <th>Details</th>
                    <th>Status</th>
                    <th>Amount ($)</th>
                    <th>Payment</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td>#<?php echo $row['id']; ?></td>
                        <td><?php echo $row['provider_name']; ?></td>
                        <td><?php echo nl2br($row['details']); ?></td>
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
                        <td><?php echo $row['amount'] > 0 ? $row['amount'] : 'Not set'; ?></td>
                        <td>
                            <?php if ($row['payment_status'] == 'Paid'): ?>
                                <span style="color: green; font-weight: bold;">Paid</span><br>
                                <a href="../receipt.php?id=<?php echo $row['id']; ?>" target="_blank" style="font-size: 12px; font-weight: bold; color: #1abc9c;">View Receipt</a>
                            <?php elseif ($row['amount'] > 0): ?>
                                <a href="payment.php?id=<?php echo $row['id']; ?>" class="button" style="padding: 5px 10px; font-size: 12px; background-color: #27ae60;">Pay Now</a>
                            <?php else: ?>
                                <span style="color: gray;">Pending Amount</span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo $row['created_at']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No requests found.</p>
    <?php endif; ?>
    <br><br>
    <a href="dashboard.php" class="button btn-back">&larr; Back to Dashboard</a>
</div>

<?php include '../inc/footer.php'; ?>
