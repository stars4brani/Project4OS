<?php
$servername = "localhost";
$username = "root";
$password = "369girlsdr1nk";
$database = "bookstore";

session_start();

// Use PDO
try {
    $connection = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Redirect to login if not logged in
if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit();
}

$message = "";

// Handle new order
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $book_id = $_POST['book_id'];
    $quantity = $_POST['quantity'];
    $customer_id = $_SESSION['customer_id'];
    $date = date('Y-m-d');

    // Check stock with PDO
    $stmt = $connection->prepare("SELECT stock FROM Books WHERE book_id = ?");
    $stmt->execute([$book_id]);
    $stock_check = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($stock_check && $stock_check['stock'] >= $quantity) {
        // Insert order
        $stmt = $connection->prepare("INSERT INTO Orders (customer_id, book_id, order_date, quantity) VALUES (?, ?, ?, ?)");
        $stmt->execute([$customer_id, $book_id, $date, $quantity]);

        // Update stock
        $stmt = $connection->prepare("UPDATE Books SET stock = stock - ? WHERE book_id = ?");
        $stmt->execute([$quantity, $book_id]);

        $message = "Order placed successfully!";
    } else {
        $message = "Not enough stock.";
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>Dashboard</title></head>
<body>
    <h1>Welcome, <?= htmlspecialchars($_SESSION['name']) ?></h1>
    <a href="logout.php">Logout</a>

    <h2>Place Order</h2>
    <?php if (!empty($message)) echo "<p>$message</p>"; ?>

    <form method="POST">
        <label>Choose Book:</label>
        <select name="book_id">
            <?php
            $stmt = $connection->query("SELECT * FROM Books");
            while ($book = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='{$book['book_id']}'>" . htmlspecialchars($book['title']) . " - \$" . htmlspecialchars($book['price']) . "</option>";
            }
            ?>
        </select><br>
        Quantity: <input type="number" name="quantity" value="1" min="1"><br>
        <button type="submit">Order</button>
    </form>

    <h2>My Orders</h2>
    <table>
        <tr><th>Book</th><th>Quantity</th><th>Date</th></tr>
        <?php
        $cid = $_SESSION['customer_id'];
        $stmt = $connection->prepare("SELECT title, quantity, order_date FROM Orders JOIN Books ON Orders.book_id = Books.book_id WHERE customer_id = ?");
        $stmt->execute([$cid]);
        while ($order = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr><td>" . htmlspecialchars($order['title']) . "</td><td>" . htmlspecialchars($order['quantity']) . "</td><td>" . htmlspecialchars($order['order_date']) . "</td></tr>";
        }
        ?>
    </table>
</body>
</html>
