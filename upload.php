<?php
require_once "dbconfig.php";

if (isset($_REQUEST["upload"]))
{
    $id = $_GET["id"];
    $file_name = $_FILES["profile_image"]["name"];
    $tmp_name = $_FILES["profile_image"]["tmp_name"];
    $file_size = $_FILES["profile_image"]["size"];
    $directory = "images/" . $file_name;

    if ($file_size < 5242880)
    {
        $sql = "UPDATE users SET profileImage = :profileImage WHERE id = :id";
        $query = $connection->prepare($sql);
        $query->bindParam("profileImage", $directory, PDO::PARAM_STR);
        $query->bindParam("id", $id, PDO::PARAM_INT);
        $query->execute();
        $count = $query->rowCount();

        if (move_uploaded_file($tmp_name, $directory) && $count > 0)
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
</head>
<body>
    <div class="container">
        <h1 class="text-4xl font-bold mb-6">Upload Profile Image</h1>

        <form method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="profile_image">Profile Image</label>
                <input type="file" name="profile_image" id="profile_image" class="form-control">
            </div>
            
            <a href="dashboard.php" class="btn btn-danger">Cancel</a>
            <button name="upload" class="btn btn-success">Upload</button>
        </form>
    </div>
</body>
</html>