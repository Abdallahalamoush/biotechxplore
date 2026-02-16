<?php
/**
 * Configuration d'environnement (MAMP)
 * - phpMyAdmin indique : Server = localhost:8889
 * - Identifiants par défaut MAMP : root / root
 */

return [
    // Base de données
    'DB_HOST' => '127.0.0.1',
    'DB_PORT' => '8889',
    'DB_NAME' => 'biotechxplore',
    'DB_USER' => 'root',
    'DB_PASS' => 'root',

    // Optionnel (si tu veux)
    'APP_ENV' => 'dev',
    'APP_DEBUG' => true,
];
