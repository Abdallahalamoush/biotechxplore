# BioTechXplore V2 (Starter)

## Objectif
Architecture simple et propre :
- **URLs propres** (`/levels/basic`, `/modules/cell-biology`, `/lessons/intro-to-cells`)
- **Front controller** unique (`public/index.php`)
- **MVC léger** (Controllers / Models / Views)
- Login sécurisé : `password_hash`, `password_verify`, session + CSRF

## Installation rapide (MAMP)
1. Mettre ce dossier dans `.../MAMP/htdocs/BioTechXplore_V2`
2. Dans MAMP, pointer le serveur Apache vers `.../htdocs/BioTechXplore_V2/public` (docroot)
3. Créer la base `biotechxplore` et importer `biotechxplore.sql` (ton export existant)
4. Adapter `app/Core/env.php` :
   - `APP_URL` (ex: `http://localhost:8888`)
   - `DB_DSN` (host + port MAMP, souvent `8889`)
   - `DB_USER`, `DB_PASS`

Compte admin (si tu as gardé ton SQL) :
- email : `admin@biotechxplore.local`
- mot de passe : (celui qui correspond au hash dans ton dump)

## Structure
- `public/` : point d'entrée web + assets
- `app/Core` : router, DB, helpers, auth
- `app/Controllers` : contrôleurs
- `app/Models` : accès DB
- `views/` : templates
