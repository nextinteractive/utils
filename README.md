utils library
==============

utils library was extracted from BackBee core project.
This contains a lot of useful methods to manipulate files, arrays and strings.

** Note that this library is still a work in progress. **

[![Build Status](https://api.travis-ci.org/backbee/utils.svg?branch=master)](https://travis-ci.org/backbee/utils)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/backbee/utils/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/backbee/utils/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/backbee/utils/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/backbee/utils/?branch=master)


1) Arrays
---------

PHP is one of the more convenient programming language to work with arrays
despite the inconsistency of the API.

We have implemented some methods to ease the conversion of arrays in XML and CSV.
We also provide some useful method you can need when you work with associative arrays.

Example:

```php
require_once('some_autoloader.php');
use BackBee\Utils\Arrays;

$users = [0 => ['name' => 'Charles', 'role' => 'lead developper'],
    1 => ['name' => 'Eric', 'role' => 'developper'],
];

echo Arrays::toCsv($users, ';');

/**
 * Will return:
 * Charles;lead developper
 * Eric;developper
 */

$users = ['users' => [
    0 => ['name' => 'Charles', 'role' => 'lead developper'],
    1 => ['name' => 'Eric', 'role' => 'developper'],
    ],
];

echo Arrays::toBasicXml($users, ';');

/**
 * <users>
 *     <0>
 *        <name>Eric</name>
 *        <role>developper</role>
 *     </0>
 *     <1>
 *        <name>Charles</name>
 *        <role>lead developper</role>
 *     </1>
 * </users>
 */

 $tree = [
    'root' => [
        'child' => [
            'subchild' => 'value',
        ],
    ],
];

Arrays::has($tree, 'root:child:subchild'); // return true
Arrays::has($tree, 'root::child::subchild', '::'); // return true
Arrays::has($tree, 'root:child:foo'); // return false
```


