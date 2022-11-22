<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\File;

class OpenApiController extends Controller
{
    /**
     * @return string
     * @throws FileNotFoundException
     */
    public function document(): string
    {
        return File::get(base_path('docs/v1/openapi.yaml'));
    }

    /**
     * @return View
     */
    public function redoc(): View
    {
        return view('redoc.spec');
    }

    /**
     * @return View
     */
    public function swagger(): View
    {
        return view('swagger.spec');
    }

}
