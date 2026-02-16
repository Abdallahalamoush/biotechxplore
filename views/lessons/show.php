<?php require __DIR__ . '/../partials/header.php'; ?>

<div class="breadcrumbs">
  <a href="javascript:history.back()">← Back</a>
</div>

<div class="lesson-header">
  <h1><?= htmlspecialchars($lesson['title'] ?? 'Lesson') ?></h1>

  <!-- ✅ Flash messages -->
  <?php if ($msg = flash('quiz_result')): ?>
    <div class="alert alert--success" style="margin-top:12px;">
      <?= htmlspecialchars($msg) ?>
    </div>
  <?php endif; ?>

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

  <!-- ✅ Progress toggle -->
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

<?php
  // Detect quiz mode if controller passes $questions
  $isQuiz = isset($questions) && is_array($questions) && count($questions) > 0;
?>

<?php if ($isQuiz): ?>

  <!-- =========================
       QUIZ VIEW (Option B)
       ========================= -->
  <div class="card quiz-card" style="margin-top:16px;">
    <h2 style="margin-top:0;">Quiz</h2>
    <p class="muted">Choose one answer per question, then submit to get your score.</p>

    <form method="POST" action="/?r=/quiz/submit">
      <input type="hidden" name="_csrf" value="<?= htmlspecialchars(csrf_token()) ?>" />
      <input type="hidden" name="lesson_id" value="<?= (int)($lesson['id'] ?? 0) ?>" />

      <div class="stack" style="margin-top: 12px;">
        <?php foreach ($questions as $idx => $q): ?>
          <div class="card" style="padding: 14px;">
            <div style="font-weight:700; margin-bottom: 10px;">
              <?= ($idx + 1) ?>. <?= htmlspecialchars($q['question_text'] ?? '') ?>
            </div>

            <?php if (!empty($q['options']) && is_array($q['options'])): ?>
              <div class="stack">
                <?php foreach ($q['options'] as $opt): ?>
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
              </div>
            <?php else: ?>
              <p class="muted">No options for this question.</p>
            <?php endif; ?>

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

<?php else: ?>

  <!-- =========================
       NORMAL CONTENT VIEW
       ========================= -->
  <div class="content" style="margin-top: 16px;">
    <?php
      echo $lesson['content_html'] ?? '<p class="muted">Content coming soon.</p>';
    ?>
  </div>

<?php endif; ?>

<?php require __DIR__ . '/../partials/footer.php'; ?>
