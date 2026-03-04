<?php
require_once 'config.php';

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération et nettoyage des données
    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $age = trim($_POST['age'] ?? '');
    $adresse = trim($_POST['adresse'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $code_area = trim($_POST['code_area'] ?? '');
    $telephone = trim($_POST['telephone'] ?? '');
    $sexe = $_POST['sexe'] ?? '';

    // Validation
    if (empty($nom)) $errors[] = "Le nom est requis";
    if (empty($prenom)) $errors[] = "Le prénom est requis";
    if (empty($email)) {
        $errors[] = "L'email est requis";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "L'email n'est pas valide";
    }
    if (empty($password)) {
        $errors[] = "Le mot de passe est requis";
    } elseif (strlen($password) < 8) {
        $errors[] = "Le mot de passe doit contenir au moins 8 caractères";
    }
    if (!empty($age) && (!is_numeric($age) || $age < 0 || $age > 150)) {
        $errors[] = "L'âge n'est pas valide";
    }

    // Si pas d'erreurs, insertion dans la BDD
    if (empty($errors)) {
        try {
            // Vérifier si l'email existe déjà
            $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->execute([$email]);

            if ($stmt->fetch()) {
                $errors[] = "Cet email est déjà utilisé";
            } else {
                // Hash du mot de passe
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // Insertion
                $stmt = $pdo->prepare("
                    INSERT INTO users (nom, prenom, age, adresse, email, password, code_area, telephone, sexe)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
                ");

                $stmt->execute([
                    $nom,
                    $prenom,
                    $age ?: null,
                    $adresse,
                    $email,
                    $hashed_password,
                    $code_area,
                    $telephone,
                    $sexe ?: null
                ]);

                $success = "Inscription réussie ! Vous pouvez maintenant vous connecter.";

                // Redirection après 2 secondes
                header("refresh:2;url=connexion.php");
            }
        } catch (PDOException $e) {
            $errors[] = "Erreur lors de l'inscription : " . $e->getMessage();
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
    <title>Formulaire d'inscription</title>
</head>
<body>
    <form method="POST" action="" class="inscription-form">
        <h1>INSCRIPTION</h1>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-error">
                <?php foreach ($errors as $error): ?>
                    <p><i class="fa-solid fa-circle-exclamation"></i> <?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert alert-success">
                <p><i class="fa-solid fa-circle-check"></i> <?= htmlspecialchars($success) ?></p>
            </div>
        <?php endif; ?>

        <div class="form-row">
            <div class="input-box half">
                <input type="text" name="nom" placeholder="Nom" value="<?= htmlspecialchars($_POST['nom'] ?? '') ?>" required>
                <i class="fa-solid fa-user"></i>
            </div>
            <div class="input-box half">
                <input type="text" name="prenom" placeholder="Prénom" value="<?= htmlspecialchars($_POST['prenom'] ?? '') ?>" required>
                <i class="fa-solid fa-user"></i>
            </div>
        </div>

        <div class="form-row">
            <div class="input-box half">
                <input type="number" name="age" placeholder="Âge" min="1" max="150" value="<?= htmlspecialchars($_POST['age'] ?? '') ?>">
                <i class="fa-solid fa-calendar"></i>
            </div>
            <div class="input-box half">
                <select name="sexe" class="select-box">
                    <option value="">Sexe</option>
                    <option value="masculin" <?= ($_POST['sexe'] ?? '') === 'masculin' ? 'selected' : '' ?>>Masculin</option>
                    <option value="feminin" <?= ($_POST['sexe'] ?? '') === 'feminin' ? 'selected' : '' ?>>Féminin</option>
                    <option value="ne pas preciser" <?= ($_POST['sexe'] ?? '') === 'ne pas preciser' ? 'selected' : '' ?>>Ne pas préciser</option>
                </select>
                <i class="fa-solid fa-venus-mars"></i>
            </div>
        </div>

        <div class="input-box">
            <input type="text" name="adresse" placeholder="Votre adresse" value="<?= htmlspecialchars($_POST['adresse'] ?? '') ?>">
            <i class="fa-solid fa-location-dot"></i>
        </div>

        <div class="input-box">
            <input type="email" name="email" placeholder="Adresse email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
            <i class="fa-solid fa-envelope"></i>
        </div>

        <div class="input-box">
            <input type="password" name="password" placeholder="Mot de passe (min. 8 caractères)" required>
            <i class="fa-solid fa-lock"></i>
        </div>

        <div class="form-row">
            <div class="input-box half">
                <input type="text" name="code_area" placeholder="Code pays" value="<?= htmlspecialchars($_POST['code_area'] ?? '') ?>">
                <i class="fa-solid fa-globe"></i>
            </div>
            <div class="input-box half">
                <input type="tel" name="telephone" placeholder="Numéro de téléphone" value="<?= htmlspecialchars($_POST['telephone'] ?? '') ?>">
                <i class="fa-solid fa-phone"></i>
            </div>
        </div>

        <button class="login-btn" type="submit">
            <i class="fa-solid fa-user-plus"></i> S'inscrire
        </button>

        <div class="inscription">
            <p>J'ai déjà un compte. <a href="connexion.php">Se connecter</a></p>
        </div>
    </form>
</body>
</html>
