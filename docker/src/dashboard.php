<?php
require_once 'config.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: connexion.php');
    exit;
}

// Récupérer les informations complètes de l'utilisateur
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/e48c9d260c.js" crossorigin="anonymous"></script>
    <title>Tableau de bord</title>
</head>
<body>
    <div class="dashboard-container">
        <div class="dashboard-header">
            <h1><i class="fa-solid fa-house"></i> Bienvenue, <?= htmlspecialchars($user['prenom']) ?> !</h1>
            <a href="logout.php" class="logout-btn">
                <i class="fa-solid fa-right-from-bracket"></i> Déconnexion
            </a>
        </div>
        
        <div class="dashboard-content">
            <div class="info-card">
                <h2><i class="fa-solid fa-user-circle"></i> Informations personnelles</h2>
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label"><i class="fa-solid fa-user"></i> Nom complet :</span>
                        <span class="info-value"><?= htmlspecialchars($user['prenom'] . ' ' . $user['nom']) ?></span>
                    </div>
                    
                    <div class="info-item">
                        <span class="info-label"><i class="fa-solid fa-envelope"></i> Email :</span>
                        <span class="info-value"><?= htmlspecialchars($user['email']) ?></span>
                    </div>
                    
                    <?php if ($user['age']): ?>
                    <div class="info-item">
                        <span class="info-label"><i class="fa-solid fa-calendar"></i> Âge :</span>
                        <span class="info-value"><?= htmlspecialchars($user['age']) ?> ans</span>
                    </div>
                    <?php endif; ?>
                    
                    <?php if ($user['sexe']): ?>
                    <div class="info-item">
                        <span class="info-label"><i class="fa-solid fa-venus-mars"></i> Sexe :</span>
                        <span class="info-value"><?= htmlspecialchars(ucfirst($user['sexe'])) ?></span>
                    </div>
                    <?php endif; ?>
                    
                    <?php if ($user['adresse']): ?>
                    <div class="info-item">
                        <span class="info-label"><i class="fa-solid fa-location-dot"></i> Adresse :</span>
                        <span class="info-value"><?= htmlspecialchars($user['adresse']) ?></span>
                    </div>
                    <?php endif; ?>
                    
                    <?php if ($user['telephone']): ?>
                    <div class="info-item">
                        <span class="info-label"><i class="fa-solid fa-phone"></i> Téléphone :</span>
                        <span class="info-value"><?= htmlspecialchars(($user['code_area'] ? $user['code_area'] . ' ' : '') . $user['telephone']) ?></span>
                    </div>
                    <?php endif; ?>
                    
                    <div class="info-item">
                        <span class="info-label"><i class="fa-solid fa-clock"></i> Membre depuis :</span>
                        <span class="info-value"><?= date('d/m/Y', strtotime($user['date_inscription'])) ?></span>
                    </div>
                    
                    <?php if ($user['derniere_connexion']): ?>
                    <div class="info-item">
                        <span class="info-label"><i class="fa-solid fa-right-to-bracket"></i> Dernière connexion :</span>
                        <span class="info-value"><?= date('d/m/Y à H:i', strtotime($user['derniere_connexion'])) ?></span>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="actions-card">
                <h2><i class="fa-solid fa-gear"></i> Actions rapides</h2>
                <div class="actions-grid">
                    <a href="#" class="action-btn">
                        <i class="fa-solid fa-user-pen"></i>
                        <span>Modifier mon profil</span>
                    </a>
                    <a href="#" class="action-btn">
                        <i class="fa-solid fa-lock"></i>
                        <span>Changer le mot de passe</span>
                    </a>
                    <a href="#" class="action-btn">
                        <i class="fa-solid fa-bell"></i>
                        <span>Notifications</span>
                    </a>
                    <a href="#" class="action-btn">
                        <i class="fa-solid fa-shield-halved"></i>
                        <span>Sécurité</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
