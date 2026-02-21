<?php require __DIR__ . '/partials/header.php'; ?>

<section class="hero">
  <div class="hero__content">
    <h1>Apprendre la biotech, niveau par niveau.</h1>
    <p class="lead">
      Trois parcours : <strong>Basic</strong>, <strong>Intermediate</strong> et <strong>Advanced</strong>.
      Chaque module contient des leçons courtes, avec suivi de progression.
    </p>

    <div class="hero__actions">
      <a class="btn btn--primary" href="<?= url('/levels') ?>">Voir les niveaux</a>
      <a class="btn btn--ghost" href="<?= url('/login') ?>">Se connecter</a>
    </div>
  </div>

  <div class="hero__card">
    <div class="card">
      <h3>Objectif du projet</h3>
      <p class="muted">Site éducatif — contenu fourni par le tuteur/prof.</p>
      <ul class="list">
        <li>Chapitres + leçons</li>
        <li>Progression par utilisateur</li>
        <li>Design simple & propre</li>
      </ul>
    </div>
  </div>
</section>

<?php require __DIR__ . '/partials/footer.php'; ?>
