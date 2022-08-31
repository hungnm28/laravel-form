<?php

namespace Hungnm28\LaravelForm\Facades;

use Illuminate\Support\Facades\Facade;
/**
 * Class Admin.
 *
 * @method static string demo()
 */


class LaravelForm extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravelform';
    }

}
