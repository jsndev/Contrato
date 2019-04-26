<?php
/**
 * dw-analytics++
 * Created by Jefferson Fernandes on 17/04/19
 * Copyright © 2018 Jefferson Fernandes. All rights reserved.
 */

namespace App\Http\Middleware;
use App\Proponente;
Use App\ProponenteConjuge;
use Closure;
use Illuminate\Http\Request;


class CarregarPropostaMiddleware {

    public function __construct(Request $request, Proponente $proponente, ProponenteConjuge $proponenteConjuge) {
        $proponente->get($request->proposta);
        $proponenteConjuge->get($request->proposta);
    }

    /**
     * @param $request
     * @param Closure $next
     * @return mixed
     * @throws \Throwable
     */
    public function handle($request, Closure $next) {
        return $next($request);
    }
}
