# CHRONOREX EXPRESS — Project Map

> Dernière mise à jour : 2026-06-21
> Statut : Production-Ready

---

## [TECH_STACK]

| Technologie | Version | Statut |
|---|---|---|
| Laravel | 12.12.2 (skeleton) / 12.62.0 (framework) | ✅ |
| PHP | 8.3.14 | ✅ |
| Livewire | 3.8.1 | ✅ |
| Alpine.js | 3.15.12 (via Livewire) | ✅ |
| Tailwind CSS | 4.3.1 | ✅ |
| Vite | 7.3.5 | ✅ |
| Lucide Icons | 1.21.0 | ✅ |
| Laravel Breeze | 2.4.2 (Livewire stack) | ✅ |
| maatwebsite/excel | 3.1.69 | ✅ |
| barryvdh/laravel-dompdf | 3.1.2 | ✅ |
| MySQL | 8.0+ (production) / SQLite (dev) | ✅ |

## [SYSTEM_FLOW]

```
VISITEUR (non authentifié)
  └─ GET / → Public/HomeController
       └─ Livewire: Public/OfficeSearch
            └─ Offices visibles + Settings columns
            └─ Recherche instantanée, tri, pagination

ADMINISTRATEUR (authentifié)
  └─ GET /login → Breeze Volt Auth
  └─ GET /admin → DashboardController (stats)
  └─ GET /admin/offices → Livewire: Admin/OfficeManager
       ├─ CRUD table with search/filter/sort
       ├─ Multi-select, bulk delete, bulk visibility
       ├─ Drag & drop reorder (up/down)
       ├─ Toggle visibility ON/OFF
       └─ Export Excel / PDF / Print
  └─ GET /admin/offices/create → Livewire: Admin/OfficeForm
  └─ GET /admin/offices/{id}/edit → Livewire: Admin/OfficeForm
  └─ GET /admin/settings → SettingController (columns visibility)
  └─ GET/POST profile → Breeze Volt Profile
```

## [ARCHITECTURE]

```
app/
├── Exports/
│   └── OfficesExport.php                    # Maatwebsite Excel export
├── Http/
│   ├── Controllers/
│   │   ├── Admin/
│   │   │   ├── DashboardController.php      # Stats dashboard
│   │   │   ├── ExportController.php         # Excel/PDF/Print downloads
│   │   │   └── SettingController.php        # Settings CRUD
│   │   └── Public/
│   │       └── HomeController.php           # Public landing page
│   ├── Livewire/
│   │   ├── Admin/
│   │   │   ├── OfficeManager.php            # CRUD table w/ search/filter
│   │   │   └── OfficeForm.php               # Create/Edit form
│   │   └── Public/
│   │       └── OfficeSearch.php             # Public search + table
│   └── Requests/
│       ├── StoreOfficeRequest.php           # Creation validation
│       └── UpdateOfficeRequest.php          # Update validation
├── Models/
│   ├── User.php                             # Breeze default
│   ├── Wilaya.php                           # HasMany Office
│   ├── Office.php                           # BelongsTo Wilaya, scopeVisible
│   └── Setting.php                          # Singleton with cache
├── Policies/
│   └── OfficePolicy.php                     # Authorization (admin only)
├── Services/
│   └── OfficeService.php                    # Reorder, bulk delete, toggle
database/
├── migrations/
│   ├── xxxx_create_wilayas_table.php
│   ├── xxxx_create_offices_table.php
│   └── xxxx_create_settings_table.php
└── seeders/
    ├── DatabaseSeeder.php                   # Admin user + calls below
    ├── WilayaSeeder.php                     # 58 wilayas d'Algérie
    └── SettingSeeder.php                    # Default visible columns
resources/views/
├── admin/
│   ├── layouts/admin.blade.php              # Sidebar + header layout
│   ├── dashboard.blade.php                  # Stats cards
│   ├── offices/{index,create,edit}.blade.php
│   ├── settings/index.blade.php             # Column visibility toggles
│   └── exports/{offices-pdf,offices-print}.blade.php
├── public/
│   ├── layouts/public.blade.php             # Public header + footer
│   └── home.blade.php                       # Landing page
├── livewire/
│   ├── admin/{office-manager,office-form}.blade.php
│   ├── public/office-search.blade.php
│   └── layout/navigation.blade.php          # Breeze top nav (updated)
├── components/                              # Breeze components
└── vendor/pagination/                       # Tailwind pagination
routes/
├── web.php                                  # Public + Admin routes
└── auth.php                                 # Breeze auth (register disabled)
```

## [ORPHANS & PENDING]

| État | Élément | Note |
|---|---|---|
| ✅ | Logo CHRONOREX EXPRESS | Placeholder "CR" dans le header, à remplacer par le logo fourni |
| ✅ | Google Maps API | Liens directs (pas d'API key nécessaire) |
| ✅ | Hébergement cPanel | .env.example prêt pour MySQL |
| ✅ | Drag & drop natif | Up/down buttons (SortableJS via Alpine optionnel) |

## [VERIFIABLE GOALS STATUS]

| # | Objectif | Statut |
|---|---|---|
| VG1 | Setup Laravel + Breeze | ✅ |
| VG2 | Migrations + Seeder | ✅ 58 wilayas |
| VG3 | Dashboard admin | ✅ Stats exactes |
| VG4 | CRUD bureaux | ✅ Create/Read/Update/Delete |
| VG5 | Reorder | ✅ Up/down buttons |
| VG6 | Visibilité toggle | ✅ Switch ON/OFF |
| VG7 | Settings | ✅ Checkbox columns cache |
| VG8 | Page publique | ✅ Search, sort, paginate |
| VG9 | Export | ✅ Excel + PDF + Print |
| VG10 | Sécurité | ✅ Policies, Form Requests, CSRF |
| VG11 | Déploiement cPanel | ✅ .env.example, build assets |

## [COMPTES DE TEST]

```
Admin: admin@chronorex.dz / password
```
