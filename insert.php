<?php

require_once "dbconfig.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $address = $_POST["address"];

    if (empty($first_name) || empty($last_name) || empty($address)) {
        $error_msg = "All fields are required!";
    } else {
        $sql = "INSERT INTO users (first_name, last_name, address) VALUES (:first_name, :last_name, :address)";
        $query = $connection->prepare($sql);
        $query->bindParam("first_name", $first_name, PDO::PARAM_STR);
        $query->bindParam("last_name", $last_name, PDO::PARAM_STR);
        $query->bindParam("address", $address, PDO::PARAM_STR);
        $query->execute();
        $count = $query->rowCount();

        if ($count > 0)
        {
            header("Location: dashboard.php");
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDO CRUD</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.1/font/bootstrap-icons.min.css"/>
</head>
<body>
    <div class="container">
        <h1 class="text-4xl font-bold mb-6">Create New Record</h1>

        <form method="post">
            <div class="mb-3">
                <label for="first_name">First Name <span class="text-red-500">*</span></label>
                <input type="text" name="first_name" id="first_name" class="form-control">
            </div>
            <div class="mb-3">
                <label for="last_name">Last Name <span class="text-red-500">*</span></label>
                <input type="text" name="last_name" id="last_name" class="form-control">
            </div>
            <div class="mb-3">
                <label for="address">Address <span class="text-red-500">*</span></label>
                <input type="text" name="address" id="address" class="form-control">
            </div>

            <?php
            if (isset($error_msg))
            {
                echo "<div class='alert alert-danger'>$error_msg</div>";
            }
            ?>

            <a href="dashboard.php" class="btn btn-danger">Cancel</a>
            <button class="btn btn-success">Insert</button>
        </form>
    </div>
</body>
</html>