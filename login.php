<?php
session_start();

// Connexion à la base de données SQLite
$db = new SQLite3('database.sqlite');

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les informations du formulaire
    $username = $_POST['username'];  
    $password = $_POST['password']; 

    // Requête SQL pour vérifier si l'utilisateur existe dans la base de données
    $stmt = $db->prepare('SELECT * FROM users WHERE username = :username');
    $stmt->bindValue(':username', $username, SQLITE3_TEXT);
    $result = $stmt->execute();

    // Vérifier si l'utilisateur existe
    if ($user = $result->fetchArray()) {
        // Vérifier si le mot de passe correspond (assurez-vous que les mots de passe sont hachés dans la base de données)
        if (password_verify($password, $user['password'])) {
            // Connexion réussie, démarrer une session
            $_SESSION['username'] = $user['username'];
            header('Location: dashboard.php'); // Rediriger vers la page de tableau de bord
            exit();
        } else {
            $error = "Mot de passe incorrect.";
        }
    } else {
        $error = "Nom d'utilisateur incorrect.";
    }
}
?>
