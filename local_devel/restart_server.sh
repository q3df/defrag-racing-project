#!/bin/sh

# ./vendor/bin/sail stop
# ./vendor/bin/sail up -d

# this is from hejazi script
# ./vendor/bin/sail artisan storage:link --force
# ./vendor/bin/sail artisan filament:assets
# ./vendor/bin/sail artisan config:cache
# ./vendor/bin/sail artisan route:cache
# ./vendor/bin/sail artisan view:cache
# ./vendor/bin/sail artisan icons:cache
# ./vendor/bin/sail artisan octane:reload
# ./vendor/bin/sail artisan queue:restart

# my own
# ./vendor/bin/sail artisan optimize:clear
# ./vendor/bin/sail artisan optimize
# ./vendor/bin/sail artisan cache:clear
# ./vendor/bin/sail artisan route:clear
# ./vendor/bin/sail artisan config:clear

# after vue changes
./vendor/bin/sail npm run build
./vendor/bin/sail stop
./vendor/bin/sail up -d
