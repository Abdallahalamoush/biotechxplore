<?php require __DIR__ . '/partials/header.php'; ?>

<div style="text-align: center; padding: 60px 20px; max-width: 800px; margin: 0 auto;">
  <div class="badge" style="margin-bottom: 16px; font-size: 12px; background: var(--brand-light); color: var(--brand-bio); border-color: rgba(13, 148, 136, 0.2);">
    Master of Data Management in Biosciences
  </div>
  
  <h1 style="font-size: 3.2rem; margin-top: 0; margin-bottom: 20px; color: var(--text-main); line-height: 1.2; letter-spacing: -0.03em;">
    Master the Flow of <br>
    <span style="color: var(--brand-bio);">Biological Data</span>
  </h1>
  
  <p style="font-size: 1.15rem; margin-bottom: 40px; color: var(--text-muted); line-height: 1.7;">
    An advanced, interactive curriculum designed to bridge the gap between 
    fundamental molecular biology and modern computational data management.
  </p>
  
  <div style="display: flex; gap: 16px; justify-content: center; flex-wrap: wrap;">
    <a href="<?= url('/levels') ?>" class="btn btn--primary" style="font-size: 1.1rem; padding: 14px 28px;">Explore Curriculum</a>
    
    <?php if (!isset($_SESSION['user_id'])): ?>
      <a href="<?= url('/login') ?>" class="btn btn--ghost" style="font-size: 1.1rem; padding: 14px 28px;">Student Login</a>
    <?php endif; ?>
  </div>
</div>

<div style="margin-top: 20px; margin-bottom: 80px;">
  <h2 style="text-align: center; color: var(--text-main); font-size: 1.5rem; margin-bottom: 30px; border-bottom: none;">Why BioTechXplore?</h2>
  
  <div class="grid">
    <div class="card" style="text-align: left;">
      <div style="font-size: 2rem; margin-bottom: 16px;">🧬</div>
      <h3 style="color: var(--brand-bio); margin-bottom: 10px;">Structured Modules</h3>
      <p class="muted" style="margin: 0; font-size: 0.95rem;">Follow a curated academic pathway from foundational cell biology to advanced bioinformatics systems.</p>
    </div>
    
    <div class="card" style="text-align: left;">
      <div style="font-size: 2rem; margin-bottom: 16px;">📊</div>
      <h3 style="color: var(--brand-data); margin-bottom: 10px;">Interactive Assessments</h3>
      <p class="muted" style="margin: 0; font-size: 0.95rem;">Test your retention with dynamic, end-of-module quizzes designed to challenge your understanding.</p>
    </div>
    
    <div class="card" style="text-align: left;">
      <div style="font-size: 2rem; margin-bottom: 16px;">📈</div>
      <h3 style="color: var(--text-main); margin-bottom: 10px;">Track Your Progress</h3>
      <p class="muted" style="margin: 0; font-size: 0.95rem;">Monitor your academic journey, mark lessons as completed, and master the curriculum step-by-step.</p>
    </div>
  </div>
</div>

<?php require __DIR__ . '/partials/footer.php'; ?>