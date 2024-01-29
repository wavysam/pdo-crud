<?php

require_once "dbconfig.php";

if (isset($_REQUEST["update"]))
{
    $id = $_GET["id"];
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $address= $_POST["address"];

    if (empty($first_name) || empty($last_name) || empty($address))
    {
        $error_msg = "All fields are required";
    } else {
        $sql = "UPDATE users SET first_name = :first_name, last_name = :last_name, address = :address WHERE id = :id";
        $query = $connection->prepare($sql);
        $query->bindParam("first_name", $first_name, PDO::PARAM_STR);
        $query->bindParam("last_name", $last_name, PDO::PARAM_STR);
        $query->bindParam("address", $address, PDO::PARAM_STR);
        $query->bindParam("id", $id, PDO::PARAM_INT);
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

        <?php
        $sql = "SELECT * FROM users WHERE id = ?";
        $query = $connection->prepare($sql);
        $query->execute(array($_GET["id"]));
        $result = $query->fetch(PDO::FETCH_OBJ);
        ?>

        <form method="post">
            <div class="mb-3">
                <label for="first_name">First Name <span class="text-red-500">*</span></label>
                <input 
                    type="text" 
                    name="first_name" i
                    d="first_name" 
                    value="<?= $result->first_name ?>" 
                    class="form-control"
                >
            </div>
            <div class="mb-3">
                <label for="last_name">Last Name <span class="text-red-500">*</span></label>
                <input 
                    type="text" 
                    name="last_name" 
                    id="last_name" 
                    value="<?= $result->last_name ?>"
                    class="form-control"
                >
            </div>
            <div class="mb-3">
                <label for="address">Address <span class="text-red-500">*</span></label>
                <input 
                    type="text" 
                    name="address" 
                    id="address" 
                    value="<?= $result->address ?>"
                    class="form-control"
                >
            </div>

            <?php
            if (isset($error_msg))
            {
                echo "<div class='alert alert-danger'>$error_msg</div>";
            }
            ?>

            <a href="dashboard.php" class="btn btn-danger">Cancel</a>
            <button class="btn btn-success" name="update">Update</button>
        </form>
    </div>
</body>
</html>