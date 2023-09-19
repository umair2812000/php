<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    $errors = [];

    // Validate form fields
    if (empty($name) || !preg_match("/^[a-zA-Z ]*$/", $name)) {
        $errors["name"] = "Name should not be empty and contain only letters and spaces.";
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "Please enter a valid email address.";
    }

    if (strlen($password) < 8 || !preg_match("/[A-Za-z]+/", $password) || !preg_match("/\d+/", $password) || !preg_match("/[^A-Za-z\d]+/", $password)) {
        $errors["password"] = "Password must be at least 8 characters long and contain letters, numbers, and special characters.";
    }

    if ($password !== $confirm_password) {
        $errors["confirm_password"] = "Passwords do not match.";
    }

    if (empty($errors)) {
        // Validation successful, set session variables
        $_SESSION["name"] = $name;
        $_SESSION["email"] = $email;

        // Redirect to the welcome page
        header("Location: welcome.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registration Form</title>
</head>
<body>
    <?php if (isset($_SESSION["name"]) && isset($_SESSION["email"])): ?>
        <!-- Welcome page -->
        <h2>Welcome</h2>
        <p>Welcome, <?php echo $_SESSION["name"]; ?>!</p>
        <p>Your email: <?php echo $_SESSION["email"]; ?></p>
        <a href="logout.php">Logout</a>
    <?php else: ?>
        <!-- Registration form -->
        <h2>Registration Form</h2>
        <form action="" method="post">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
            <span style="color: red;"><?php if(isset($errors["name"])) echo $errors["name"]; ?></span><br><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <span style="color: red;"><?php if(isset($errors["email"])) echo $errors["email"]; ?></span><br><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <span style="color: red;"><?php if(isset($errors["password"])) echo $errors["password"]; ?></span><br><br>

            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
            <span style="color: red;"><?php if(isset($errors["confirm_password"])) echo $errors["confirm_password"]; ?></span><br><br>

            <input type="submit" value="Register">
        </form>
    <?php endif; ?>
</body>
</html>
