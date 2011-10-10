default:
	@echo "please use:"
	@echo "     'make cs-install' (install CodeSniffer)"
	@echo "     'make cs-uninstall' (uninstall CodeSniffer)"
	@echo "     'make cs-enable' (enable CodeSniffer to check code before every commit)"
	@echo "     'make cs-disable' (disable CodeSniffer code checking)"
	@echo "     'make cs-check-commit' (run pre-commit code checking manually)"
	@echo "     'make cs-check-commit-emacs' (same as cs-check-commit with emacs output)"
	@echo "     'make cs-check-commit-intensive' (run pre-commit code checking"
	@echo "             manually with stricter coding standard)"
	@echo "     'make cs-check-path FPATH=<path>' (run code checking on specific path)"
	@echo "     'make cs-check-path-emacs FPATH=<path>' (same as cs-check-path"
	@echo "             with emacs output)"
	@echo "     'make cs-check-path-full FPATH=<path>' (run intensive code checking on"
	@echo "             specific path)"
	@echo "     'make cs-check-all' (run complete code checking)"
	@echo "     'make cs-check-commit-intensive' (run complete code checking with"
	@echo "             stricter coding standard)"
	@echo "     'make cs-check-blame' (get blame list)"


# coding standard

# #### config ####
# if severity classes were chanced aou must run 'cs-install' again
# standard severity class they must be fulfilled to be able to commit
SEVERITY = 7
# intensive severity class they must not be fulfilled to be able to commit,
# but you are able to check your code with additional coding standards
SEVERITY_INTENSIVE = 5
# checkt filetypes
FILETYPES = php
# path to the Ontowiki Coding Standard
CSPATH = tests/CodeSniffer/Standards/Ontowiki

cs-install: cs-enable
	pear install PHP_CodeSniffer

cs-uninstall: cs-disable

cs-enable:
	ln -s "../../tests/CodeSniffer/pre-commit" .git/hooks/pre-commit

cs-disable:
	rm .git/hooks/pre-commit

cs-check-commit:
	tests/CodeSniffer/pre-commit
cs-check-commit-emacs:
	tests/CodeSniffer/pre-commit -remacs
cs-check-commit-intensive:
	tests/CodeSniffer/pre-commit -s5

cs-check-path:
	phpcs --report=summary --extensions=$(FILETYPES) --severity=$(SEVERITY) -s -p --standard=$(CSPATH) $(FPATH)
cs-check-path-emacs:
	phpcs --report=emacs --extensions=$(FILETYPES) --severity=$(SEVERITY) -s -p --standard=$(CSPATH) $(FPATH)
cs-check-path-full:
	phpcs --report=full --extensions=$(FILETYPES) --severity=$(SEVERITY) -s -p --standard=$(CSPATH) $(FPATH)

cs-check-all:
	phpcs --report=summary --extensions=$(FILETYPES) --severity=$(SEVERITY) -s -p --standard=$(CSPATH) *
cs-check-all-intensive:
	phpcs --report=summary --extensions=$(FILETYPES) --severity=$(SEVERITY_INTENSIVE) -s -p --standard=$(CSPATH) *

cs-check-blame:
	phpcs --report=gitblame --extensions=$(FILETYPES) --severity=$(SEVERITY_INTENSIVE) -s -p --standard=$(CSPATH) *
