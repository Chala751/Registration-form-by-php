<?php
session_start();
include 'db.php';

$name = $email = $password = "";
$nameErr = $emailErr = $passwordErr = "";
$hasError = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["name"])) {
    $nameErr = "Name is required";
    $hasError = true;
  } else {
    $name = htmlspecialchars($_POST["name"]);
  }

  if (empty($_POST["email"])) {
    $emailErr = "Email is required";
    $hasError = true;
  } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    $emailErr = "Invalid email format";
    $hasError = true;
  } else {
    $email = htmlspecialchars($_POST["email"]);
  }

  if (empty($_POST["password"])) {
    $passwordErr = "Password is required";
    $hasError = true;
  } elseif (strlen($_POST["password"]) < 6) {
    $passwordErr = "Password must be at least 6 characters";
    $hasError = true;
  } else {
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // secure hash
  }

  if (!$hasError) {
    $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $password);
    if ($stmt->execute()) {
      $_SESSION['success'] = "Registration successful! Please login.";
      header("Location: login.php");
      exit();
    } else {
      $emailErr = "Email already registered!";
    }
    $stmt->close();
  }
}
?>

<!-- HTML Form -->
<!DOCTYPE html>
<html>

<head>
  <title>Register</title>
  <style>
    .error {
      color: red;
    }
  </style>
</head>

<body>
  <h2>Register</h2>

  <form method="POST" action="">
    Name: <br>
    <input type="text" name="name" value="<?php echo $name; ?>"><br>
    <span class="error"><?php echo $nameErr; ?></span><br><br>

    Email: <br>
    <input type="text" name="email" value="<?php echo $email; ?>"><br>
    <span class="error"><?php echo $emailErr; ?></span><br><br>

    Password: <br>
    <input type="password" name="password"><br>
    <span class="error"><?php echo $passwordErr; ?></span><br><br>

    <button type="submit">Register</button>
  </form>

  <p>Already registered? <a href="login.php">Login here</a></p>
</body>

</html>