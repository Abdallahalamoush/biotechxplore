<?php
// views/layout.php

use App\Core\Auth;

$success = flash('success');
$error = flash('error');
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?= htmlspecialchars($title ?? env('APP_NAME')) ?></title>
  <link rel="stylesheet" href="/assets/app.css" />
</head>
<body>
  <header class="topbar">
    <div class="container topbar__inner">
      <a class="brand" href="/">BioTechXplore</a>

      <nav class="nav">
        <a href="<?= url('/') ?>" class="nav__link">Accueil</a>
        <a href="<?= url('/levels') ?>" class="nav__link">Niveaux</a>

        <?php if (Auth::check()): ?>
          <form class="nav__form" method="POST" action="<?= url('/logout') ?>">
            <input type="hidden" name="_csrf" value="<?= htmlspecialchars(csrf_token()) ?>" />
            <button class="btn btn--ghost" type="submit">Déconnexion</button>
          </form>
        <?php else: ?>
          <a href="<?= url('/login') ?>" class="btn btn--primary">Connexion</a>
        <?php endif; ?>
      </nav>
      </nav>
    </div>
  </header>

  <main class="container">
    <?php if ($success): ?>
      <div class="alert alert--success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>
    <?php if ($error): ?>
      <div class="alert alert--error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php require $templatePath; ?>
  </main>

  <footer class="footer">
    <div class="container footer__inner">
      <span>© <?= date('Y') ?> BioTechXplore</span>
      <span class="muted">Projet pro — plateforme éducative biotech</span>
    </div>
  </footer>
</body>
</html>
