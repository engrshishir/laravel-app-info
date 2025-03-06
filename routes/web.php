<?php
use EngrShishir\AppInfo\Facades\AppInfo;

Route::get('/app-info', function () {
    return view('app-info',[
        'envs'=> AppInfo::getAllEnv(),
        'routes'=> AppInfo::getAllRoutes(),
        'packages'=> AppInfo::getAllPackages()
    ]);
});
