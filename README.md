# Curator - Comprehensive Documentation with PHP

> A **curator** (from Latin: curare, meaning "to take care") is a manager or overseer. Traditionally, a **curator** or keeper of a cultural heritage institution (e.g., gallery, museum, library or archive) is a content specialist charged with an institution's collections and involved with the interpretation of heritage material. Wikipedia, [Curator](https://en.wikipedia.org/w/index.php?title=Curator&oldid=709705734)

## Installation

```sh
$ php composer.phar require elsuperbeano/curator
```

```sh
$ php composer.phar global require --dev elsuperbeano/curator:dev-master
```

## Run

```sh
$ ./vendor/bin/curator
```

```sh
$ ~/.composer/vendor/bin/curator
```

### Changelog Example

If the your gitlog subject lines since your last release look like this

```git
    feat(SomeCoolStuff): Added awesome feature
    fix(ImportantClass): Fixed issue
```

Then you run curator with default configuration

```sh
    $ curator make my-last-release..HEAD
```

And you will get CHANGELOG_TMP containing

```
    ### New Feature
    * **SomeCoolStuff**: Added awesome feature

    ### Bug Fixes
    * **ImportantClass**: Fixed issue
```
