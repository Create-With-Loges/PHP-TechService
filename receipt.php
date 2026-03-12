<?php
session_start();
require 'inc/db.php';

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized Access.");
}

$request_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];

// Fetch receipt details
$sql = "SELECT r.*, 
               u.username as user_name, u.email as user_email, u.contact as user_contact, u.model, u.company,
               p.username as provider_name, p.shop_reg_num, p.contact as provider_contact
        FROM requests r
        JOIN users u ON r.user_id = u.id
        JOIN providers p ON r.provider_id = p.id
        WHERE r.id = $request_id AND r.payment_status = 'Paid'";

// Basic security check: user can only see their own, provider can only see their own, admin can see all
if ($role == 'user') {
    $sql .= " AND r.user_id = $user_id";
} elseif ($role == 'provider') {
    $sql .= " AND r.provider_id = $user_id";
}

$result = $conn->query($sql);
if ($result->num_rows == 0) {
    die("Receipt not found or you don't have permission.");
}
$receipt = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Receipt #<?php echo $receipt['id']; ?></title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f7f6; color: #333; margin: 0; padding: 20px; }
        .receipt-container { max-width: 600px; margin: 0 auto; background: #fff; padding: 20px 40px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .header { text-align: center; border-bottom: 2px solid #ddd; padding-bottom: 20px; margin-bottom: 20px; }
        .header h1 { margin: 0; color: #2c3e50; }
        .details-section { display: flex; justify-content: space-between; margin-bottom: 20px; }
        .details-col { width: 48%; }
        .details-col h3 { border-bottom: 1px solid #ddd; padding-bottom: 5px; color: #34495e; }
        .service-details { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .service-details th, .service-details td { padding: 10px; border: 1px solid #ddd; text-align: left; }
        .service-details th { background-color: #f8f9fa; }
        .total-row { font-weight: bold; font-size: 1.2em; text-align: right; }
        .footer { text-align: center; margin-top: 30px; font-size: 0.9em; color: #7f8c8d; }
        .print-btn { display: block; width: 150px; margin: 20px auto; padding: 10px; text-align: center; background: #3498db; color: #fff; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; }
        @media print {
            .print-btn { display: none; }
            body { background: #fff; margin: 0; padding: 0; }
            .receipt-container { box-shadow: none; max-width: 100%; border-radius: 0; }
        }
    </style>
</head>
<body>
    <div class="receipt-container">
        <div class="header">
            <h1>TechService Receipt</h1>
            <p>Receipt Number: #INV-<?php echo str_pad($receipt['id'], 6, '0', STR_PAD_LEFT); ?></p>
            <p>Date: <?php echo date('F j, Y, g:i a', strtotime($receipt['created_at'])); ?></p>
        </div>

        <div class="details-section">
            <div class="details-col">
                <h3>Billed To</h3>
                <p><strong><?php echo $receipt['user_name']; ?></strong><br>
                Contact: <?php echo $receipt['user_contact']; ?><br>
                Email: <?php echo $receipt['user_email']; ?></p>
            </div>
            <div class="details-col">
                <h3>Service Provider</h3>
                <p><strong><?php echo $receipt['provider_name']; ?></strong><br>
                Reg Num: <?php echo $receipt['shop_reg_num']; ?><br>
                Contact: <?php echo $receipt['provider_contact']; ?></p>
            </div>
        </div>

        <table class="service-details">
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Device</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo nl2br($receipt['details']); ?></td>
                    <td><?php echo $receipt['model'] . ' (' . $receipt['company'] . ')'; ?></td>
                    <td>$<?php echo number_format($receipt['amount'], 2); ?></td>
                </tr>
                <tr>
                    <td colspan="2" class="total-row">Total Paid</td>
                    <td class="total-row">$<?php echo number_format($receipt['amount'], 2); ?></td>
                </tr>
            </tbody>
        </table>

        <div class="footer">
            <p>Thank you for using TechService!</p>
            <p>Payment Status: <strong>PAID</strong></p>
        </div>
        
        <button class="print-btn" onclick="window.print()">Print Receipt</button>
    </div>
</body>
</html>
