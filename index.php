<?php
include 'config/db.php';

// Menangani pencarian destinasi
$search = $_GET['search'] ?? '';

// Query destinasi
$sql = "SELECT * FROM destinations WHERE name LIKE :search ORDER BY name";
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
    <title>Travel Destinations</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">Travel Destinations</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="admin/login.php">Admin</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Search Form -->
<div class="container mt-4">
    <form action="index.php" method="GET">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search destinations" value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </form>
</div>

<!-- Destinations List -->
<div class="container mt-4">
    <h2>Destinations</h2>
    <div class="row">
        <?php foreach ($destinations as $destination): ?>
        <div class="col-md-4 mb-4">
            <div class="card">
                <img src="images/<?php echo $destination['image']; ?>" class="card-img-top" alt="<?php echo $destination['name']; ?>">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $destination['name']; ?></h5>
                    <p class="card-text"><?php echo substr($destination['description'], 0, 100) . '...'; ?></p>
                    <a href="view_detail.php?id=<?php echo $destination['id']; ?>" class="btn btn-primary">View Details</a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?php include 'footer.php'; ?>
<script src="assets/bootstrap/js/jquery-3.3.1.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
