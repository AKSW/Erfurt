# Change Log
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/)
and this project adheres to [Semantic Versioning](http://semver.org/) as of version 1.8.0.

## [1.8.0] - 2016-09-12

### Added
- Add option to export SPARQL result to CSV
- SPARQL: allow less operator in filter clauses and don't switch to uri mode there
- SPARQL: remove whitespace constraint on filter clause
- SPARQL: change strategy for less operator detection * enable tokenizer test case
- Add simple test for Erfurt_Store_Adapter_Virtuoso_ResultConverter_CSV
- Allow test cases to inject config parameters into the config
- Add Unit Tests for Store
- Add a further syntax test resource
- Add support for travis CI (#114)
- Add missing method to access control adapter
- Implement Stardog as Backend Adapter (#122)

### Changed
- Composerize Erfurt
- Makefile: removed old cs-commands, added codesniffer and codebeautifier
- Improve error reporting for failing virtuoso odbc requests
- Forward zend version
- Improve codesniffer handling and file comment sniff
- Erfurt_Sparql_ParserTest is not incomplete anymore
- Set store backend to test for unit testing
- Make consequent use of constants in Store
- Cleanup phpunit config
- Improve and fix Rdfawrapper

### Fixed
- Correct link to code conventions of OntoWiki in README.md
- Fix setting select clause in serializing query result in turtle parser
- Fix ARC2 dependency in Erfurt RdfaWrapper
- Fix setting select clause instead of prologue part
- Fix #104: Filter user id literal for comparison
- Fix setting select part on simple query instances
- Fix wrong return value of method
- #111: Fix issue with semicolons without leading whitespace
- Fix some bugs in order to fix tests
- Fix invalid PHP file
- Fix ant builds in order to fix owdev jenkins builds
- Fix several call to member function isVersioningEnabled() on boolean if versioning is disabled
- Fix wrong predicate uri <lang> and <type> by adding  as prefix
- Fix missing FILTER parenthesis
- Fix a missing case in the TurtleRDFParser for implicit blank and add a test file for implicit blank nodes under Tests/Unit/Erfurt/Syntax/_files/valid

### Removed
- Remove Query2_TriplesNode which is also in structural-Interfaces

## [1.7] - 2014-01-31

- Support OR and AND search, make AND default
- Fix a warning in RDF/XML parser
- Fix Windows test compatibility
- Fix getModelOrCreate to better handle not readable existing models
- Add Markdown to SysOnt.rdf
- Unify indention of SysOnt.rdf
- Enhance Pingback
- Add order option to Store.getGraphsUsingResource()
- changed URI generation: forward slashes are used now
- Fix "Too many opened parentheses" in _getTransitiveClosure
- escaped file paths before passing them to Virtuoso
- Reduce ord() calls in total by ~74% on plain start
- Add Worker, Jobs and Gearman Backend
- Add new log level SUCC
- Don't use AC, when writing type of model
- Add more verbose output for store exceptions
- Fix reading of namespace config to support equals sign in namespaces
- Fix ORDER BY queries in SimpleQuery
- Fix versioning unit tests
- Add support for action metadata
- Fix history for graph
- Add versioning support for deleteMatchingStatements
- Fix coding standard for Turtle Adapter
- fixing Virtuoso _execSQL function.
- Fix query2 parser star select issue
- Add getBaseIri to ModelStub
- avoid prefixes for http://, https://, ...
- Add support for full action URIs
- Fix syntax error when short_open_tag is enabled
- Fix _getTransitiveClosure: there was maximum one parent class in the list

## [1.6] - 2013-07-11

- rework caching framework / allow for memcached backend
- add renameResource method
- Enabling the sparqlAsk functionality in the Sparql backend
- Fix getModelOrCreate method in Store
- fix rdf import warning by turtle/n3 files
- Disable broken and useles query 'optimization'
- 50+ other commits

## [1.5] - 2013-02-01

- fix store init to make sure to load base ontologies
- add antlr parser component to the package

## [1.4] - 2013-01-25

- always set str to lower case on prefix
- add method getReadableGraphsUsingResource to Store
- Fix regression in getNamespacesForGraph
- Enhance performance by using graphUri directly
- Use faster way to add items to array
- Enhance performance by accessing model only if needed

## [1.3] - 2012-11-27

- config ontology: add ModelExport, Debug and ExtensionConfiguration actions
- some refactoring of Ping class
- add Ping class to Erfurt
- fix reference in getModelOrCreate
- apply coding standarts to Store.php
- Remove debug output commited by mistake
- Add test Sparql_Parser Test for Tokenize Filters
- coding standard fixes for Constraint.php
- Fix query for empty string in filter

## [1.2] - 2012-10-11

- fix OpenID normalization
- fix data fetching with redirects
- fix query cache string escaping
- fix broken history
- fix URI quoting in mysql
- add new mimetype for turtle
- make getStatementsDiff static
- fix some issues in MemoryModel
- fix default timezone warning
- fix getImportsClosure
- fix base URI for turtle file parser
- much more fixes
- add a lot of tests
- fixes for Virtuoso 6.1.5

## [1.1] - 2012-03-03

- virtuoso backend: fix for double query execution in _execSparql
- virtuoso backend: fix bif:contains search
- zenddb backend: fix sql generation for long uris
- revision is 782181f

[1.8.0]: https://github.com/AKSW/Erfurt/compare/v1.7...v1.8.0
[1.7]: https://github.com/AKSW/Erfurt/compare/v1.6...v1.7
[1.6]: https://github.com/AKSW/Erfurt/compare/v1.5...v1.6
[1.5]: https://github.com/AKSW/Erfurt/compare/v1.6...v1.5
[1.4]: https://github.com/AKSW/Erfurt/compare/v1.6...v1.4
[1.3]: https://github.com/AKSW/Erfurt/compare/v1.6...v1.3
[1.2]: https://github.com/AKSW/Erfurt/compare/v1.6...v1.2
[1.1]: https://github.com/AKSW/Erfurt/compare/v1.0-4...v1.1
