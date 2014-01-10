EqualsBuilder
=============

EqualsBuilder for PHP

[![Build Status](https://travis-ci.org/codeliner/php-equalsbuilder.png?branch=master)](https://travis-ci.org/codeliner/php-equalsbuilder)

## Installation

Installation of codeliner/php-equalsbuilder uses composer. For composer documentation, please refer to
[getcomposer.org](http://getcomposer.org/). Add following requirement to your composer.json


```sh
"codeliner/php-equalsbuilder" : "1.0.*"
```

## Usage

Use the EqualsBuilder to compare any number of value pairs at once.

```php
echo EqualsBuilder::getInstance()
                ->append('equals', 'equals')
                ->append(1, 1)
                ->append(1, '1')
                ->equals() ? 
    "All value pairs are equal" : "At least one value pair is not equal";

//Output: All value pairs are equal
```

You can active strict mode to compare against the value types, too.

```php
echo EqualsBuilder::getInstance()
                ->append('equals', 'equals')
                ->append(1, 1)
                ->append(1, '1')
                ->strict() //enable strict mode
                ->equals() ? 
    "All value pairs are equal" : "At least one value pair is not equal";

//Output: At least one value pair is not equal
```
