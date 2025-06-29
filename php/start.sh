#!/bin/bash

# Wait for the database to be ready
echo "⏳ Waiting for database to be ready..."
until mysqladmin ping -h database --silent; do
    sleep 1
done
echo "✅ Database is up."

# Run Doctrine migrations
echo "🚀 Running doctrine migrations..."
php /var/www/symfony_docker/bin/console doctrine:migrations:migrate --no-interaction

# Then start supervisord
echo "🧭 Starting Supervisor."
exec /usr/bin/supervisord -c /etc/supervisor/supervisord.conf
