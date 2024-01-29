<?php
session_start();
$error_msg;
if (isset($_SESSION["username"])) {
    header("Location: dashboard.php");
    exit();
} else {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $username = $_POST["username"];
        $password = $_POST["password"];

        if (empty($username) || empty($password)) {
            $error_msg = "All fields are required!";
        } else {
            require_once "dbconfig.php";
            $sql = "SELECT * FROM admin WHERE username = :username";
            $stmt = $connection->prepare($sql);
            $stmt->bindParam("username", $username, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_OBJ);

            if ($result) {
                $error_msg = "Username taken!";
            } else {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $sql = "INSERT INTO admin (username, password) VALUES (:username, :password)";
                $stmt = $connection->prepare($sql);
                $stmt->bindParam("username", $username, PDO::PARAM_STR);
                $stmt->bindParam("password", $hashedPassword, PDO::PARAM_STR);
                $stmt->execute();
                $count = $stmt->rowCount();

                if ($count > 0) {
                    header("Location: index.php");
                    exit;
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDO Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css"/>
</head>
<body> 
    <div class="max-w-lg mx-auto">
        <h1 class="text-4xl font-bold mb-6">Register</h1>

        <form method="post">
            <div class="mb-3">
                <label for="username">Username</label>
                <input 
                    type="text" 
                    name="username" 
                    id="username" 
                    value="<?= htmlspecialchars($_POST["username"] ?? "") ?>"
                    class="form-control"
                >
            </div>
            <div class="mb-3">
                <label for="username">Password</label>
                <input 
                    type="password" 
                    name="password" 
                    id="password" 
                    value="<?= htmlspecialchars($_POST["password"] ?? "")?>"
                    class="form-control"
                >
            </div>

            <?php if (isset($error_msg)) : ?>
                <div class="alert alert-danger">
                    <?= $error_msg ?>
                </div>
            <?php endif; ?>

            <button class="btn btn-success w-full">Register</button>

            <p>Already have an account?
                <a href="index.php" class="text-blue-500">Login</a>
            </p>
        </form>
    </div>
</body>
</html>