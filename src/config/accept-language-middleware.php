<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Available locales
    |--------------------------------------------------------------------------
    |
    | This list of locales represents the locales available in your
    | application. Based on the Accept-Language header the first locale in
    | the list that matches the header will be applied to the app.
    |
    */

    'available_locales' => ['en'],

    /*
    |--------------------------------------------------------------------------
    | Session property
    |--------------------------------------------------------------------------
    |
    | The middleware can check if a preferred locale is stored in the
    | session and use that language instead of the locale from the header.
    | Set this value to null to disable this behavior.
    |
    */

    'session_property' => 'locale',

];
