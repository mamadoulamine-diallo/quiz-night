<?php


// Définition des catégories
$categories = [
    [
        'name' => 'Marques',
        'background' => 'red',
        'logo' => 'logos/marques.png'
    ],
    [
        'name' => 'Films',
        'background' => 'white',
        'logo' => 'logos/films.png'
    ],
    [
        'name' => 'Animaux',
        'background' => 'white',
        'logo' => 'logos/animaux.png'
    ],
    [
        'name' => 'Art',
        'background' => 'black',
        'logo' => 'logos/art.png'
    ],
    [
        'name' => 'Sport',
        'background' => 'teal',
        'logo' => 'logos/sport.png'
    ],
    [
        'name' => 'Musiques',
        'background' => 'black',
        'logo' => 'logos/musiques.png'
    ],
    [
        'name' => 'Histoire',
        'background' => 'purple',
        'logo' => 'logos/histoire.png'
    ],
    [
        'name' => 'Culture Générale',
        'background' => 'purple',
        'logo' => 'logos/culture.png'
    ],
    [
        'name' => 'Géographie',
        'background' => 'purple',
        'logo' => 'logos/geographie.png'
    ],
    [
        'name' => 'Disney',
        'background' => 'purple',
        'logo' => 'logos/disney.png'
    ],
    [
        'name' => 'Football',
        'background' => 'purple',
        'logo' => 'logos/football.png'
    ],
    [
        'name' => 'Harry Potter',
        'background' => 'purple',
        'logo' => 'logos/harry-potter.png'
    ]
];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Night</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <!-- Navigation -->
    <nav class="navigation">
        <div class="nav-logo">
            <a href="#">Quiz Night</a>
        </div>
        <div class="nav-links">
            <a href="accueil" class="nav-link">accueil</a>
            <a href="score" class="nav-link">score</a>
            <a href="#" class="nav-button">Mon compte</a>
        </div>
    </nav>

    <!-- Header Banner -->
    <header class="banner">
        <div class="banner-text">
            <h1>QUESTIONS</h1>
            <h2>POUR UN <span>VAINQUEUR</span></h2>
        </div>
    </header>

    <!-- Categories Grid -->
    <main class="categories">
        <div class="grid-container">
            <?php foreach ($categories as $category): ?>
                <a href="quiz.php?category=<?= urlencode($category['name']) ?>" 
                   class="category-card <?= $category['background'] ?>">
                    <?php if (isset($category['logo'])): ?>
                        <img src="<?= htmlspecialchars($category['logo']) ?>" 
                             alt="<?= htmlspecialchars($category['name']) ?>"
                             class="category-logo">
                    <?php endif; ?>
                    <span class="category-name">
                        <?= htmlspecialchars($category['name']) ?>
                    </span>
                </a>
            <?php endforeach; ?>
        </div>
    </main>
</body>
</html>