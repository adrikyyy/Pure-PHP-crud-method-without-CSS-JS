<?php
session_start(); // Start the session

// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "web_sekolah";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check for connection error
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle clearing session data
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['clear'])) {
    unset($_SESSION['participants']);
    echo "<p>Data sesi telah dihapus.</p>";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa</title>
</head>
<body>
    <h1>Data Siswa</h1>

    <?php if (isset($_SESSION['participants']) && count($_SESSION['participants']) > 0): ?>
        <table border="1" cellpadding="10">
            <tr>
                <th>Nama</th>
                <th>Daerah</th>
                <th>Telepon</th>
            </tr>
            <?php foreach ($_SESSION['participants'] as $participant): ?>
                <tr>
                    <td><?php echo htmlspecialchars($participant['name']); ?></td>
                    <td><?php echo htmlspecialchars($participant['district']); ?></td>
                    <td><?php echo htmlspecialchars($participant['phone']); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>Tidak ada peserta terdaftar.</p>
    <?php endif; ?>

    <form method="post">
        <button type="submit" name="clear">Clear Data</button>
    </form>

</body>
<a href="index.php">Kembali</a>
</html>
