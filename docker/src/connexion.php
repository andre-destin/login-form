<?php
require_once 'config.php';

$error = '';

// Si déjà connecté, rediriger
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $error = "Veuillez remplir tous les champs";
    } else {
        try {
            // Rechercher l'utilisateur
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                // Connexion réussie
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_nom'] = $user['nom'];
                $_SESSION['user_prenom'] = $user['prenom'];
                $_SESSION['user_email'] = $user['email'];

                // Mettre à jour la dernière connexion
                $stmt = $pdo->prepare("UPDATE users SET derniere_connexion = NOW() WHERE id = ?");
                $stmt->execute([$user['id']]);

                // Redirection
                header('Location: dashboard.php');
                exit;
            } else {
                $error = "Email ou mot de passe incorrect";
            }
        } catch (PDOException $e) {
            $error = "Erreur de connexion : " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/e48c9d260c.js" crossorigin="anonymous"></script>
    <title>Formulaire de connexion</title>
</head>
<body>
    <form method="POST" action="">
        <h1>SE CONNECTER</h1>

        <?php if ($error): ?>
            <div class="alert alert-error">
                <p><i class="fa-solid fa-circle-exclamation"></i> <?= htmlspecialchars($error) ?></p>
            </div>
        <?php endif; ?>

        <!-- demande le mail de l'utilisateur -->
        <div class="input-box">
            <input type="email" name="email" placeholder="Email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
            <i class="fa-solid fa-user"></i>
        </div>

        <!-- demande le mot de passe de l'utilisateur -->
        <div class="input-box">
            <input type="password" name="password" placeholder="Mot de passe" required>
            <i class="fa-solid fa-key"></i>
        </div>

        <!-- bouton se souvenir de moi et mot de passe oublié-->
        <div class="remenber">
            <a href="reset_password.php">
                <i class="fa-solid fa-question"></i> Mot de passe oublié ?
            </a>
        </div>

        <button class="login-btn" type="submit">
            <i class="fa-solid fa-right-to-bracket"></i> Se connecter
        </button>

        <div class="inscription">
            <p>Je n'ai pas de compte. <a href="index.php">Créer mon compte</a></p>
        </div>
    </form>
</body>
</html>
