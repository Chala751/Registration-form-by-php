<?php
session_start();

if (!isset($_SESSION['reg_email']) || !isset($_SESSION['reg_password'])) {
    header("Location: form.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Registration Successful</title>
</head>

<body>
    <h3 style="color:green;">✅ Registration successful!</h3>
    <p>You can now <a href="login.php">Login</a></p>
</body>

</html>