<?php

namespace App\Models;

use App\Core\DB;

class Level
{
    public static function all(): array
    {
        $stmt = DB::pdo()->query('SELECT * FROM levels ORDER BY order_index ASC, id ASC');
        return $stmt->fetchAll();
    }

    public static function findBySlug(string $slug): ?array
    {
        $stmt = DB::pdo()->prepare('SELECT * FROM levels WHERE slug = :slug LIMIT 1');
        $stmt->execute(['slug' => $slug]);
        $level = $stmt->fetch();
        return $level ?: null;
    }

    public static function modules(int $levelId): array
    {
        $stmt = DB::pdo()->prepare('SELECT * FROM modules WHERE level_id = :id ORDER BY order_index ASC, id ASC');
        $stmt->execute(['id' => $levelId]);
        return $stmt->fetchAll();
    }
}
