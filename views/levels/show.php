<?php require __DIR__ . '/../partials/header.php'; ?>

<div class="breadcrumbs">
  <a href="<?= url('/levels') ?>">← Retour</a>
</div>

<h1><?= htmlspecialchars($level['title']) ?></h1>
<p class="muted">Modules du niveau <strong><?= htmlspecialchars($level['slug']) ?></strong>.</p>

<div class="grid">
  <?php if (empty($modules)): ?>
    <div class="card">
      <p class="muted">Aucun module pour le moment.</p>
    </div>
  <?php endif; ?>

  <?php foreach ($modules as $m): ?>
    <a class="card card--link" href="<?= url('/modules/' . $m['slug']) ?>">
      <h3><?= htmlspecialchars($m['title']) ?></h3>
      <?php if (!empty($m['description'])): ?>
        <p class="muted"><?= htmlspecialchars($m['description']) ?></p>
      <?php endif; ?>
      <div class="badge">ECTS: <?= (int)$m['ects'] ?></div>
    </a>
  <?php endforeach; ?>
</div>

<?php require __DIR__ . '/../partials/footer.php'; ?>
