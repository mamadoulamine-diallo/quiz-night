<?php
include 'config.php';





if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = htmlspecialchars($_POST['username']);
  $email = htmlspecialchars($_POST['email']);
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 

  
  if (!empty($username) && !empty($email) && !empty($password)) {
      try {
          $sql = "INSERT INTO user (username, email, password) VALUES (:username, :email, :password)";
          $stmt = $mysqlClient->prepare($sql);
          $stmt->execute([
              ':username' => $username,
              ':email' => $email,
              ':password' => $password
          ]);

          echo "Inscription réussie !";
      } catch (Exception $e) {
          echo "Erreur lors de l'inscription : " . $e->getMessage();
      }
  } else {
      echo "Veuillez remplir tous les champs.";
  }
}
?>
 
 <form action="test_db.php" method="POST">
    <input type="text" name="username" placeholder="Nom d'utilisateur" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Mot de passe" required><br>
    <button type="submit">S'inscrire</button>
</form>
 





