# Procfile
web: heroku-php-apache2 public/

# composer.json (ajoutez ces scripts)
{
    "scripts": {
        "post-install-cmd": [
            "@auto-scripts"
        ],
        "auto-scripts": {
            "cache:clear": "symfony-cmd",
            "assets:install %PUBLIC_DIR%": "symfony-cmd"
        },
        "compile": [
            "php bin/console doctrine:migrations:migrate --no-interaction"
        ]
    }
}

# apache.conf
<VirtualHost *:80>
    ServerAdmin admin@calculator.com
    DocumentRoot /app/public
    DirectoryIndex /index.php

    <Directory /app/public>
        AllowOverride None
        Order Allow,Deny
        Allow from All

        FallbackResource /index.php
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/calculator_error.log
    CustomLog ${APACHE_LOG_DIR}/calculator_access.log combined
</VirtualHost>