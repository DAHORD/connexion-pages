<?php
// reset_password.php
if (!isset($_GET['email'])) {
    echo "Lien invalide.";
    exit();
}

$email = htmlspecialchars($_GET['email']);

// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    if ($newPassword !== $confirmPassword) {
        $error = "Les mots de passe ne correspondent pas.";
    } elseif (strlen($newPassword) < 6) {
        $error = "Le mot de passe doit contenir au moins 6 caractères.";
    } else {
        // TODO: Mettre à jour le mot de passe dans la base de données
        // (exemple) hash du mot de passe
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Exemple d'affichage (remplacer par une vraie requête SQL)
        echo "Le mot de passe pour <strong>$email</strong> a été réinitialisé avec succès.<br>";
        echo "<a href='login.html'>Se connecter</a>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Réinitialiser le mot de passe</title>
  <link rel="stylesheet" href="style.css">
  <style>
    .loginBx {
      position: relative;
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
      gap: 25px;
      width: 70%;
      transform: translateY(175px);
      transition: 0.5s;
    }
    h2 {
      margin-top: 50px;
    }
    .box:hover {
      width: 550px;
      height: 420px;
    }
    .box {
      width: 400px;
      height: 200px;
    }
    .error {
      color: red;
    }
  </style>
</head>
<body>
<div class="box">
  <div class="login">
    <div class="loginBx">
      <h2>Réinitialiser le mot de passe</h2><br>
      <?php if (isset($error)): ?>
        <p class="error"><?= $error ?></p>
      <?php endif; ?>
      <form method="post">
        <input type="password" name="new_password" placeholder="Nouveau mot de passe" required>
        <br><br>
        <input type="password" name="confirm_password" placeholder="Confirmer le mot de passe" required>
        <br><br>
        <input type="submit" value="Réinitialiser le mot de passe">
      </form>
    </div>
  </div>
</div>
</body>
</html>
