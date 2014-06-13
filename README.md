EqualsBuilder
=============

EqualsBuilder for PHP

[![Build Status](https://travis-ci.org/codeliner/php-equalsbuilder.png?branch=master)](https://travis-ci.org/codeliner/php-equalsbuilder)

## Installation

Installation of codeliner/php-equalsbuilder uses composer. For composer documentation, please refer to
[getcomposer.org](http://getcomposer.org/). Add following requirement to your composer.json


```sh
"codeliner/php-equalsbuilder" : "1.2.*"
```

## Usage

Use the EqualsBuilder to compare any number of value pairs at once.

```php
echo EqualsBuilder::create()
                ->append('equals', 'equals')
                ->append(1, 1)
                ->append(1, '1')
                ->equals() ? 
    "All value pairs are equal" : "At least one value pair is not equal";

//Output: All value pairs are equal
```

You can enable strict mode to compare against the value types, too.

```php
echo EqualsBuilder::create()
                ->append('equals', 'equals')
                ->append(1, 1)
                ->append(1, '1')
                ->strict() //enable strict mode
                ->equals() ? 
    "All value pairs are equal" : "At least one value pair is not equal";

//Output: At least one value pair is not equal
```

If you only provide the first parameter the second one is set to true. This enables you to use comparison methods of
objects together with the EqualsBuilder.

```php
echo EqualsBuilder::create()
                ->append($vo->sameValueAs($otherVo))
                ->append(1, 1)
                ->append(1, '1')
                ->equals() ?
    "All value pairs are equal" : "At least one value pair is not equal";

//Output: All value pairs are equal
```

You can also provide a callback as third parameter which is called with the value pair. The callback should return a boolean value.

```php
echo EqualsBuilder::create()
                ->append($vo, $otherVo, function($a, $b) { return $a->sameValueAs($b);})
                ->append(1, 1)
                ->append(1, '1')
                ->equals() ?
    "All value pairs are equal" : "At least one value pair is not equal";

//Output: All value pairs are equal
```

The callback option gets really interesting when $a and $b are array lists (arrays with continuous integer keys starting at 0 and ending at count - 1 ).
In this case the callback is called for every item in list $a together with the corresponding item of list $b assumed that count($a) == count($b) is true.

```php
$aList = array($vo1, $vo2, $vo3);
$bList = array($vo1, $vo2, $vo3);

echo EqualsBuilder::create()
                ->append($aList, $bList, function($aVO, $bVO) { return $aVO->sameValueAs($bVO);})
                ->append(1, 1)
                ->append(1, '1')
                ->equals() ?
    "All value pairs are equal" : "At least one value pair is not equal";

//Output: All value pairs are equal
```