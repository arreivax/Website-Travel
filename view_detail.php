<?php
include 'config/db.php';

// Ambil ID dari parameter URL
$id = $_GET['id'] ?? null;

if (!$id) {
    echo "Destination not found.";
    exit();
}

// Query untuk mendapatkan detail destinasi
$sql = "SELECT * FROM destinations WHERE id = :id";
$stmt = $conn->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$destination = $stmt->fetch();

if (!$destination) {
    echo "Destination not found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($destination['name']); ?></title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="index.php">Ready to have fun?</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
</nav>

<!-- Destination Detail -->
<div class="container mt-4">
    <div class="row">
        <div class="col-md-6">
            <img src="images/<?php echo $destination['image']; ?>" class="img-fluid" alt="<?php echo htmlspecialchars($destination['name']); ?>">
        </div>
        <div class="col-md-6">
            <h2><?php echo htmlspecialchars($destination['name']); ?></h2>
            <p><?php echo htmlspecialchars($destination['description']); ?></p>
            <p><strong>Created At:</strong> <?php echo date('d M Y', strtotime($destination['created_at'])); ?></p>
            <a href="index.php" class="btn btn-secondary">Back to Home</a>
        </div>
    </div>
</div>
<script src="assets/bootstrap/js/jquery-3.3.1.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
