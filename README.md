# Erfurt

Erfurt is a PHP/Zend based Semantic Web Framework for Social Semantic Software.

| CI System      | Status                                                                                                           | 
| -------------- | ---------------------------------------------------------------------------------------------------------------- |
| Travis CI      | [![Travis CI Build Status](https://travis-ci.org/AKSW/Erfurt.svg)](https://travis-ci.org/AKSW/Erfurt/)           |
| owdev Jenkins  | [![owdev Build Status](http://owdev.ontowiki.net/job/Erfurt/badge/icon)](http://owdev.ontowiki.net/job/Erfurt/)  |

[API Documentation](http://api.ontowiki.net/)

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

We use [Vincent Driessen's branching model](http://nvie.com/posts/a-successful-git-branching-model/), [Tom Preston-Werner's versioning specification](http://semver.org/) as well as [this note on good commit messages](https://github.com/erlang/otp/wiki/Writing-good-commit-messages) for this repository.

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
standard](https://github.com/AKSW/OntoWiki/wiki/Coding-Standards).

