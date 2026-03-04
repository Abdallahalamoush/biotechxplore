<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars($title ?? 'BioTechXplore') ?></title>
  <link rel="stylesheet" href="/assets/css/app.css">
</head>
<body>
  <header class="topbar">
    <div class="topbar__inner">
      <a class="brand" href="<?= url('/') ?>">BioTechXplore</a>
      <nav class="nav">
        <a href="<?= url('/levels') ?>">Niveaux</a>
        <a href="<?= url('/about') ?>">About Us</a>
        <a href="<?= url('/contact') ?>">Contact</a>
        <a href="<?= url('/login') ?>">Login</a>
      </nav>
    </div>
  </header>

  <main class="container">
