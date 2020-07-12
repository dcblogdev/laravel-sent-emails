<?php

namespace Dcblogdev\LaravelSentEmails\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Dcblogdev\SentEmails\Skeleton\SkeletonClass
 */
class SentEmailsFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'SentEmails';
    }
}
