default:
	@echo "please use:"
	@echo "     'make cs-install' (install CodeSniffer)"
	@echo "     'make cs-uninstall' (uninstall CodeSniffer)"
	@echo "     'make cs-enable' (enable CodeSniffer to check code before every commit)"
	@echo "     'make cs-disable' (disable CodeSniffer code checking)"
	@echo "     'make cs-check-commit' (run pre-commit code checking manually)"
	@echo "     'make cs-check-commit-intensive' (run pre-commit code checking"
	@echo "             manually with stricter coding standard)"
	@echo "     'make cs-check-all' (run complete code checking)"
	@echo "     'make cs-check-commit-intensive' (run complete code checking with"
	@echo "             stricter coding standard)"
	@echo "     'make cs-check-blame' (get blame list)"


# coding standard

# #### config ####
# if severity classes were chanced aou must run 'cs-install' again
# standard severity class they must be fulfilled to be able to commit
severity = 7
# intensive severity class they must not be fulfilled to be able to commit,
# but you are able to check your code with additional coding standards
severity_intensive = 5
# checkt filetypes
filetypes = php
# path to the Ontowiki Coding Standard
cspath = tests/CodeSniffer/Standards/Ontowiki

cs-install: cs-enable
	pear install PHP_CodeSniffer

cs-uninstall: cs-disable

cs-enable:
	ln -s "../../tests/CodeSniffer/pre-commit" .git/hooks/pre-commit

cs-disable:
	rm .git/hooks/pre-commit

cs-check-commit:
	tests/CodeSniffer/pre-commit
cs-check-commit-intensive:
	tests/CodeSniffer/pre-commit -s5

cs-check-all:
	phpcs --report=summary --extensions=$(filetypes) --severity=$(severity) -s -p --standard=$(cspath) *
cs-check-all-intensive:
	phpcs --report=summary --extensions=$(filetypes) --severity=$(severity_intensive) -s -p --standard=$(cspath) *

cs-check-blame:
	phpcs --report=gitblame --extensions=$(filetypes) --severity=$(severity_intensive) -s -p --standard=$(cspath) *
