# Erfurt

Erfurt is a PHP/Zend based Semantic Web Framework for Social Semantic Software.

## Features

* RDF Parser/serializer
* Storage abstraction/RDF Store
* Versioning
* SPARQL querying/update
* Caching
* Plugins/trigger
* ...

## Developer Info

### Repository Conventions

We use [Vincent Driessen's branching model](http://nvie.com/posts/a-successful-git-branching-model/)
and [Tom Preston-Werner's versioning specification](http://semver.org/) for this repository.

In addition to that, we suggest to use [git-flow](https://github.com/nvie/gitflow)
to keep naming conventions.
Copy the following config section in you global `~/.gitconfig` or the repository
wide `.git/config` file.

    # git flow default configuration for ~/.gitconfig
    [gitflow "branch"]
        master = master
        develop = develop
    [gitflow "prefix"]
        feature = feature/
        release = release/
        hotfix = hotfix/
        support = support/
        versiontag = v

### Code Conventions

Currently, this library is developed using [OntoWiki's coding
standard](http://code.google.com/p/ontowiki/wiki/CodingStandard).

