<?php
// Define variables and set to empty
$name = $email = $password = "";
$nameErr = $emailErr = $passwordErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Name validation
    if (empty($_POST["name"])) {
        $nameErr = "Name is required";
    } else {
        $name = htmlspecialchars($_POST["name"]);
    }

    // Email validation
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";
    } else {
        $email = htmlspecialchars($_POST["email"]);
    }

    // Password validation
    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
    } elseif (strlen($_POST["password"]) < 6) {
        $passwordErr = "Password must be at least 6 characters";
    } else {
        $password = htmlspecialchars($_POST["password"]);
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>PHP Form Validation</title>
    <style>
        .error {
            color: red;
        }

        input,
        button {
            margin: 6px 0;
            padding: 6px;
        }
    </style>
</head>

<body>

    <h2>Simple Form with Validation</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        Name: <br>
        <input type="text" name="name" value="<?php echo $name; ?>">
        <span class="error">* <?php echo $nameErr; ?></span><br>

        Email: <br>
        <input type="text" name="email" value="<?php echo $email; ?>">
        <span class="error">* <?php echo $emailErr; ?></span><br>

        Password: <br>
        <input type="password" name="password">
        <span class="error">* <?php echo $passwordErr; ?></span><br>

        <button type="submit">Submit</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && !$nameErr && !$emailErr && !$passwordErr) {
        echo "<h3>✅ Form Submitted Successfully!</h3>";
        echo "<p>Name: $name</p>";
        echo "<p>Email: $email</p>";
    }
    ?>

</body>

</html>