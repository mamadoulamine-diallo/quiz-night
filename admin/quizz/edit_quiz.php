<?php 

require_once __DIR__ . '/../../classes/Quiz.php';
require_once __DIR__ . '/../auth/auth.php';

if (!isset($_SESSION['user_id'])) {
    die("Erreur : utilisateur non connecté.");
}

$quiz = new Quiz();

if (!isset($_GET['id'])) {
    die("Erreur : ID du quiz manquant.");
}

$quizId = $_GET['id'];
$quizData = $quiz->getQuizById($quizId);

if (!$quizData) {
    die("Erreur : Quiz introuvable.");
}

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];

    if (!empty($title) && !empty($description)) {
        if ($quiz->updateQuiz($quizId, $title, $description)) {
            $message = "Quiz mis à jour avec succès !";
            $quizData = $quiz->getQuizById($quizId); 
        } else {
            $message = "Erreur lors de la mise à jour du quiz.";
        }
    } else {
        $message = "Tous les champs sont obligatoires.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le Quiz</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h2 {
            font-size: 24px;
            margin-top: 60px; 
            color: #333;
            margin-bottom: 0;
        }

        form {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            margin-top: 40px; 
        }

        label {
            display: block;
            font-size: 14px;
            margin-bottom: 5px;
            color: #333;
            text-align: left;
        }

        input, textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            box-sizing: border-box;
        }

        input:focus, textarea:focus {
            border-color: #007BFF;
            outline: none;
        }

        button {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 12px;
            width: 100%;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }

        .nav-auth {
            padding: 20px;
            background: rgb(18,21,43);
            color: white;
            width: 100%;
            text-align: center;
        }

        .nav-auth a {
            color: white;
            text-decoration: none;
            letter-spacing: 1px;
            font-size: 1.2rem;
        }

        p {
            color: green;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="nav-auth">
        <a href="../index.php">Accueil</a>
    </div>

    <h2>Modifier le Quiz</h2>

    <?php if ($message): ?>
        <p><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <form action="" method="POST">
        <label for="title">Titre du Quiz :</label>
        <input type="text" name="title" value="<?= htmlspecialchars($quizData['Title']) ?>" required><br>

        <label for="description">Description :</label>
        <textarea name="description" required><?= htmlspecialchars($quizData['Description']) ?></textarea><br>

        <button type="submit">Enregistrer les modifications</button>
    </form>

</body>
</html>
