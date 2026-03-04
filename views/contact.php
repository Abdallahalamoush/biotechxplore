<?php require __DIR__ . '/partials/header.php'; ?>

<div class="content" style="max-width: 600px; margin: 40px auto;">
  <h1 style="font-size: 2rem; text-align: center; margin-bottom: 10px;">Contact Us</h1>
  <p class="muted" style="text-align: center; margin-bottom: 30px;">Have questions about the curriculum? Reach out to our academic team.</p>

  <form class="form" method="POST" action="javascript:alert('Thanks for your message! This form is a UI demo for the academic tutor.');">
    <div class="stack">
      <label class="field">
        <span>Name</span>
        <input type="text" name="name" placeholder="John Doe" required>
      </label>
      
      <label class="field">
        <span>University Email</span>
        <input type="email" name="email" placeholder="john.doe@university.edu" required>
      </label>

      <label class="field">
        <span>Message</span>
        <textarea name="message" rows="5" placeholder="How can we help you?" required></textarea>
      </label>

      <button class="btn btn--primary" type="submit" style="margin-top: 16px;">Send Message</button>
    </div>
  </form>
</div>

<?php require __DIR__ . '/partials/footer.php'; ?>