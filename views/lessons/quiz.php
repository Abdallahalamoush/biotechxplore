<?php require __DIR__ . '/../partials/header.php'; ?>

<div class="breadcrumbs">
  <a href="javascript:history.back()">← Back</a>
</div>

<div class="lesson-header">
  <h1><?= htmlspecialchars($lesson['title'] ?? 'Quiz') ?></h1>

  <?php if ($msg = flash('error')): ?>
    <div class="alert alert--error" style="margin-top:12px;"><?= htmlspecialchars($msg) ?></div>
  <?php endif; ?>

  <?php if ($msg = flash('quiz_result')): ?>
    <div class="alert alert--success" style="margin-top:12px;"><?= htmlspecialchars($msg) ?></div>
  <?php endif; ?>

  <?php if (!empty($latestAttempt)): ?>
    <div class="alert" style="margin-top:12px;">
      Last attempt: <strong><?= (int)$latestAttempt['score'] ?>/<?= (int)$latestAttempt['total'] ?></strong>
      <span class="muted"> (<?= htmlspecialchars($latestAttempt['created_at'] ?? '') ?>)</span>
    </div>
  <?php endif; ?>

  <form method="POST" action="/?r=/progress/toggle" style="margin-top: 12px;">
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

<div class="card quiz-card" style="margin-top: 16px;">
  <h2 style="margin-top:0;">Quiz</h2>
  <p class="muted">Select one answer per question and submit to get your score.</p>

  <form method="POST" action="/?r=/quiz/submit">
    <input type="hidden" name="_csrf" value="<?= htmlspecialchars(csrf_token()) ?>" />
    <!-- ✅ IMPORTANT: QuizController needs lesson_id -->
    <input type="hidden" name="lesson_id" value="<?= (int)($lesson['id'] ?? 0) ?>" />

    <div class="stack" style="margin-top: 12px;">
      <?php foreach (($questions ?? []) as $index => $q): ?>
        <div class="card" style="padding: 14px;">
          <div style="font-weight:700; margin-bottom: 10px;">
            <?= ($index + 1) ?>. <?= htmlspecialchars($q['question_text'] ?? '') ?>
          </div>

          <?php foreach (($q['options'] ?? []) as $opt): ?>
            <label class="quiz-option" style="display:flex; gap:12px; align-items:flex-start;">
              <input
                type="radio"
                name="answers[<?= (int)($q['id'] ?? 0) ?>]"
                value="<?= (int)($opt['id'] ?? 0) ?>"
                required
                style="margin-top:3px;"
              >
              <span><?= htmlspecialchars($opt['option_text'] ?? '') ?></span>
            </label>
          <?php endforeach; ?>

          <?php if (!empty($q['explanation'])): ?>
            <details style="margin-top: 10px;">
              <summary>Show explanation</summary>
              <div class="muted" style="margin-top: 8px;">
                <?= htmlspecialchars($q['explanation']) ?>
              </div>
            </details>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    </div>

    <button class="btn btn--primary" type="submit" style="margin-top: 14px;">
      Submit quiz
    </button>
  </form>
</div>

<?php require __DIR__ . '/../partials/footer.php'; ?>
