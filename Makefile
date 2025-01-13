# Makefile
.PHONY: install test deploy quality init-test

# Variables
SYMFONY = symfony
CONSOLE = php bin/console
COMPOSER = composer
PHPUNIT = php bin/phpunit
PHPCSFIXER = vendor/bin/php-cs-fixer

# Installation du projet
install:
	$(COMPOSER) install
	$(CONSOLE) doctrine:database:create --if-not-exists
	$(CONSOLE) doctrine:schema:update --force
	$(CONSOLE) cache:clear

# Configuration des tests
init-test:
	$(CONSOLE) doctrine:database:create --env=test --if-not-exists
	$(CONSOLE) doctrine:schema:create --env=test
	$(CONSOLE) cache:clear --env=test

# Tests
test: init-test
	$(PHPUNIT)

# Installation et tests
setup: install init-test test

# Qualité du code
quality:
	$(COMPOSER) validate
	$(PHPCSFIXER) fix src --rules=@Symfony --dry-run

# Déploiement
deploy:
	$(COMPOSER) install --no-dev --optimize-autoloader
	$(CONSOLE) cache:clear --env=prod
	$(CONSOLE) doctrine:migrations:migrate --no-interaction --env=prod

# Commandes de développement
dev:
	$(SYMFONY) server:start -d

stop:
	$(SYMFONY) server:stop