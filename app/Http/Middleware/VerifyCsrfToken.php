<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *应该排除在CSRF验证之外的url。
     * @var array
     */
    protected $except = [
        'geturl',
        'clientlogon',
    ];
}
