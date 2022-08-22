<?php

namespace App\GraphQL\Queries;

use GraphQL\GraphQL;
use GuzzleHttp\Psr7\Request;
use Psy\Readline\Hoa\Console;
use GraphQL\Language\AST\FieldNode;
use Illuminate\Support\Facades\Http;
use GraphQL\Type\Definition\ResolveInfo;
use Symfony\Component\HttpFoundation\ParameterBag;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

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
    public function tes($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo){
        // dd($resolveInfo->fieldNodes);
        // dd(ParameterBag::$parameters);
        $content = $context->request()->getContent();
        $content = json_decode($content);

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post('http://127.0.0.1:8000/graphql', [
            'query' => $content->query
        ]);

        $response = $response->json();
        dd(json_encode($response));

        dd($content);
        $content = $content->query;
        dd($content);
        // $content = json_encode($content->query);
        // dd(json_decode($content, true));
        dd($content->query);
        return "ok";
        // return ["nama" => $context];
    }
}
