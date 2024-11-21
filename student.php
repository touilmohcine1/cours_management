<?php
include 'config.php';
if (!isset($_SESSION['user']) || $_SESSION['user']['UserType'] !== 'student') {
    header("Location: login.php");
    exit;
}

// Récupération des cours et fichiers associés
$stmt = $pdo->prepare("SELECT c.CourseId, c.CourseTitle, f.FileId, f.FileTitle, f.Path, f.TelechargeCount
                        FROM courses c
                        LEFT JOIN files f ON c.CourseId = f.CourseId");
$stmt->execute();
$courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Panneau Étudiant</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Panneau Étudiant</h1>

    <h2>Liste des Cours et Fichiers</h2>
    <?php if (empty($courses)): ?>
        <p>Aucun cours disponible.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($courses as $course): ?>
                <li>
                    <strong><?php echo htmlspecialchars($course['CourseTitle']); ?></strong>
                    <?php if ($course['FileId']): ?>
                        <ul>
                            <li>
                                <a href="<?php echo htmlspecialchars($course['Path']); ?>" download>
                                    <?php echo htmlspecialchars($course['FileTitle']); ?>
                                </a>
                                (Téléchargements : <?php echo $course['TelechargeCount']; ?>)
                            </li>
                        </ul>
                    <?php else: ?>
                        <p>Aucun fichier associé à ce cours.</p>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <a href="logout.php">Déconnexion</a>
</body>
</html>
