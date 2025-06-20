<?php
$servername = "localhost";
$username = "root";
$password = "369girlsdr1nk";
$database = "bookstore";

$connection = new PDO("mysql:host=$servername;dbname=$database", $username, $password);

if ( isset( $_POST['submit'] ) ) {

    $name = $_POST['name'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $password = password_hash($password, PASSWORD_BCRYPT);

	$sql = "INSERT INTO customers (name, password, email, phone) VALUES (?,?,?,?)";
	$connection->prepare($sql)->execute([$name, $password, $email, $phone]);

    header("location: login.php");
} ?>

<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Регистация</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Връзка с CSS пакета на Bootstrap-->
  </head>
  <body style="background-color: rgb(240, 240, 240);">
    <br><br>
    <h2 style="text-align: center">Регистрация</h2>
    <br><br>
    <form method="post">
        <div class="register_form" style="margin-left: 2%;">
            <div class="col-sm-5" style="background-color: rgb(250, 250, 250); padding: 2% 0% 1% 0%; margin-left: auto; margin-right: auto">
                <div class="row mb-3" style="margin-left: 3%">
                    <label for="inputUSername" class="col-sm-3 col-form-label">Потребителско име:</label>
                    <div class="col-sm-8">
                        <input type="text" name="name" id="inputUSername" class="form-control">
                    </div>
                </div>
                <div class="row mb-3" style="margin-left: 3%">
                    <label for="inputPassword" class="col-sm-3 col-form-label">Парола:</label>
                    <div class="col-sm-8">
                        <input type="text" name="password" id="inputPassword" class="form-control">
                    </div>
                </div>
                <div class="row mb-3" style="margin-left: 3%">
                    <label for="inputEmail" class="col-sm-3 col-form-label">Имейл:</label>
                    <div class="col-sm-8">
                        <input type="text" name="email" id="inputEmail" class="form-control">
                    </div>
                </div>
                <div class="row mb-3" style="margin-left: 3%">
                    <label for="inputPhone" class="col-sm-3 col-form-label">Телефон:</label>
                    <div class="col-sm-8">
                        <input type="text" name="phone" id="inputPhone" class="form-control">
                    </div>
                </div>
                <br>
                <div class="row mb-3" style="margin-left: 3%">
                    <div class="col-sm-8">
                        <input type="submit" name="submit" value="Изпрати">
                    </div>
                </div>
            </div>
        </div>
    </form>
    <br><br>
  </body>
</html>