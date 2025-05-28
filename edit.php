<?php
include 'db.php';

$name = $email = $phone = "";
$nameErr = $emailErr = $phoneErr = "";
$successMsg = "";

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID is required");
}

$id = intval($_GET['id']);

$stmt = $conn->prepare("SELECT name, email, phone FROM contacts WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($name, $email, $phone);
if (!$stmt->fetch()) {
    die("Contact not found");
}
$stmt->close();
    
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $valid = true;

    if (empty($_POST["name"])) {
        $nameErr = "Name is required";
        $valid = false;
    } else {
        $name = trim($_POST["name"]);
    }

    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
        $valid = false;
    } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";
        $valid = false;
    } else {
        $email = trim($_POST["email"]);
    }

    if (empty($_POST["phone"])) {
        $phoneErr = "Phone is required";
        $valid = false;
    } else {
        $phone = trim($_POST["phone"]);
    }

    if ($valid) {
        $stmt = $conn->prepare("UPDATE contacts SET name = ?, email = ?, phone = ? WHERE id = ?");
        $stmt->bind_param("sssi", $name, $email, $phone, $id);

        if ($stmt->execute()) {
            $successMsg = "Contact updated successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Contact</title>
</head>
<body>
    <h1>Edit Contact</h1>
    <a href="index.php">Back to Contact List</a><br><br>

    <?php if ($successMsg) echo "<p style='color:green;'>$successMsg</p>"; ?>

    <form method="post" action="">
        Name: <br>
        <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>">
        <span style="color:red;"><?php echo $nameErr; ?></span>
        <br><br>

        Email: <br>
        <input type="text" name="email" value="<?php echo htmlspecialchars($email); ?>">
        <span style="color:red;"><?php echo $emailErr; ?></span>
        <br><br>

        Phone: <br>
        <input type="text" name="phone" value="<?php echo htmlspecialchars($phone); ?>">
        <span style="color:red;"><?php echo $phoneErr; ?></span>
        <br><br>

        <input type="submit" value="Update Contact">
    </form>
</body>
</html>
