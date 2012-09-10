ZENDVERSION=1.11.5

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
	@echo "   FPATH=<path> (run code checking on specific relative path)"
	@echo "   SNIFFS=<sniff 1>,<sniff 2> (run code checking on specific sniffs)"
	@echo "   OPTIONS=<option> (run code checking with specific CodeSniffer options)"
		
clean:
	rm -rf cache/* logs/*

directories: clean
	mkdir -p logs cache
	chmod 777 logs cache

zend:
	rm -rf library/Zend
	curl -# -O http://framework.zend.com/releases/ZendFramework-${ZENDVERSION}/ZendFramework-${ZENDVERSION}-minimal.tar.gz || wget http://framework.zend.com/releases/ZendFramework-${ZENDVERSION}/ZendFramework-${ZENDVERSION}-minimal.tar.gz
	tar xzf ZendFramework-${ZENDVERSION}-minimal.tar.gz
	mv ZendFramework-${ZENDVERSION}-minimal/library/Zend library
	rm -rf ZendFramework-${ZENDVERSION}-minimal.tar.gz ZendFramework-${ZENDVERSION}-minimal

# coding standard

# #### config ####
# cs-script path
CSSPATH = tests/CodeSniffer/
# ignore pattern
IGNOREPATTERN = */libraries/*,*/Parser/Sparql10/*,*/Parser/Sparql11/*

# Parameter check
ifndef FPATH
	FPATH = "./"
endif
ifdef SNIFFS
	SNIFFSTR = "--sniffs="$(SNIFFS)
else
	SNIFFSTR =
endif

REQUESTSTR = --ignore=$(IGNOREPATTERN) $(OPTIONS) $(SNIFFSTR)  $(FPATH)

cs-default:
	chmod ugo+x "$(CSSPATH)cs-scripts.sh"
	
cs-install: cs-default
	$(CSSPATH)cs-scripts.sh -i

cs-uninstall: cs-default
	$(CSSPATH)cs-scripts.sh -u

cs-enable: cs-default
	$(CSSPATH)cs-scripts.sh -f $(CSSPATH) -e

cs-disable: cs-default
	$(CSSPATH)cs-scripts.sh -d

cs-check-commit:
	$(CSSPATH)cs-scripts.sh -p ""
cs-check-commit-emacs:
	$(CSSPATH)cs-scripts.sh -p "-remacs"
cs-check-commit-intensive:
	$(CSSPATH)cs-scripts.sh -p "-s"

cs-check:
	$(CSSPATH)cs-scripts.sh -c "-s --report=summary $(REQUESTSTR)"
cs-check-intensive:
	$(CSSPATH)cs-scripts.sh -s -c "-s --report=summary $(REQUESTSTR)"
cs-check-intensive-full:
	$(CSSPATH)cs-scripts.sh -s -c "-s --report=full $(REQUESTSTR)"
cs-check-full:
	$(CSSPATH)cs-scripts.sh -c "-s --report=full $(REQUESTSTR)"
cs-check-emacs:
	$(CSSPATH)cs-scripts.sh -c "--report=emacs $(REQUESTSTR)"
cs-check-blame:
	$(CSSPATH)cs-scripts.sh -s -c "--report=gitblame $(REQUESTSTR)"

# test stuff

test-unit: directories
	@cd tests && phpunit --bootstrap Bootstrap.php unit/

test-unit-cc: directories
	@cd tests/unit && phpunit

test-integration-virtuoso: directories
	@cd tests && EF_STORE_ADAPTER=virtuoso phpunit --bootstrap Bootstrap.php integration/

test-integation-virtuoso-cc: directories
	@cd tests/integration && EF_STORE_ADAPTER=virtuoso phpunit

test-integration-mysql: directories
	@cd tests && EF_STORE_ADAPTER=zenddb phpunit --bootstrap Bootstrap.php integration/

test-integation-mysql-cc: directories
	@cd tests/integration && EF_STORE_ADAPTER=zenddb phpunit

test:
	@make test-unit
	@echo ""
	@echo "-----------------------------------"
	@echo ""
	@make test-integration-virtuoso
	@echo ""
	@echo "-----------------------------------"
	@echo ""
	@make test-integration-mysql

test-clean:
	rm -rf tests/unit/Erfurt/Sparql/_cache/*
