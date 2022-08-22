<?php

namespace App\GraphQL\Mutations;

use phpDocumentor\Reflection\Types\Boolean;

final class Auth
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args): bool
    {
        if ($args['token']) {
            return true;
        }else{
            return false;
        }
    }

    public function verify(){
        return true;
    }
}
