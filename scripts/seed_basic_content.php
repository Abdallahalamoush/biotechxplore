<?php
/**
 * scripts/seed_basic_content.php
 *
 * Usage (recommended):
 *   php scripts/seed_basic_content.php
 *
 * What it does:
 * - Reads scripts/basic_lessons_content.json
 * - UPDATE lessons by slug (title, content_html, order_index)
 * - If a lesson slug does not exist yet, it INSERTS it (requires module_slug in JSON)
 *
 * Notes:
 * - Works with your schema: lessons(title, content_html, slug, module_id, order_index)
 * - Does NOT require Apache rewrite rules (this is CLI).
 */

declare(strict_types=1);

$root = dirname(__DIR__); // project root, if this file is in /scripts
$envFile = $root . '/app/Core/env.php';
$jsonFile = __DIR__ . '/basic_lessons_content.json';

if (!file_exists($envFile)) {
    fwrite(STDERR, "env.php not found at: $envFile\n");
    exit(1);
}
if (!file_exists($jsonFile)) {
    fwrite(STDERR, "JSON not found at: $jsonFile\n");
    exit(1);
}

$env = require $envFile;

$host = $env['DB_HOST'] ?? '127.0.0.1';
$port = $env['DB_PORT'] ?? '8889';
$db   = $env['DB_NAME'] ?? 'biotechxplore';
$user = $env['DB_USER'] ?? 'root';
$pass = $env['DB_PASS'] ?? 'root';

$dsn = "mysql:host={$host};port={$port};dbname={$db};charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    fwrite(STDERR, "DB connection error: " . $e->getMessage() . "\n");
    exit(1);
}

$data = json_decode(file_get_contents($jsonFile), true);
if (!is_array($data)) {
    fwrite(STDERR, "Invalid JSON\n");
    exit(1);
}

$selectLesson = $pdo->prepare("SELECT id FROM lessons WHERE slug = :slug LIMIT 1");
$updateLesson = $pdo->prepare("
    UPDATE lessons
       SET title = :title,
           content_html = :content_html,
           order_index = :order_index
     WHERE slug = :slug
");
$insertLesson = $pdo->prepare("
    INSERT INTO lessons (module_id, slug, title, content_html, order_index)
    VALUES (:module_id, :slug, :title, :content_html, :order_index)
");

$selectModule = $pdo->prepare("SELECT id FROM modules WHERE slug = :slug LIMIT 1");

$updated = 0;
$inserted = 0;

foreach ($data as $row) {
    $slug = $row['slug'] ?? null;
    $title = $row['title'] ?? '';
    $contentHtml = $row['content_html'] ?? '';
    $orderIndex = (int)($row['order_index'] ?? 0);
    $moduleSlug = $row['module_slug'] ?? null;

    if (!$slug) continue;

    $selectLesson->execute([':slug' => $slug]);
    $existing = $selectLesson->fetch();

    if ($existing) {
        $updateLesson->execute([
            ':slug' => $slug,
            ':title' => $title,
            ':content_html' => $contentHtml,
            ':order_index' => $orderIndex,
        ]);
        $updated++;
        continue;
    }

    // If missing, we can insert if we know module_slug
    if (!$moduleSlug) {
        fwrite(STDERR, "Skipping insert for '$slug' (missing module_slug)\n");
        continue;
    }

    $selectModule->execute([':slug' => $moduleSlug]);
    $m = $selectModule->fetch();
    if (!$m) {
        fwrite(STDERR, "Module not found for '$slug': module_slug='$moduleSlug'\n");
        continue;
    }

    $insertLesson->execute([
        ':module_id' => (int)$m['id'],
        ':slug' => $slug,
        ':title' => $title,
        ':content_html' => $contentHtml,
        ':order_index' => $orderIndex,
    ]);
    $inserted++;
}

echo "Done.\n";
echo "Updated:  $updated\n";
echo "Inserted: $inserted\n";
