<?php require __DIR__ . '/../partials/header.php'; ?>

<h1>Connexion</h1>
<p class="muted">Utilise le compte admin du SQL (ou crée un utilisateur ensuite).</p>

<?php if ($msg = flash('error')): ?>
  <div class="alert alert--error"><?= htmlspecialchars($msg) ?></div>
<?php endif; ?>

<form class="form" method="post" action="<?= url('/login') ?>">
  <?= csrf_field(); ?>
  
  <label class="field">
    <span>Email</span>
    <input type="email" name="email" required>
  </label>

  <label class="field">
    <span>Mot de passe</span>
    <input type="password" name="password" required>
  </label>

  <div class="hero__actions" style="margin-top: 12px;">
    <button class="btn btn--primary" type="submit">Se connecter</button>
    <a class="btn btn--ghost" href="<?= url('/') ?>">Retour</a>
  </div>
</form>

<?php require __DIR__ . '/../partials/footer.php'; ?>
