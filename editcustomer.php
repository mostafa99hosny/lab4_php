<?php
session_start();
require_once 'config.php';
require_once 'businesslogic.php';
require_once 'database.php';

if (!isset($_SESSION['logged_in'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'] ?? null;
if (!$id) {
    die("Invalid customer ID.");
}

$customer = select('customer', ['*'], 'id = ?', [$id]);
if (!$customer) {
    die("Customer not found.");
}
$customer = $customer[0]; 

$rooms = getAllRooms();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Customer</title>
    <link rel="stylesheet" href="style.css"> 
</head>
<body>
    <?php include_once 'nav.php'; ?>
    <div class="content">
        <h2>Edit Customer</h2>
        <form action="updatecustomer.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $customer['id']; ?>">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($customer['name']); ?>" required><br><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($customer['email']); ?>" required><br><br>

            <label for="profile_picture">Profile Picture:</label>
            <input type="file" id="profile_picture" name="profile_picture" accept="image/*"><br><br>

            <label for="room_id">Room:</label>
            <select id="room_id" name="room_id">
                <?php foreach ($rooms as $room): ?>
                    <option value="<?php echo $room['id']; ?>" <?php echo $room['id'] == $customer['room_id'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($room['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select><br><br>

            <input type="submit" value="Update">
            <input type="button" value="Cancel" onclick="window.location.href='listcustomer.php'">
        </form>
    </div>
    <?php include_once 'footer.php'; ?>
</body>
</html>