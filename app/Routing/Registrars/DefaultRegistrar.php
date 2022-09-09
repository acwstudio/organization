<?php

declare(strict_types=1);


namespace App\Routing\Registrars;

use App\Routing\Contracts\RouteRegistrar;
use Illuminate\Contracts\Routing\Registrar;

final class DefaultRegistrar implements RouteRegistrar
{
    public function map(Registrar $registrar): void
    {
        $registrar->view('/', 'welcome');
    }
}
