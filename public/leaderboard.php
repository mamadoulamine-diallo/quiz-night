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
</head>
<body>
    <h2>🏆 Classement des Joueurs 🏆</h2>

    <?php if (count($leaderboard) > 0): ?>
        <table border="1" cellspacing="0" cellpadding="5">
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
