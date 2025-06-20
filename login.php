<?php
$servername = "localhost";
$username = "root";
$dbpassword = "369girlsdr1nk"; // <-- Renamed to avoid confusion
$database = "bookstore";

session_start();

try {
    $connection = new PDO("mysql:host=$servername;dbname=$database", $username, $dbpassword);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if (isset($_POST['submit'])) {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? ''; // <-- get password from the form

    $stmt = $connection->prepare("SELECT * FROM customers WHERE email = ?"); 
    $stmt->execute([$email]); 
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['customer_id'] = $user['customer_id'];
            $_SESSION['name'] = $user['name'];
            header("Location: start.php");
            exit;
        } else {
            $error = "Invalid email or password.";
        }
    } else {
        $error = "Invalid email or password.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Логин</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: rgb(240, 240, 240);">
    <br><br>
    <h2 style="text-align: center">Логин</h2><br><br>

    <form method="POST">
        <div class="register_form" style="margin-left: 2%;">
        <div class="col-sm-5" style="background-color: rgb(250, 250, 250); padding: 2% 0% 1% 0%; margin-left: auto; margin-right: auto">
            
            <?php if (isset($error)) : ?>
                <div class="alert alert-danger" style="margin: 0 3% 10px 3%;"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <div class="row mb-3" style="margin-left: 3%">    
            <label>Имейл:</label><br>
                <div class="col-sm-10">
                    <input type="text" name="email" class="form-control" required><br>
                </div>
            </div>

            <div class="row mb-3" style="margin-left: 3%">  
            <label>Парола:</label><br>
                <div class="col-sm-10">
                    <input type="password" name="password" class="form-control" required>
                </div>
            </div>
            <input type="submit" name="submit" value="Вход" class="btn btn-primary" style="margin-left: 5%"><br><br>
        </div>
        </div>
    </form>
</body>
</html>
