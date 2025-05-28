<?php
include 'db.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID is required");
}

$id = intval($_GET['id']);

// Prepare and execute delete
$stmt = $conn->prepare("DELETE FROM contacts WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    $stmt->close();
    // Redirect back to index.php after deletion
    header("Location: index.php");
    exit;
} else {
    echo "Error deleting contact: " . $stmt->error;
}
?>
