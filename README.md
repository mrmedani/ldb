<p align="center">
  <img src="https://raw.githubusercontent.com/mrmedani/ldb/main/public/favicon.ico" alt="Chronorex Express" width="72">
</p>

<h1 align="center">CHRONOREX EXPRESS</h1>

<p align="center">
  Plateforme de gestion des bureaux — Delivery company, Algeria
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12-FF2D20?logo=laravel" alt="Laravel 12">
  <img src="https://img.shields.io/badge/Livewire-3-FB70A9?logo=livewire" alt="Livewire 3">
  <img src="https://img.shields.io/badge/PHP-8.3-777BB4?logo=php" alt="PHP 8.3">
  <img src="https://img.shields.io/badge/Tailwind-4-06B6D4?logo=tailwindcss" alt="Tailwind v4">
  <img src="https://img.shields.io/badge/Vite-7-646CFF?logo=vite" alt="Vite 7">
  <img src="https://img.shields.io/badge/MySQL-4479A1?logo=mysql" alt="MySQL">
</p>

---

## Aperçu

Application web moderne pour la gestion des bureaux de livraison CHRONOREX EXPRESS à travers les 58 wilayas d'Algérie.

### Fonctionnalités

- **Tableau de bord** — Statistiques en temps réel (total bureaux, visibles, masqués, dernier modifié)
- **Gestion des bureaux** — CRUD complet avec recherche, tri, pagination, sélection multiple, suppression groupée, réordonnancement par drag
- **Formulaire de bureau** — Création/édition avec sélection de wilaya (auto-complétion du code)
- **Paramètres** — Visibilité des colonnes du tableau public, upload logo & favicon
- **Recherche publique** — Interface instantanée avec statistiques (wilayas, bureaux, partenaires)
- **Exportations** — Excel (maatwebsite/excel), PDF (dompdf), Print
- **Authentification** — Single admin user, inscription désactivée
- **Design** — Interface moderne inspirée Stripe/Linear/Notion, Tailwind v4, Lucide icons

## Technologies

| Tech | Version |
|------|---------|
| Laravel | 12.x |
| PHP | 8.3+ |
| Livewire | 3.x |
| Tailwind CSS | 4.x |
| Vite | 7.x |
| Alpine.js | 3.x |
| MySQL / SQLite | (SQLite en dev) |

## Installation

```bash
# Cloner le dépôt
git clone https://github.com/mrmedani/ldb.git
cd ldb

# Installer les dépendances
composer install
npm install

# Configuration
cp .env.example .env
php artisan key:generate

# Base de données (SQLite par défaut)
touch database/database.sqlite
php artisan migrate --seed

# Build assets (production)
npm run build

# Lancer le serveur
php artisan serve
```

### Credentials Admin

- **Email** : `admin@chronorex.dz`
- **Mot de passe** : `password`

### cPanel (Production)

1. Configurer `.env` avec les identifiants MySQL
2. Uploader les fichiers via FTP
3. Définir le document root sur `public/`
4. Exécuter `php artisan migrate --seed`
5. Configurer le cron pour `schedule:run`

## Structure

```
├── app/
│   ├── Exports/            # Export Excel
│   ├── Http/Controllers/   # Dashboard, Settings, Export
│   ├── Livewire/           # OfficeManager, OfficeForm, OfficeSearch
│   ├── Models/             # Office, Wilaya, Setting, User
│   └── Services/           # OfficeService
├── resources/views/
│   ├── admin/              # Dashboard, layouts, offices, settings, exports
│   ├── livewire/           # Composants Livewire
│   └── public/             # Page d'accueil publique
├── routes/
│   ├── web.php             # Routes principales
│   └── auth.php            # Authentification
└── database/
    ├── migrations/         # Wilayas, Offices, Settings
    └── seeders/            # 58 wilayas, admin user
```

## Captures d'écran

*(à venir)*

## Licence

Projet privé — CHRONOREX EXPRESS
