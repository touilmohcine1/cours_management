<?php
include 'config.php';
if (!isset($_SESSION['user']) || $_SESSION['user']['UserType'] !== 'professor') {
    header("Location: login.php");
    exit;
}

// Traitement de l'ajout d'un cours et d'un fichier
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $course_title = $_POST['course_title'];
    $file_title = $_FILES['file']['name'];
    $file_tmp = $_FILES['file']['tmp_name'];
    $user_id = $_SESSION['user']['UserId'];

    // Insertion du cours dans la base de données
    $stmt = $pdo->prepare("INSERT INTO courses (CourseTitle) VALUES (?)");
    if ($stmt->execute([$course_title])) {
        $course_id = $pdo->lastInsertId(); // Récupération de l'ID du cours inséré

        // Chemin de destination pour le fichier uploadé
        $upload_dir = 'uploads/';
        $file_path = $upload_dir . basename($file_title);

        // Déplacement du fichier uploadé vers le dossier de destination
        if (move_uploaded_file($file_tmp, $file_path)) {
            // Insertion du fichier dans la base de données
            $stmt = $pdo->prepare("INSERT INTO files (FileTitle, Path, UserId, CourseId) VALUES (?, ?, ?, ?)");
            if ($stmt->execute([$file_title, $file_path, $user_id, $course_id])) {
                echo "Cours et fichier ajoutés avec succès !";
            } else {
                echo "Erreur lors de l'ajout du fichier.";
            }
        } else {
            echo "Erreur lors de l'upload du fichier.";
        }
    } else {
        echo "Erreur lors de l'ajout du cours.";
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Professeur</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Panneau Professeur</h1>
    <form method="post" action="" enctype="multipart/form-data">
        <input type="text" name="course_title" required placeholder="Titre du cours">
        <input type="file" name="file" required>
        <button type="submit">Uploader</button>
    </form>
    <a href="logout.php">Déconnexion</a>
</body>
</html>
