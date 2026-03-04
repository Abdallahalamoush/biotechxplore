<?php require __DIR__ . '/../partials/header.php'; ?>

<div class="breadcrumbs" style="margin-bottom: 20px;">
  <a href="<?= url('/levels') ?>" style="color: var(--text-muted); text-decoration: none; font-weight: 600;">
    ← Back to Academic Pathways
  </a>
</div>

<div style="text-align: center; margin-bottom: 50px;">
    <h1 style="font-size: 2.5rem; margin-bottom: 8px; color: var(--text-main);"><?= htmlspecialchars($level['title']) ?> Curriculum</h1>
    <p class="muted" style="font-size: 1.1rem;">Master the foundations of Data Management in Biosciences.</p>
</div>

<h2 style="color: #8b5cf6; border-bottom: 1px solid var(--border); padding-bottom: 10px;">1. General Knowledge</h2>
<p class="muted" style="margin-bottom: 20px;">Fundamental basics of molecular and cellular biology.</p>
<div class="grid" style="margin-bottom: 50px;">
  <?php if (empty($generalKnowledge)): ?>
    <p class="muted">No modules found.</p>
  <?php endif; ?>
  <?php foreach ($generalKnowledge as $m): ?>
    <a class="card card--link" href="<?= url('/modules/' . $m['slug']) ?>">
      <h3><?= htmlspecialchars($m['title']) ?></h3>
      <?php if (!empty($m['description'])): ?>
        <p class="muted" style="margin-bottom: 0;"><?= htmlspecialchars($m['description']) ?></p>
      <?php endif; ?>
    </a>
  <?php endforeach; ?>
</div>

<h2 style="color: var(--brand-data); border-bottom: 1px solid var(--border); padding-bottom: 10px;">2. Core Chapters</h2>
<p class="muted" style="margin-bottom: 20px;">Deep dives into specific biological systems.</p>
<div class="grid" style="margin-bottom: 50px;">
  <?php if (empty($chapters)): ?>
    <p class="muted">No chapters found.</p>
  <?php endif; ?>
  <?php foreach ($chapters as $m): ?>
    <a class="card card--link" href="<?= url('/modules/' . $m['slug']) ?>">
      <h3><?= htmlspecialchars($m['title']) ?></h3>
      <?php if (!empty($m['description'])): ?>
        <p class="muted" style="margin-bottom: 0;"><?= htmlspecialchars($m['description']) ?></p>
      <?php endif; ?>
    </a>
  <?php endforeach; ?>
</div>

<h2 style="color: var(--success); border-bottom: 1px solid var(--border); padding-bottom: 10px;">3. Quizzes & Assessments</h2>
<p class="muted" style="margin-bottom: 20px;">Test your knowledge across all modules.</p>
<div class="stack" style="margin-bottom: 40px;">
  <?php if (empty($quizzes)): ?>
    <p class="muted">No quizzes available for this level yet.</p>
  <?php endif; ?>
  <?php foreach ($quizzes as $q): ?>
    <a href="<?= url('/lessons/' . $q['slug']) ?>" style="display: flex; justify-content: space-between; align-items: center; padding: 12px 0; border-bottom: 1px solid var(--border); text-decoration: none;">
      <span style="font-weight: 600; color: var(--text-main);"><?= htmlspecialchars($q['title']) ?></span>
      <span class="badge" style="background: rgba(16, 185, 129, 0.1); color: var(--success); border-color: var(--success);">Take Quiz →</span>
    </a>
  <?php endforeach; ?>
</div>

<?php require __DIR__ . '/../partials/footer.php'; ?>