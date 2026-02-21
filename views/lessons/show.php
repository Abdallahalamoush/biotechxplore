<?php require __DIR__ . '/../partials/header.php'; ?>

<div class="breadcrumbs">
  <a href="javascript:history.back()">← Back</a>
</div>

<div class="lesson-header">
  <h1><?= htmlspecialchars($lesson['title'] ?? 'Lesson') ?></h1>

  <?php if ($msg = flash('success')): ?>
    <div class="alert alert--success" style="margin-top:12px;">
      <?= htmlspecialchars($msg) ?>
    </div>
  <?php endif; ?>

  <?php if ($msg = flash('error')): ?>
    <div class="alert alert--error" style="margin-top:12px;">
      <?= htmlspecialchars($msg) ?>
    </div>
  <?php endif; ?>

  <form method="POST" action="<?= url('/progress/toggle') ?>" style="margin-top: 12px;">
    <input type="hidden" name="_csrf" value="<?= htmlspecialchars(csrf_token()) ?>" />
    <input type="hidden" name="lesson_slug" value="<?= htmlspecialchars($lesson['slug'] ?? '') ?>" />

    <?php if (!empty($isCompleted)): ?>
      <input type="hidden" name="action" value="undone" />
      <button class="btn btn--ghost" type="submit">Mark as not done</button>
    <?php else: ?>
      <input type="hidden" name="action" value="done" />
      <button class="btn btn--primary" type="submit">Mark as done</button>
    <?php endif; ?>
  </form>
</div>

<div class="content" style="margin-top: 16px;">
  <?php
    echo $lesson['content_html'] ?? '<p class="muted">Content coming soon.</p>';
  ?>
</div>

<?php require __DIR__ . '/../partials/footer.php'; ?>