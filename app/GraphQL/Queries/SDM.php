<?php

namespace App\GraphQL\Queries;

use GuzzleHttp\Psr7\Request;
use Psy\Readline\Hoa\Console;

final class SDM
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args, Request $request)
    {
        
        return view('welcome', ['request' => $request]);
    }
}
