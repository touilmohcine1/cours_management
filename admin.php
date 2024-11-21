<?php
include 'config.php';
if (!isset($_SESSION['user']) || $_SESSION['user']['UserType'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Code pour créer des comptes ici
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $usertype = $_POST['usertype'];

    // Vérification de l'existence de l'email
    $stmt = $pdo->prepare("SELECT * FROM users WHERE UserEmail = ?");
    $stmt->execute([$email]);
    if ($stmt->rowCount() > 0) {
        die("L'email est déjà utilisé.");
    }

    // Hachage du mot de passe
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insertion dans la base de données
    $stmt = $pdo->prepare("INSERT INTO users (UserName, UserEmail, UserPass, UserType) VALUES (?, ?, ?, ?)");
    if ($stmt->execute([$username, $email, $hashed_password, $usertype])) {
        echo "Utilisateur ajouté avec succès !";
    } else {
        echo "Erreur lors de l'ajout de l'utilisateur.";
    }
} else {
    echo "Méthode non autorisée.";
}


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Panneau Admin</h1>
    <form method="post" action="admin.php">
        <input type="text" name="username" required placeholder="Nom d'utilisateur">
        <input type="email" name="email" required placeholder="Email">
        <input type="password" name="password" required placeholder="Mot de passe">
        <select name="usertype">
            <option value="professor">Professeur</option>
            <option value="student">Étudiant</option>
        </select>
        <button type="submit">Créer un compte</button>
    </form>
    <a href="logout.php">Déconnexion</a>
</body>
</html>
