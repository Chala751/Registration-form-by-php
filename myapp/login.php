<?php
session_start();
include 'db.php';

$email = $password = "";
$emailErr = $passwordErr = $loginErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = htmlspecialchars($_POST["email"]);
    $password = $_POST["password"];

    if (empty($email)) {
        $emailErr = "Email is required";
    }

    if (empty($password)) {
        $passwordErr = "Password is required";
    }

    if (!$emailErr && !$passwordErr) {
        $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
            $stmt->bind_result($id, $name, $hashedPassword);
            $stmt->fetch();

            if (password_verify($password, $hashedPassword)) {
                $_SESSION['user_id'] = $id;
                $_SESSION['user_name'] = $name;
                header("Location: home.php");
                exit();
            } else {
                $loginErr = "Invalid password.";
            }
        } else {
            $loginErr = "No account found with that email.";
        }

        $stmt->close();
    }
}
?>

<!-- HTML Login Form -->
<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <style>
        .error {
            color: red;
        }
    </style>
</head>

<body>
    <h2>Login</h2>

    <?php
    if (isset($_SESSION['success'])) {
        echo "<p style='color: green;'>" . $_SESSION['success'] . "</p>";
        unset($_SESSION['success']);
    }
    if ($loginErr) {
        echo "<p class='error'>$loginErr</p>";
    }
    ?>

    <form method="POST" action="">
        Email:<br>
        <input type="text" name="email" value="<?php echo $email; ?>"><br>
        <span class="error"><?php echo $emailErr; ?></span><br><br>

        Password:<br>
        <input type="password" name="password"><br>
        <span class="error"><?php echo $passwordErr; ?></span><br><br>

        <button type="submit">Login</button>
    </form>
</body>

</html>