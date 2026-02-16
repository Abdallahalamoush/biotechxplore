<?php require __DIR__ . '/../partials/header.php'; ?>
<h1>Niveaux</h1>
<p class="muted">Choisis un niveau pour voir les modules.</p>

<div class="grid">
  <?php foreach ($levels as $lvl): ?>
    <a class="card card--link" href="<?= url('/levels/' . $lvl['slug']) ?>">
      <h3><?= htmlspecialchars($lvl['title']) ?></h3>
      <div class="badge">ECTS: <?= (int)$lvl['ects'] ?></div>
      <p class="muted">Parcours <?= htmlspecialchars($lvl['slug']) ?> — base → avancé.</p>
    </a>
  <?php endforeach; ?>
</div>


<?php require __DIR__ . '/../partials/footer.php'; ?>
