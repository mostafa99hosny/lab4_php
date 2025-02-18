<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once 'config.php';
require_once 'businesslogic.php';
require_once 'database.php';

if (!isset($_SESSION['logged_in'])) {
    header("Location: index.php");
    exit();
}

if (isset($_GET['delete_id'])) {
    $deleteId = $_GET['delete_id'];
    delete('customer', 'id = ?', [$deleteId]);
    header("Location: listcustomer.php");
    exit();
}

$sql = "SELECT customer.id, customer.name, customer.email, customer.profile_picture, room.name AS room_name 
        FROM customer 
        LEFT JOIN room ON customer.room_id = room.id";
$stmt = $pdo->query($sql);
$customers = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Users</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include_once 'nav.php'; ?>
    <div style="padding: 20px;">
        <h2 style="margin: 15px;">Registered Users</h2>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Room</th>
                    <th>Profile Picture</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($customers as $customer): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($customer['name']); ?></td>
                        <td><?php echo htmlspecialchars($customer['email']); ?></td>
                        <td><?php echo htmlspecialchars($customer['room_name'] ?? 'No Room'); ?></td>
                        <td>
                            <img src="<?php echo htmlspecialchars($customer['profile_picture']); ?>" alt="Profile Picture">
                        </td>
                        <td class="action-buttons">
                            <a href="editcustomer.php?id=<?php echo $customer['id']; ?>">
                                <button>Update</button>
                            </a>
                            <button onclick="deleteCustomer(<?php echo $customer['id']; ?>)">Delete</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php include_once 'footer.php'; ?>

    <script>
        function deleteCustomer(id) {
            if (confirm("Are you sure you want to delete this customer?")) {
                window.location.href = `listcustomer.php?delete_id=${id}`;
            }
        }
    </script>
</body>
</html>