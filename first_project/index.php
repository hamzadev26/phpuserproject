<?php include 'db.php'; ?>

<!DOCTYPE html>
<html>

<head>
    <title>First PHP Project</title>
</head>

<body>

    <h1>First PHP Project Jenkins Pipeline Image Shared Library</h1>

    <h2>Add User</h2>

    <form action="insert.php" method="POST">
        <input type="text" name="name" placeholder="Enter Name" required><br><br>
        <input type="email" name="email" placeholder="Enter Email" required><br><br>
        <button type="submit">Submit</button>
    </form>

    <h2>Users List</h2>

    <?php
    $result = mysqli_query($conn, "SELECT * FROM users");

    while ($row = mysqli_fetch_assoc($result)) {
        echo htmlspecialchars($row['name']) . " - " . htmlspecialchars($row['email']) . "<br>";
    }
    ?>

</body>

</html>