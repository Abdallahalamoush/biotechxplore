<?php require __DIR__ . '/../partials/header.php'; ?>

<div style="text-align: center; margin-bottom: 50px; margin-top: 20px;">
  <h1 style="font-size: 2.5rem; margin-bottom: 16px; color: var(--text-main);">Academic Pathways</h1>
  <p class="muted" style="max-width: 600px; margin: 0 auto; font-size: 1.1rem;">
    Select your proficiency level below. Each pathway contains curated chapters, foundational knowledge, and rigorous assessments.
  </p>
</div>

<div class="grid" style="gap: 30px;">
  <?php if (empty($levels)): ?>
    <div class="card">
      <p class="muted">No levels are currently available.</p>
    </div>
  <?php else: ?>
    <?php foreach ($levels as $lvl): ?>
      <a class="card card--link" href="<?= url('/levels/' . $lvl['slug']) ?>" style="display: flex; flex-direction: column; justify-content: space-between; min-height: 200px;">
        
        <div>
          <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 16px;">
            <h2 style="margin: 0; color: var(--brand-bio); font-size: 1.6rem; border: none; padding: 0;">
              <?= htmlspecialchars($lvl['title']) ?> Level
            </h2>
            <span class="badge" style="background: var(--brand-light); color: var(--brand-bio); border: none;">View Program</span>
          </div>

          <p class="muted" style="font-size: 1rem; line-height: 1.6;">
            <?php 
              // We inject beautiful descriptions based on the level name!
              $slug = strtolower($lvl['slug']);
              if ($slug === 'basic') {
                  echo "Establish your core understanding. Covers fundamental concepts in molecular biology, cellular organization, and biomolecules.";
              } elseif ($slug === 'intermediate') {
                  echo "Dive deeper into advanced cellular mechanisms, complex metabolic pathways, and an introduction to biological data structures.";
              } elseif ($slug === 'advanced') {
                  echo "Master the curriculum with complex bioinformatics, data management strategies, and real-world computational biology applications.";
              } else {
                  echo "Explore the specialized modules, chapters, and quizzes within this academic level.";
              }
            ?>
          </p>
        </div>

        <div style="margin-top: 24px; border-top: 1px solid var(--border); padding-top: 16px; display: flex; align-items: center; gap: 10px;">
           <span style="display: inline-block; width: 8px; height: 8px; border-radius: 50%; background: var(--success);"></span>
           <span style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">Status: Active Enrollment</span>
        </div>

      </a>
    <?php endforeach; ?>
  <?php endif; ?>
</div>

<?php require __DIR__ . '/../partials/footer.php'; ?>