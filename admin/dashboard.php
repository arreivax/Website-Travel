<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../admin/login.php");
    exit();
}

include "../config/db.php";

// Menangani sorting dan pencarian
$search = $_GET['search'] ?? '';
$sort = $_GET['sort'] ?? 'name';

// Query destinasi
$sql = "SELECT * FROM destinations WHERE name LIKE :search ORDER BY $sort";
$stmt = $conn->prepare($sql);
$stmt->bindValue(':search', "%$search%");
$stmt->execute();
$destinations = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="dashboard.php">Admin Dashboard</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../index.php">Home</a>
                </li>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <h2>Welcome, Admin</h2>
    <!-- Form Search -->
    <form action="dashboard.php" method="GET" class="mb-3">
        <input type="text" name="search" class="form-control" placeholder="Search" value="<?php echo $search; ?>">
        <button type="submit" class="btn btn-primary">Search</button>
    </form>

    <div class="d-flex justify-content-end">
        <a href="create.php" class="btn btn-success mb-3">Add New Destination</a>
    </div>
    
    <!-- Sort Options -->
    <div class="d-flex justify-content-end mb-3">
        <a href="dashboard.php?sort=name" class="btn btn-primary">Sort by Name</a>
        <a href="dashboard.php?sort=created_at" class="btn btn-secondary ml-2">Sort by Date Created</a>
    </div>

    <!-- Daftar Destinasi -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Destination</th>
                <th>Description</th>
                <th>Image</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($destinations as $row): ?>
            <tr>
                <td><?php echo $row['name']; ?></td>
                <td width="600"><?php echo $row['description']; ?></td>
                <td><img src="../images/<?php echo $row['image']; ?>" alt="Image" width="120"></td>
                <td><?php echo $row['created_at']; ?></td>
                <td>
                    <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<br>
<?php include 'footer.php'; ?>
<script src="../assets/bootstrap/js/jquery-3.3.1.min.js"></script>
<script src="../assets/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
