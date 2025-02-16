<?php
require_once __DIR__ . '/../classes/Database.php';

$pdo = Database::getConnection();

$query = "SELECT p.Name, s.Score, s.SubmittedAt 
          FROM score s
          JOIN player p ON s.PlayerID = p.PlayerID
          WHERE s.Score IS NOT NULL
          ORDER BY s.Score DESC, s.SubmittedAt ASC
          LIMIT 10";
$stmt = $pdo->query($query);
$leaderboard = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classement des Joueurs</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body {
            text-align: center;
            font-family: Arial, sans-serif;
            background-color: rgb(190,183,183);
            color: white;
        }

        .leaderboard {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #282c34;
            border-radius: 10px;
            overflow: hidden;
        }

        .leaderboard th, .leaderboard td {
            padding: 12px;
            border-bottom: 1px solid #444;
        }

        .leaderboard th {
            background-color: #44475a;
            color: #f8f8f2;
            font-size: 1.2em;
        }

        .leaderboard tr:nth-child(even) {
            background-color: #3c3f4b;
        }

        .leaderboard tr:nth-child(odd) {
            background-color: #2c2f3a;
        }

        .leaderboard tr:first-child {
            background-color: gold;
            font-weight: bold;
        }

        .leaderboard tr:nth-child(2) {
            background-color: silver;
        }

        .leaderboard tr:nth-child(3) {
            background-color: #cd7f32;
        }

        .leaderboard td {
            color: #f8f8f2;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            color: #ff79c6;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <?php include "../includes/header.php"; ?>

    <h2>🏆 Classement des Joueurs 🏆</h2>

    <?php if (count($leaderboard) > 0): ?>
        <table class="leaderboard">
            <tr>
                <th>Position</th>
                <th>Nom</th>
                <th>Score</th>
                <th>Date</th>
            </tr>
            <?php foreach ($leaderboard as $index => $player): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= htmlspecialchars($player['Name']) ?></td>
                    <td><?= $player['Score'] ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($player['SubmittedAt'])) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>Aucun score enregistré pour le moment.</p>
    <?php endif; ?>

    <br>
    <a href="index.php">🔙 Retour à l'accueil</a>
</body>
</html>
