<?php
require_once __DIR__ . '/../classes/Quiz.php';

$quizObj = new Quiz();
$quizzes = $quizObj->getAllQuizzes();

$themes = [
    'marques' => ['color' => 'red', 'icon' => 'fa-shopping-bag'],
    'films' => ['color' => 'purple', 'icon' => 'fa-film'],
    'animaux' => ['color' => 'green', 'icon' => 'fa-paw'],
    'art' => ['color' => 'orange', 'icon' => 'fa-paint-brush'],
    'sport' => ['color' => 'blue', 'icon' => 'fa-futbol'],
    'musiques' => ['color' => 'pink', 'icon' => 'fa-music'],
    'histoire' => ['color' => 'brown', 'icon' => 'fa-landmark'],
    'culture' => ['color' => 'teal', 'icon' => 'fa-globe'],
    'geographie' => ['color' => 'cyan', 'icon' => 'fa-map'],
    'disney' => ['color' => 'gold', 'icon' => 'fa-magic'],
    'football' => ['color' => 'darkgreen', 'icon' => 'fa-futbol'],
    'harry potter' => ['color' => 'darkblue', 'icon' => 'fa-hat-wizard'],
];

function getQuizStyle($title, $themes) {
    $key = strtolower($title);
    return $themes[$key] ?? ['color' => 'gray', 'icon' => 'fa-question-circle'];
}

function getQuizIcon($title, $icons) {
    $key = strtolower($title);
    return $icons[$key] ?? 'fa-question-circle'; 
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quizz Night</title>
    <link rel="stylesheet" href="../assets/css/style.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
</head>
<body>
   <?php include "../includes/header.php"   ?>

    <div class="title">
        <img class="img-quiz" src="../assets/images/quiz-img.avif" alt="">
    </div>

    <div class="grid">
    <?php foreach ($quizzes as $quiz): 
        $style = getQuizStyle($quiz['Title'], $themes);
    ?>
        <a href="quiz.php?quizId=<?= $quiz['QuizID'] ?>" class="category" style="background: <?= $style['color'] ?>;">
            <i class="fas <?= $style['icon'] ?>"></i>
            <span><?= htmlspecialchars($quiz['Title']) ?></span>
        </a>
    <?php endforeach; ?>
</div>
</div>
</body>
</html>
