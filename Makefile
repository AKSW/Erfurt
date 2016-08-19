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
	@echo "  test-integration-stardog ..... Run Erfurt integration tests with stardog"
	@echo "  test-integration-stardog-cc .. Same as above plus code coverage report"
	@echo "  test-clean ................... Clean test cache files, etc."
	@echo "  ----------------------------------------------------------------------"
	@echo "  codesniffer .................. Run CodeSniffer checks"
	@echo "  codebeautifier ............... Run CodeBeautifier"
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
test-unit: directories
	$(PHPUNIT) --testsuite "Erfurt Unit Tests"

test-unit-cc: directories
	$(PHPUNIT) --testsuite "Erfurt Unit Tests" --coverage-clover ./build/logs/clover.xml --coverage-html ./build/coverage --log-junit ./build/logs/junit.xml

test-integration-virtuoso: directories
	EF_STORE_ADAPTER=virtuoso $(PHPUNIT) --testsuite "Erfurt Integration Tests"

test-integration-virtuoso-cc: directories
	EF_STORE_ADAPTER=virtuoso $(PHPUNIT) --testsuite "Erfurt Integration Tests" --coverage-html ./build/coverage-virtuoso

test-integration-mysql: directories
	EF_STORE_ADAPTER=zenddb $(PHPUNIT) --testsuite "Erfurt Integration Tests"

test-integration-mysql-cc: directories
	EF_STORE_ADAPTER=zenddb $(PHPUNIT) --testsuite "Erfurt Integration Tests" --coverage-html ./build/coverage-mysql

test-integration-stardog: directories
	EF_STORE_ADAPTER=stardog $(PHPUNIT) --testsuite "Erfurt Integration Tests"

test-integration-stardog-cc: directories
	EF_STORE_ADAPTER=stardog $(PHPUNIT) --testsuite "Erfurt Integration Tests" --coverage-html ./build/coverage-stardog

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
	@echo ""
	@echo "-----------------------------------"
	@echo ""
	make test-integration-stardog

codesniffer:
	$(PHPCS) -p

codebeautifier:
	$(PHPCBF)

test-clean:
	rm -rf tests/unit/Erfurt/Sparql/_cache/*
