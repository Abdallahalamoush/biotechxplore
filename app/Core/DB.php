<?php

namespace App\Core;

use PDO;
use RuntimeException;

final class DB
{
    private static ?PDO $pdo = null;

    /**
     * Initialise PDO (appelé depuis bootstrap.php)
     */
    public static function init(PDO $pdo): void
    {
        self::$pdo = $pdo;
    }

    /**
     * Retourne PDO
     */
    public static function pdo(): PDO
    {
        // Si bootstrap a mis $GLOBALS['DB'], on le récupère automatiquement
        if (self::$pdo === null && isset($GLOBALS['DB']) && $GLOBALS['DB'] instanceof PDO) {
            self::$pdo = $GLOBALS['DB'];
        }

        if (self::$pdo === null) {
            throw new RuntimeException("DB non initialisée");
        }

        return self::$pdo;
    }
}
