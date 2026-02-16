<?php

namespace App\Models;

use App\Core\DB;

class Module
{
    public static function findBySlug(string $slug): ?array
    {
        $stmt = DB::pdo()->prepare('SELECT * FROM modules WHERE slug = :slug LIMIT 1');
        $stmt->execute(['slug' => $slug]);
        $m = $stmt->fetch();
        return $m ?: null;
    }

    public static function lessons(int $moduleId): array
    {
        $stmt = DB::pdo()->prepare('SELECT * FROM lessons WHERE module_id = :id ORDER BY order_index ASC, id ASC');
        $stmt->execute(['id' => $moduleId]);
        return $stmt->fetchAll();
    }
}
