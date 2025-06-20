<?php 
$servername = "localhost";
$username = "root";
$password = "369girlsdr1nk";
$database = "bookstore";

session_start();
$connection = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Библиотека</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Връзка с CSS пакета на Bootstrap-->
  </head>
<body>
    <h1>Bookstore</h1>
        <a href="login.php">Login</a>
        <a href="profile.php">My Profile</a> |
        <a href="logout.php">Logout</a>
        <a href="register.php">Sign up</a>
    <h2 class="mb-4">Available Books</h2>

        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php
            $result = $connection->query("SELECT * FROM Books");
            foreach($result as $book):
            ?>
                <div class="col">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($book['title']) ?></h5>
                            <h6 class="card-subtitle mb-2 text-muted"><?= htmlspecialchars($book['author']) ?></h6>
                            <p class="card-text">
                                <strong>Price:</strong> $<?= number_format($book['price'], 2) ?><br>
                                <strong>In stock:</strong> <?= (int)$book['stock'] ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    
</body>
</html>