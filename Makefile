PHPUNIT = ./vendor/bin/phpunit
PHPCS = ./vendor/bin/phpcs
PHPCBF = ./vendor/bin/phpcbf

# Get calid composer executable
COMPOSER = $(shell which composer)
ifeq ($(findstring composer, $(COMPOSER)), )
    COMPOSER = $(shell which composer.phar)
    ifeq ($(findstring composer.phar, $(COMPOSER)), )
        ifneq ($(wildcard composer.phar), )
            COMPOSER = php composer.phar
        else
            COMPOSER =
        endif
    endif
endif

default:
	@echo "please use:"
	@echo ""
	@echo "  test ......................... Execute unit and integration tests"
	@echo "  test-unit .................... Run Erfurt unit tests"
	@echo "  test-unit-cc ................. Same as above plus code coverage report"
	@echo "  test-integration-virtuoso .... Run Erfurt integration tests with virtuoso"
	@echo "  test-integration-virtuoso-cc . Same as above plus code coverage report"
	@echo "  test-integration-mysql ....... Run Erfurt integration tests with mysql"
	@echo "  test-integration-mysql-cc .... Same as above plus code coverage report"
	@echo "  test-clean ................... Clean test cache files, etc."
	@echo "  ----------------------------------------------------------------------"
	@echo "  cs-install ................... install CodeSniffer"
	@echo "  cs-uninstall ................. uninstall CodeSniffer"
	@echo "  cs-enable .................... enable CodeSniffer to check code before"
	@echo "                                 every commit"
	@echo "  cs-disable ................... disable CodeSniffer code checking"
	@echo "  cs-check-commit .............. run pre-commit code checking manually)"
	@echo "  cs-check-commit-emacs' ....... same as above with emacs output)"
	@echo "  cs-check-commit-intensive .... run pre-commit code checking"
	@echo "                                 manually with stricter coding"
	@echo "                                 standard"
	@echo "  cs-check ..................... run complete code checking"
	@echo "  cs-check-full ................ run complete code checking with detailed"
	@echo "                                 output"
	@echo "  cs-check-emacs ............... run complete code checking with with"
	@echo "                                 emacs output"
	@echo "  cs-check-blame ............... run complete code checking with blame"
	@echo "                                 list output"
	@echo "  cs-check-intensive ........... run complete code checking with"
	@echo "                                 stricter coding standard"
	@echo "  cs-check-intensive-full ...... run complete code checking with"
	@echo "                                 stricter coding standard and detailed"
	@echo "                                 output"
	@echo ""
	@echo "  Possible parameters:"
	@echo "   CHECKPATH=<path> (run code checking on specific relative path)"
	@echo "   SNIFFS=<sniff 1>,<sniff 2> (run code checking on specific sniffs)"
	@echo "   OPTIONS=<option> (run code checking with specific CodeSniffer options)"

getcomposer:
	curl -o composer.phar "https://getcomposer.org/composer.phar"
	php composer.phar self-update

ifdef COMPOSER
install: directories composer-install
else
install: getcomposer
	make install
endif

clean:
	rm -rf cache/* logs/*

directories: clean
	mkdir -p logs cache
	chmod 777 logs cache

ifdef COMPOSER
composer-install: #add difference for user and dev (with phpunit etc and without)
	$(COMPOSER) install
else
composer-install:
	@echo
	@echo
	@echo "!!! make $@ failed !!!"
	@echo
	@echo "Sorry, there doesn't seem to be a PHP composer (dependency manager for PHP) on your system!"
	@echo "Please have a look at http://getcomposer.org/ for further information,"
	@echo "or just run 'make getcomposer' to download the composer locally"
	@echo "and run 'make $@' again"
endif

# coding standard
# test stuff
test-directories: directories
	rm -rf tests/cache tests/unit/cache tests/integration/cache
	mkdir tests/cache
	mkdir tests/unit/cache
	mkdir tests/integration/cache

test-unit: test-directories
	$(PHPUNIT) --testsuite "Erfurt Unit Tests"

test-integration-virtuoso: test-directories
	EF_STORE_ADAPTER=virtuoso $(PHPUNIT) --testsuite "Erfurt Virtuoso Integration Tests"

test-integration-mysql: test-directories
	EF_STORE_ADAPTER=zenddb $(PHPUNIT) --testsuite "Erfurt Virtuoso Integration Tests"

test:
	make test-unit
	@echo ""
	@echo "-----------------------------------"
	@echo ""
	make test-integration-virtuoso
	@echo ""
	@echo "-----------------------------------"
	@echo ""
	make test-integration-mysql

codesniffer:
	$(PHPCS) -p

codebeautifier:
	$(PHPCBF)

test-clean:
	rm -rf tests/unit/Erfurt/Sparql/_cache/*
