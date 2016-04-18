# Pipeline

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]

## Introduction

yuloh/pipeline is a simple functional pipeline.  You can easily chain functions together to process a payload.  It's a lot easier to read, and there are less temporary variables than doing it the old fashioned way.

### Goals

This package aims to expose the simplest API possible.

The programming language elixir has a pipe operator (`|>`) which lets you easily chain functions:

```elixir
1 |> inc |> double
```

I really liked that syntax, and I wanted to write a pipeline package where I didn't have to write `pipe` or `add` over and over, hence this package.

### Why PHP 7 Only?

PHP 7 introduced the [Uniform Variable Syntax](https://wiki.php.net/rfc/uniform_variable_syntax), which means we can do this:

```php
pipe('hello world')('strrev')('strtoupper')();
```

Instead of something like this:

```php
pipe('hello world')->pipe('strrev')->pipe('strtoupper')->process();
```

## Install

Via Composer

``` bash
$ composer require yuloh/pipeline
```

## Usage

To create a new pipeline, invoke the `Yuloh\Pipeline\pipe` function with your payload.

```php
use function Yuloh\Pipeline\Pipe;

$pipe = pipe([1, 2]);
```

Once it's created you can keep chaining stages by invoking the pipeline.  The stage must be a valid PHP [callable](http://php.net/manual/en/language.types.callable.php).

```php
$pipe('array_sum')('sqrt');
```

If you invoke the pipeline without a stage, the pipeline will be processed and the processed payload is returned.

```php
$result = $pipe();
```

All together, it looks like this:

```php
pipe([1, 2])('array_sum')('sqrt')();
```

### Passing Arguments

When adding a stage, any additional arguments will be passed to the stage after the payload.  For instance, if you were processing a JSON payload the pipeline might look like this:

``` php
use function Yuloh\Pipeline\Pipe;

$pastTimes = pipe('{"name": "Matt", "pastTimes": ["playing Legend of Zelda", "programming"]}')
    ('json_decode', true)
    (function ($data) {
        return $data['pastTimes'];
    })
    ('implode', ', ')
    ();

echo $pastTimes; // playing Legend of Zelda, programming
```

In the previous example, `json_decode` would be invoked as `json_decode($payload, true)` to return an array.

### Alternative Method Call Usage

You can also add stages as method calls instead of function arguments.  It's a little more readable for pipelines that are only using standard functions.

```php
pipe('hello world')
    ->strrev()
    ->strtoupper()
    ->get();
```

## Testing

``` bash
$ composer test
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/yuloh/pipeline.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/yuloh/pipeline/master.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/yuloh/pipeline
[link-travis]: https://travis-ci.org/yuloh/pipeline
