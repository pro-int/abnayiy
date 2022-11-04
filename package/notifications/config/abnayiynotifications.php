<?php
  /*
    |api---------------------------------------------------------------------
    | prefix Defaults
    |--------------------------------------------------------------------------
    | prefix
    | This option controls the default admin dashboard URL prefix
    | middleware
    | This option controls the applied middleware for admin dashboard 
    */

return [
    'admin_prefix' => env('ADMIN_URL','admin_dashboard'),
    'admin_middleware' => ['web','auth'],

    'api_prefix' => env('ADMIN_URL','api'),
    'api_middleware' => ['api']
];
