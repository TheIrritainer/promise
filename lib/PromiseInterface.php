<?php
/**
 * This file is part of the Promise package, a StreamCommon open software project.
 *
 * @copyright (c) 2019-2020 StreamCommon
 * @see https://github.com/streamcommon/promise
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Streamcommon\Promise;

/**
 * Interface PromiseInterface
 *
 * @package Streamcommon\Promise
 * @see https://promisesaplus.com
 */
interface PromiseInterface
{
    /**
     * It be called after promise change stage
     *
     * @param callable|null $onFulfilled called after promise is fulfilled
     * @param callable|null $onRejected  called after promise is rejected
     * @return PromiseInterface
     *
     * @see https://promisesaplus.com/#the-then-method
     */
    public function then(?callable $onFulfilled = null, ?callable $onRejected = null): PromiseInterface;

    /**
     * This method return a promise with rejected case only
     *
     * @param callable $onRejected
     * @return PromiseInterface
     */
    public function catch(callable $onRejected): PromiseInterface;

    /**
     * This method create new promise instance
     *
     * @param callable $promise
     * @return PromiseInterface
     */
    public static function create(callable $promise): PromiseInterface;

    /**
     * This method create new fulfilled promise with $value result
     *
     * @param mixed $value
     * @return PromiseInterface
     */
    public static function resolve($value): PromiseInterface;

    /**
     * This method create new rejected promise with $value result
     *
     * @param mixed $value
     * @return PromiseInterface
     */
    public static function reject($value): PromiseInterface;

    /**
     * This method create a new promise and return values when all promises are change stage
     *
     * @param iterable|PromiseInterface[] $promises
     * @return PromiseInterface
     */
    public static function all(iterable $promises): PromiseInterface;
}
