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

codesniffer:
	$(PHPCS) -p

codebeautifier:
	$(PHPCBF)

test-clean:
	rm -rf tests/unit/Erfurt/Sparql/_cache/*
