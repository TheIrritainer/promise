# PHP Promises/A+ implementation
[![Latest Stable Version](https://poser.pugx.org/streamcommon/promise/v/stable)](https://packagist.org/packages/streamcommon/promise)
[![Total Downloads](https://poser.pugx.org/streamcommon/promise/downloads)](https://packagist.org/packages/streamcommon/promise)
[![License](https://poser.pugx.org/streamcommon/promise/license)](./LICENSE)

This package provides [Promise/A+](https://github.com/promises-aplus/promises-spec) PHP implementation.

# Branches
[![Master][Master branch image]][Master branch] [![Build Status][Master image]][Master] [![Coverage Status][Master coverage image]][Master coverage]

[![Develop][Develop branch image]][Develop branch] [![Build Status][Develop image]][Develop] [![Coverage Status][Develop coverage image]][Develop coverage]

## Installation
Console run:
```console
    composer require streamcommon/promise
```
Or add into your `composer.json`:
```json
    "require": {
        "streamcommon/promise": "*"
    }
```

## Promise
Promise is a library which provides [Promise/A+](https://github.com/promises-aplus/promises-spec) PHP implementation.

All Promise it a special PHP classes that contains its state:
- `pending` - PromiseInterface::STATE_PENDING
- `fulfilled` - PromiseInterface::STATE_FULFILLED
- `rejected` - PromiseInterface::STATE_REJECTED

To initiate a new promise, you can use static method `PromiseInterface::create` or create with new.
All resulting `Promise` has `PromiseInterface::STATE_PENDING` state.
```php
    $promise = new Promise(function(callable $resolve, callable $reject));
    // OR
    $promise = Promise::create($callabel(callable $resolve, callable $reject))
```

When `$callabel($resolve, $reject)` executor finishes the job, it should call one of the functions:
- `$resolve` to indicate that the job finished successfully and set `Promise` state to `PromiseInterface::STATE_FULFILLED`
```php
    $resolve = function ($value) {
        $this->setState(PromiseInterface::STATE_FULFILLED);
        $this->setResult($value);
    };
```
- `$reject` to indicate that an error occurred and set `Promise` state to `PromiseInterface::STATE_REJECTED`
```php
    $reject = function ($value) {
        $this->setState(PromiseInterface::STATE_REJECTED);
        $this->setResult($value);
    };
```

Method `PromiseInterface::then()` it be called after promise change stage. In terms of our analogy: this is the “subscription".
```php
    public function then(?callable $onFulfilled = null, ?callable $onRejected = null): PromiseInterface;
```
- `$onFulfilled` run when the `Promise` is resolved and it has `PromiseInterface::STATE_FULFILLED` state.
- `$onFulfilled` run when the `Promise` is rejected and it has `PromiseInterface::STATE_REJECTED` state.
> NOTE: If `$onFulfilled` or `$onFulfilled` is not a callable function it was ignore

Calling `PromiseInterface::resolve()` creates a successfully executed promise with the result value.
```php
    public static function resolve($value): PromiseInterface;
```
It is similar to:
```php
    $promise = new Promise(function(callable $resolve) {
        $resolve($value)
    });
```
Similarly `PromiseInterface::reject()` creates an already executed promise with an error value.
```php
    public static function reject($value): PromiseInterface;
```
It is similar to:
```php
    $promise = new Promise(function(null, callable $reject) {
        $reject($value)
    });
```

## Example

> Standard Promise
```php
    use Streamcommon\Promise\Promise;
    
    $promise = Promise::create(function (callable $resolve) {
        $resolve(41);
    });
    $promise->then(function ($value) {
        return $value + 1;
    });
    $promise->then(function ($value) {
        echo $value . PHP_EOL;
    });
    $promise->wait(); // promise execution
```

> If you want see TRUE promise then install [Swoole](http://php.net/manual/en/swoole.installation.php) extension. 
> For more info visit the [Swoole repo](https://github.com/swoole/swoole-src)
>> NOTE: TRUE promise work only in CLI mode

```php
    use Streamcommon\Promise\PromiseA;
    
    // be careful with this
    \Swoole\Runtime::enableCoroutine(); // IF YOU WANT REALY ASYNC
    
    $promise = PromiseA::create(function (callable $resolve) {
        // the function is executed automatically when the promise is constructed
        $resolve(41);
    });
    $promise->then(function ($value) {
        // the function is executed automatically after __constructor job
        return $value + 1;
    })->then(function ($value) {
        // the function is executed automatically after ::then()
        echo $value . PHP_EOL;
    });
```

[Master branch]: https://github.com/streamcommon/promise/tree/master
[Master branch image]: https://img.shields.io/badge/branch-master-blue.svg
[Develop branch]: https://github.com/streamcommon/promise/tree/develop
[Develop branch image]: https://img.shields.io/badge/branch-develop-blue.svg
[Master image]: https://travis-ci.org/streamcommon/promise.svg?branch=master
[Master]: https://travis-ci.org/streamcommon/promise
[Master coverage image]: https://coveralls.io/repos/github/streamcommon/promise/badge.svg?branch=master
[Master coverage]: https://coveralls.io/github/streamcommon/promise?branch=master
[Develop image]: https://travis-ci.org/streamcommon/promise.svg?branch=develop
[Develop]: https://travis-ci.org/streamcommon/promise
[Develop coverage image]: https://coveralls.io/repos/github/streamcommon/promise/badge.svg?branch=develop
[Develop coverage]: https://coveralls.io/github/streamcommon/promise?branch=develop