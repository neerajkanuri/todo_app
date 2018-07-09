<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '/adduser',
        '/deleteuser',
        '/listusers',
        '/addlist',
        '/deletelist',
        '/showlists',
        '/addtask',
        '/deletetask',
        '/showtasks',
        '/updatetask',
        '/updatelistname',
        '/updateusername'
    ];
}
