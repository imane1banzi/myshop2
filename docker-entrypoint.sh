#!/bin/sh
set -e

# Render fournit $PORT, en local défaut 80
export PORT="${PORT:-80}"

# Lien storage (photos produits) si absent
php artisan storage:link --force 2>/dev/null || true

# Migrations indispensables : users.role, orders, promo_codes...
# --force obligatoire en production
php artisan migrate --force

# Création admin initiale (idempotent via updateOrCreate)
php artisan db:seed --class=AdminUserSeeder --force 2>/dev/null || true

# Optimisations production
php artisan config:cache
php artisan route:cache
php artisan view:cache

exec apache2-foreground
