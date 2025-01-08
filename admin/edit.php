<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include '../config/db.php';

$id = $_GET['id'];
$sql = "SELECT * FROM destinations WHERE id = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();
$destination = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $image = $_FILES['image']['name'] ?? $destination['image'];
    $image_tmp = $_FILES['image']['tmp_name'];
    $image_path = "../images/" . $image;

    if (!empty($image_tmp)) {
        move_uploaded_file($image_tmp, $image_path);
    }

    $sql = "UPDATE destinations SET name = :name, description = :description, image = :image WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':image', $image);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Destination</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
</head>
<body>

<div class="container">
    <h2 class="my-4">Edit Destination</h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Destination Name</label>
            <input type="text" class="form-control" name="name" value="<?php echo $destination['name']; ?>" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" name="description" rows="5" required><?php echo $destination['description']; ?></textarea>
        </div>
        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" class="form-control" name="image">
            <img src="../images/<?php echo $destination['image']; ?>" alt="Image" width="100">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
<script src="../assets/bootstrap/js/jquery-3.3.1.min.js"></script>
<script src="../assets/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
