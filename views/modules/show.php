<?php require __DIR__ . '/../partials/header.php'; ?>
<div class="breadcrumbs">
  <a href="<?= url('/levels') ?>">← Niveaux</a>
</div>

<h1><?= htmlspecialchars($module['title']) ?></h1>
<?php if (!empty($module['description'])): ?>
  <p class="muted"><?= htmlspecialchars($module['description']) ?></p>
<?php endif; ?>

<h2 class="section-title">Leçons</h2>

<div class="stack">
  <?php if (empty($lessons)): ?>
    <div class="card">
      <p class="muted">Aucune leçon pour le moment.</p>
    </div>
  <?php endif; ?>

  <?php foreach ($lessons as $l): ?>
    <a class="card card--link" href="<?= url('/lessons/' . $l['slug']) ?>">
      <div class="row">
        <strong><?= htmlspecialchars($l['title']) ?></strong>
        <span class="muted">#<?= (int)$l['order_index'] ?></span>
      </div>
    </a>
  <?php endforeach; ?>
</div>


<?php require __DIR__ . '/../partials/footer.php'; ?>
