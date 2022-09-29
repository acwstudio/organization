<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as BaseResponse;

class EnsureCorrectAPIHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param  \Closure(Request): (Response|RedirectResponse)  $next
     * @return RedirectResponse|Response|BaseResponse
     */
    public function handle(Request $request, Closure $next): Response|BaseResponse|RedirectResponse
    {
        if($request->header('accept') !== 'application/vnd.api+json'){
            return $this->addCorrectContentType(new Response('', 406));
        }

        if($request->isMethod('POST') || $request->isMethod('PATCH')){
            if($request->header('content-type') !== 'application/vnd.api+json'){
                return $this->addCorrectContentType(new Response('', 415));
            }
        }

        return $this->addCorrectContentType($next($request));
    }

    /**
     * @param BaseResponse $response
     * @return BaseResponse
     */
    private function addCorrectContentType(BaseResponse $response): BaseResponse
    {
        $response->headers->set('content-type', 'application/vnd.api+json');
        return $response;
    }
}
