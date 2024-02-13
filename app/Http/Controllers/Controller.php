<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Str;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function callAction($method, $parameters)
    {
        // code that runs before any action
        if (request()->filled('delete_step')) {
            $confirmMethod = 'confirm'.Str::studly($method);
            return match (request('delete_step')) {
                'check' => [
                    'status' => 'checked',
                    'confirmation' => method_exists($this, $confirmMethod) ? 'remote' : 'locale'
                ],
                'confirm' => parent::callAction($confirmMethod, $parameters),
                'destroy' => parent::callAction($method, $parameters),
            };
        }

        return parent::callAction($method, $parameters);
    }
}
