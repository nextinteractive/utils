utils library
==============

utils library was extracted from BackBee core project.
This contains a lot of useful methods to manipulate files, arrays and strings.

** Note that this library is still a work in progress. **

[![Build Status](https://api.travis-ci.org/backbee/utils.svg?branch=master)](https://travis-ci.org/backbee/utils)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/backbee/utils/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/backbee/utils/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/backbee/utils/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/backbee/utils/?branch=master)


1) Collection
-----------------

PHP is one of the more convenient programming language to work with arrays
despite the inconsistency of the API.

We have implemented some methods to ease the conversion of arrays in XML and CSV.
We also provide some useful method you can need when you work with associative arrays.

Example:

```php
require_once('some_autoloader.php');
use BackBee\Utils\Collection\Collection;

$users = [0 => ['name' => 'Charles', 'role' => 'lead developper'],
    1 => ['name' => 'Eric', 'role' => 'developper'],
];

echo Collection::toCsv($users, ';');

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

echo Collection::toBasicXml($users, ';');

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

Collection::has($tree, 'root:child:subchild'); // return true
Collection::has($tree, 'root::child::subchild', '::'); // return true
Collection::has($tree, 'root:child:foo'); // return false
```

2) Strings
-------------

We have added to this library some methods to ease encoding operations.
We provide also some useful functions to handle with strings which have particular meanings like file size or path, urls.

Example:

```php
require_once('some_autoloader.php');
use BackBee\Utils\String;

/**
 * Some helpers for encoding operations
 */
mb_detect_encoding(String::toASCII('BackBee')); // "ASCII"
mb_detect_encoding(String::toUTF8('w�ird')); // "UTF-8"

/**
 * Some normalizers for filepaths and urls
 */
$options = ['extension' => '.txt', 'spacereplace' => '_'];
String::toPath('test path', $options)); // "test_path.txt"

$options = ['extension' => '.com', 'spacereplace' => '_'];
String::urlize('test`s url', $options); // "tests_url.com"

/**
 * Convenients formatters for file size
 */
String::formatBytes(2000, 3); // "1.953 kb"
String::formatBytes(567000, 5); // "553.71094 kb"
String::formatBytes(567000); // "553.71 kb"
String::formatBytes(5670008902); // "5.28 gb"
```
