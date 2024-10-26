<?php
session_start(); // Start the session

// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "web_sekolah";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = isset($_POST['name']) ? $_POST['name'] : null;
    $district = isset($_POST['district']) ? $_POST['district'] : null;
    $phone = isset($_POST['phone']) ? $_POST['phone'] : null;

    // Validate inputs
    if ($name === null || $district === null || $phone === null) {
        die('Error: Please fill in all required fields.');
    }

    // Prepare and execute SQL statement
    $stmt = $conn->prepare("INSERT INTO participants (name, district, phone) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $district, $phone);

    if (!$stmt->execute()) {
        die("Error executing query: " . $stmt->error);
    }

    // Store participant data in session
    $_SESSION['participants'][] = [
        'name' => $name,
        'district' => $district,
        'phone' => $phone,
    ];

    echo "Data inserted successfully.";
    $stmt->close();
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Siswa</title>
</head>
<body>
    <h1>Pendaftaran Siswa</h1>
    <form method="post">
        <label for="name">Nama:</label>
        <input type="text" id="name" name="name" required>

        <label for="district">Daerah:</label>
        <input type="text" id="district" name="district" required>

        <label for="phone">Telepon:</label>
        <input type="text" id="phone" name="phone" required>

        <button type="submit">Daftar</button>
    </form>

    <a href="data.php">Lihat Data Siswa</a>
</body>
</html>
