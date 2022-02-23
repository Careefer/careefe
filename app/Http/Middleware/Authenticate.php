<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function redirectTo($request)
    {
        if ($request->is('admin/*'))
        {
            return 'admin\login';
        }

        if ($request->is('vendor/*'))
        {
            return 'vendor\login';
        }

        if ($request->is('customer/*'))
        {
            return 'customer\login';
        }
    }
}
