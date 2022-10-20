<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Throwable;

class DeleteRestrictionException extends Exception
{
    public function getStatusCode()
    {
        return 403;
    }
}
