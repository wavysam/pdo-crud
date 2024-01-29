<?php
require "session.php";
require_once "dbconfig.php";
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

    <h1 class="text-4xl font-bold mb-6">Users Lists</h1>
    <a href="insert.php" class="btn btn-primary mb-6">Add new record</a>
    <a href="index.php" class="btn btn-primary mb-6">Login</a>
    <a href="register.php" class="btn btn-primary mb-6">Register</a>
    <a href="logout.php" class="btn btn-danger mb-6">Logout</a>

        <table class="table table-striped table-bordered">
            <thead>
                <th>Id</th>
                <th>Image</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Address</th>
                <th>Date Added</th>
                <th>Actions</th>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM users ORDER BY created_at DESC";
                $query = $connection->prepare($sql);
                $query->execute();
                $results = $query->fetchAll();
                ?>

                <?php foreach ($results as $result): ?>
                    <tr>
                        <td><?= htmlspecialchars($result->id) ?></td>
                        <td>
                            <img src="<?= $result->profileImage ? htmlspecialchars($result->profileImage):"images/placeholder.png" ?>" alt="" class="h-12 w-12 rounded-full object-cover">
                        </td>
                        <td><?= htmlspecialchars($result->first_name) ?></td>
                        <td><?= htmlspecialchars($result->last_name) ?></td>
                        <td><?= htmlspecialchars($result->address) ?></td>
                        <td><?= date("M d, Y h:i A", strtotime(htmlspecialchars($result->created_at))) ?></td>
                        <td>
                            <a href="<?= "upload.php?id=".$result->id ?>" class="btn btn-sm btn-success">
                                <i class="bi bi-image"></i>
                            </a>
                            <a href="<?= "update.php?id=" . $result->id ?>" class="btn btn-sm btn-primary mx-1">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <a href="<?= "delete.php?id=".$result->id ?>" class="btn btn-sm btn-danger">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>