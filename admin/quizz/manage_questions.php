<?php

require_once __DIR__ . '/../auth/auth.php';
require_once __DIR__ . '/../../classes/Question.php';
require_once __DIR__ . '/../../classes/Response.php';

$quizId = $_GET['quizId'] ?? null;
if (!$quizId) {
    header("Location: index.php");
    exit();
}

$questionObj = new Question();
$responseObj = new Response();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add_question'])) {
        $questionText = $_POST['question_text'];
        if (!empty($questionText)) {
            $questionObj->addQuestion($quizId, $questionText);
        }
    } elseif (isset($_POST['add_response'])) {
        $questionId = $_POST['question_id'];
        $responseText = $_POST['response_text'];
        $isCorrect = isset($_POST['is_correct']) ? 1 : 0;
        if (!empty($responseText)) {
            $responseObj->addResponse($questionId, $responseText, $isCorrect);
        }
    }
}

$questions = $questionObj->getQuestionsByQuizId($quizId);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gérer les Questions</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        h2, h3 {
            color: #333;
        }

        form {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 700px;
            margin: 20px 0;
        }

        input {
            width: 200px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        button {
            padding: 5px;
            background-color: rgb(18,20,42);
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        label {
            font-size: 500;
            color: black;
        }

        button:hover {
            background-color: #0056b3;
        }

        ul {
            list-style: none;
            padding: 0;
            width: 90%;
            max-width: 600px;
        }

        .question-card {
            background: rgb(29,32,85);
            color: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 15px;
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
            font-size: 1.2rem;
        }
    </style>
</head>
<body>
    <div class="nav-auth">
        <a href="../index.php">Accueil</a>
    </div>

    <h2>Gestion des Questions pour le Quiz</h2>
    
    <form action="" method="POST">
        <input type="hidden" name="quiz_id" value="<?= $quizId ?>">
        <label>Nouvelle Question :</label>
        <input type="text" name="question_text" required>
        <button type="submit" name="add_question">Ajouter Question</button>
    </form>

    <h3>Questions Existantes</h3>
    <ul>
        <?php foreach ($questions as $q): ?>
            <li class="question-card">
                <strong><?= htmlspecialchars($q['QuestionText']) ?></strong>
                <form action="" method="POST">
                    <input type="hidden" name="question_id" value="<?= $q['QuestionID'] ?>">
                    <input type="text" name="response_text" required>
                    <label><input type="checkbox" name="is_correct"> Bonne Réponse</label>
                    <button type="submit" name="add_response">Ajouter Réponse</button>
                </form>
                <ul>
                    <?php 
                    $responses = $responseObj->getResponsesByQuestion($q['QuestionID']);
                    foreach ($responses as $r): ?>
                        <li><?= htmlspecialchars($r['ResponseText']) ?> <?= $r['IsCorrect'] ? "(✔️ Correct)" : "" ?></li>
                    <?php endforeach; ?>
                </ul>
            </li>
        <?php endforeach; ?>
    </ul>

    <a href="../index.php">Retour à la gestion des quiz</a>
</body>
</html>
