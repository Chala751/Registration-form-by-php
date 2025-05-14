<?php
session_start();
include 'db.php';

// Correct session variable from login.php
if (!isset($_SESSION['user_email'])) {
    header("Location: login.php");
    exit();
}

// Check if the logged-in user is the admin
if ($_SESSION['user_email'] !== 'admin@example.com') {
    echo "<h3 style='color:red'>Access Denied. Admins only.</h3>";
    exit();
}


// Fetch all users
$sql = "SELECT id, name, email FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial;
            background: #f4f4f4;
            padding: 20px;
        }

        .dashboard {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            width: 80%;
            margin: auto;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            margin-top: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 10px;
            border-bottom: 1px solid #ccc;
        }

        .logout {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="dashboard">
        <h2>👋 Welcome, Admin</h2>
        <p>You are viewing the registered users:</p>

        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                </tr>
            <?php endwhile; ?>
        </table>

        <div class="logout">
            <a href="logout.php">Logout</a>
        </div>
    </div>
</body>

</html>