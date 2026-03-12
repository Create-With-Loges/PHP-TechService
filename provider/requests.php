<?php
require '../inc/db.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'provider') {
    header("Location: ../login.php");
    exit;
}

$provider_id = $_SESSION['user_id'];

// Handle Status Update
if (isset($_POST['update_status'])) {
    $request_id = $_POST['request_id'];
    $status = $_POST['status'];
    $amount = isset($_POST['amount']) ? floatval($_POST['amount']) : 0;
    
    $stmt = $conn->prepare("UPDATE requests SET status = ?, amount = ? WHERE id = ? AND provider_id = ?");
    $stmt->bind_param("sdii", $status, $amount, $request_id, $provider_id);
    $stmt->execute();
}

include '../inc/header.php';

// Fetch requests assigned to this provider
$sql = "SELECT r.id, r.details, r.status, r.amount, r.payment_status, r.created_at, u.username as user_name, u.contact, u.model, u.company 
        FROM requests r 
        JOIN users u ON r.user_id = u.id 
        WHERE r.provider_id = $provider_id 
        ORDER BY r.created_at DESC";
$result = $conn->query($sql);
?>

<div class="card">
    <h2>Incoming Support Requests</h2>
    <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Laptop Details</th>
                    <th>Issue</th>
                    <th>Contact</th>
                    <th>Status</th>
                    <th>Amount ($)</th>
                    <th>Payment</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td>#<?php echo $row['id']; ?></td>
                        <td><?php echo $row['user_name']; ?></td>
                        <td><?php echo $row['model'] . ' (' . $row['company'] . ')'; ?></td>
                        <td><?php echo nl2br($row['details']); ?></td>
                        <td><?php echo $row['contact']; ?></td>
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
                        <td>
                            <?php if($row['payment_status']=='Paid'): ?>
                                <?php echo $row['amount']; ?>
                            <?php else: ?>
                                <input type="number" name="amount" form="form_<?php echo $row['id']; ?>" step="0.01" min="0" value="<?php echo $row['amount']; ?>" style="width: 70px; padding: 5px;">
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($row['payment_status'] == 'Paid'): ?>
                                <span style="color: green; font-weight: bold;">Paid</span><br>
                                <a href="../receipt.php?id=<?php echo $row['id']; ?>" target="_blank" style="font-size: 12px; font-weight: bold; color: #1abc9c;">View Receipt</a>
                            <?php else: ?>
                                <span style="color: orange; font-weight: bold;">Pending</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <form id="form_<?php echo $row['id']; ?>" method="POST" action="requests.php" style="display:flex; gap: 5px; align-items: center;">
                                <input type="hidden" name="request_id" value="<?php echo $row['id']; ?>">
                                <select name="status" style="padding: 5px;">
                                    <option value="Pending" <?php if($row['status']=='Pending') echo 'selected'; ?>>Pending</option>
                                    <option value="Accepted" <?php if($row['status']=='Accepted') echo 'selected'; ?>>Accepted</option>
                                    <option value="In Progress" <?php if($row['status']=='In Progress') echo 'selected'; ?>>In Progress</option>
                                    <option value="Completed" <?php if($row['status']=='Completed') echo 'selected'; ?>>Completed</option>
                                    <option value="Rejected" <?php if($row['status']=='Rejected') echo 'selected'; ?>>Rejected</option>
                                </select>
                                <?php if($row['payment_status'] != 'Paid'): ?>
                                    <button type="submit" name="update_status" class="button" style="padding: 5px; font-size: 12px; height: auto;">Update</button>
                                <?php endif; ?>
                            </form>
                        </td>
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
