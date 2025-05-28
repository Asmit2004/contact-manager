<?php
include 'db.php';

// Fetch all contacts
$sql = "SELECT * FROM contacts";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Contact Manager</title>
</head>
<body>
    <h1>Contact Manager</h1>

    <a href="add.php">Add New Contact</a><br><br>

    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Actions</th>
        </tr>

        <?php
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["phone"]) . "</td>";
                echo "<td>
                        <a href='edit.php?id=" . $row["id"] . "'>Edit</a> | 
                        <a href='delete.php?id=" . $row["id"] . "' onclick=\"return confirm('Are you sure?');\">Delete</a>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No contacts found</td></tr>";
        }
        ?>

    </table>
</body>
</html>
