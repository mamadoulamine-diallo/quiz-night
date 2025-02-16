<?php 

require_once __DIR__ . '/../../classes/Admin.php';
require_once __DIR__ . '/../../classes/Quiz.php';
require_once __DIR__ . '/../auth/auth.php';

if (!isset($_SESSION['user_id'])) {
    die("Erreur : utilisateur non connecté.");
}

$userId = $_SESSION['user_id']; 
$quiz = new Quiz();

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];

    if (!empty($title) && !empty($description)) {
        if ($quiz->addQuiz($userId, $title, $description)) 
        {
            $message = "Quiz créé avec succès !";
        } else {
            $message = "Erreur lors de la création du quiz.";
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
    <title>Créer un Quiz</title>
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

    <h2>Créer un nouveau quiz</h2>
    
    <?php if ($message): ?>
        <p><?= $message ?></p>
    <?php endif; ?>

    <form action="" method="POST">
        <label for="title">Titre du Quiz :</label>
        <input type="text" name="title" required><br>

        <label for="description">Description :</label>
        <textarea name="description" required></textarea><br>

        <button type="submit">Créer</button>
    </form>

</body>
</html>
