<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * Indicates whether the XSRF-TOKEN cookie should be set on the response.
     *
     * @var bool
     */
    protected $addHttpCookie = true;

    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //this is done to disable crf tokens for api routes. when you use POST request in postman, will return a 500 error, because laravel while sending forms includes crf tokens. this crf causes the issue while using POST with postman

        'api/*' //means anything that has route api slash anything. i.e api/items, api/otheritem. etc
    ];
}
