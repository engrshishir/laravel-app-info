<?php  


namespace EngrShishir\AppInfo\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \EngrShishir\AppInfo\AppInfo
 */
class AppInfo extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'laravel-app-info';
    }
}
