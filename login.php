<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE UserEmail = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['UserPass'])) {
        $_SESSION['user'] = $user;
        header("Location: " . ($user['UserType'] == 'admin' ? 'admin.php' : ($user['UserType'] == 'professor' ? 'professor.php' : 'student.php')));
        exit;
    } else {
        $error = "Email ou mot de passe incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Connexion</h1>
    <form method="post">
        <input type="email" name="email" required placeholder="Email">
        <input type="password" name="password" required placeholder="Mot de passe">
        <button type="submit">Se connecter</button>
    </form>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>
</body>
</html>
