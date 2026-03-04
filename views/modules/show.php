<?php require __DIR__ . '/../partials/header.php'; ?>

<div class="breadcrumbs" style="margin-bottom: 30px; font-size: 0.95rem; display: flex; align-items: center; gap: 8px;">
  <a href="<?= url('/levels') ?>" style="color: var(--text-muted); text-decoration: none; transition: color 0.2s;">Niveaux</a>
  
  <span style="color: var(--border-hover);">/</span>
  
  <a href="<?= url('/levels/' . ($module['level_slug'] ?? 'basic')) ?>" style="color: var(--brand-data); font-weight: 600; text-decoration: none; transition: color 0.2s;">
    <?= htmlspecialchars($module['level_title'] ?? 'Basic') ?> Level
  </a>
  
  <span style="color: var(--border-hover);">/</span>
  
  <span style="color: var(--text-main); font-weight: 500;"><?= htmlspecialchars($module['title']) ?></span>
</div>

<div class="content">
  <h1 style="margin-bottom: 8px; color: var(--text-main);"><?= htmlspecialchars($module['title']) ?></h1>
  
  <?php if (!empty($module['description'])): ?>
    <p class="muted" style="margin-top: 0; margin-bottom: 32px; font-size: 1.1rem;">
      <?= htmlspecialchars($module['description']) ?>
    </p>
  <?php endif; ?>

  <h2 style="border-bottom: 1px solid var(--border); padding-bottom: 10px; margin-bottom: 20px; color: var(--text-main);">Leçons</h2>
  
  <div class="stack">
    <?php if (empty($lessons)): ?>
      <p class="muted">No lessons available for this module yet.</p>
    <?php else: ?>
      <?php foreach ($lessons as $lesson): ?>
        <a class="card card--link" href="<?= url('/lessons/' . $lesson['slug']) ?>" style="padding: 16px 20px; display: flex; align-items: center; justify-content: space-between;">
          <h3 style="margin: 0; font-size: 1.1rem; color: var(--text-main);">
            <?= htmlspecialchars($lesson['title']) ?>
          </h3>
          <span style="color: var(--brand-bio); font-weight: bold;">→</span>
        </a>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</div>

<?php require __DIR__ . '/../partials/footer.php'; ?>