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

# Apache doit écouter le $PORT de Render (défaut 80 en local).
# Remplacement au démarrage car Apache ne comprend pas ${PORT:-80} dans ports.conf.
sed -i "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/000-default.conf

# Si Render passe un Start Command en argument, l'exécuter, sinon Apache
if [ $# -gt 0 ]; then
  exec "$@"
else
  exec apache2-foreground
fi
