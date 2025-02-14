<?php
// Connexion à la base de données
$pdo = new PDO('mysql:host=localhost;dbname=quizz_night', 'root', '', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);

// Récupération des thèmes pour le formulaire de modification
$themes = $pdo->query("SELECT QuizID as id, Title as nom_theme FROM quiz")->fetchAll();

// Traitement de l'ajout d'un nouveau thème
if (isset($_POST['ajouter'])) {
    try {
        $pdo->beginTransaction();

        // Insertion du thème (quiz)
        $stmtQuiz = $pdo->prepare("INSERT INTO quiz (UserID, Title) VALUES (?, ?)");
        $stmtQuiz->execute([8, $_POST['theme']]); // UserID 8 correspond à LamineJS
        $quizId = $pdo->lastInsertId();

        // Insertion de la question
        $stmtQuestion = $pdo->prepare("INSERT INTO question (QuizID, QuestionText) VALUES (?, ?)");
        $stmtQuestion->execute([$quizId, $_POST['question']]);
        $questionId = $pdo->lastInsertId();

        // Insertion des réponses
        $stmtResponse = $pdo->prepare("INSERT INTO response (QuestionID, ResponseText, IsCorrect) VALUES (?, ?, ?)");
        
        // Réponse A
        $stmtResponse->execute([
            $questionId,
            $_POST['reponseA'],
            $_POST['bonne_reponse'] === 'A' ? 1 : 0
        ]);

        // Réponse B
        $stmtResponse->execute([
            $questionId,
            $_POST['reponseB'],
            $_POST['bonne_reponse'] === 'B' ? 1 : 0
        ]);

        // Réponse C
        $stmtResponse->execute([
            $questionId,
            $_POST['reponseC'],
            $_POST['bonne_reponse'] === 'C' ? 1 : 0
        ]);

        // Réponse D
        $stmtResponse->execute([
            $questionId,
            $_POST['reponseD'],
            $_POST['bonne_reponse'] === 'D' ? 1 : 0
        ]);

        $pdo->commit();
        echo "<script>alert('Thème ajouté avec succès!');</script>";
    } catch (Exception $e) {
        $pdo->rollBack();
        echo "<script>alert('Erreur lors de l\'ajout: " . htmlspecialchars($e->getMessage()) . "');</script>";
    }
}

// Traitement de la suppression d'un thème
if (isset($_POST['supprimer']) && isset($_POST['theme_id'])) {
    try {
        // La suppression en cascade est configurée dans la base de données
        $stmt = $pdo->prepare("DELETE FROM quiz WHERE QuizID = ?");
        $stmt->execute([$_POST['theme_id']]);
        echo "<script>alert('Thème supprimé avec succès!');</script>";
    } catch (Exception $e) {
        echo "<script>alert('Erreur lors de la suppression: " . htmlspecialchars($e->getMessage()) . "');</script>";
    }
}

// Traitement de la modification d'un thème
if (isset($_POST['modifier']) && isset($_POST['theme_id'])) {
    // Rediriger vers une page de modification avec l'ID du thème
    header("Location: modifier_theme.php?id=" . $_POST['theme_id']);
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Quizz Night</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <header>
        <h1>Quizz Night</h1>
        <nav>
            <a href="#">accueil</a>
            <a href="#">score</a>
            <button class="compte-btn">Mon compte</button>
        </nav>
    </header>

    <main>
        <button class="btn-vert" onclick="afficherFormulaire('ajout')">Ajouter un thème</button>
        
        <!-- Formulaire d'ajout -->
        <div id="form-ajout" class="form-container">
            <form action="" method="POST">
                <h2>Nouveau Thème</h2>
                <input type="text" name="theme" placeholder="Nom du thème" required>
                <input type="text" name="question" placeholder="Question" required>
                
                <div class="reponse-groupe">
                    <input type="text" name="reponseA" placeholder="Réponse A" required>
                    <input type="radio" name="bonne_reponse" value="A">
                </div>
                
                <div class="reponse-groupe">
                    <input type="text" name="reponseB" placeholder="Réponse B" required>
                    <input type="radio" name="bonne_reponse" value="B">
                </div>
                
                <div class="reponse-groupe">
                    <input type="text" name="reponseC" placeholder="Réponse C" required>
                    <input type="radio" name="bonne_reponse" value="C">
                </div>
                
                <div class="reponse-groupe">
                    <input type="text" name="reponseD" placeholder="Réponse D" required>
                    <input type="radio" name="bonne_reponse" value="D">
                </div>
                
                <button type="submit" name="ajouter" class="btn-ajouter">Ajouter</button>
            </form>
        </div>

        <button class="btn-vert" onclick="afficherFormulaire('modif')">Modifier un thème</button>
        
        <!-- Formulaire de modification -->
        <div id="form-modif" class="form-container">
            <form action="" method="POST">
                <h2>Modifier/Supprimer un thème</h2>
                <select name="theme_id">
                    <?php foreach($themes as $theme): ?>
                        <option value="<?= $theme['id'] ?>"><?= htmlspecialchars($theme['nom_theme']) ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" name="supprimer" class="btn-supprimer">Supprimer</button>
                <button type="submit" name="modifier" class="btn-modifier">Modifier</button>
            </form>
        </div>
    </main>

    <script>
        function afficherFormulaire(type) {
            document.getElementById('form-ajout').style.display = 'none';
            document.getElementById('form-modif').style.display = 'none';
            document.getElementById('form-' + type).style.display = 'block';
        }
    </script>
</body>
</html>