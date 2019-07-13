<?php

return [
    
     /*
    |--------------------------------------------------------------------------
    | API Version
    |--------------------------------------------------------------------------
    |
    |  API version - in a distributed environment the response may come 
    |  from a different version of the same Application
    |
    */
    
    'version' => env('API_VERSION','1.0.0'),
    
     /*
    |--------------------------------------------------------------------------
    | API Release Number
    |--------------------------------------------------------------------------
    |
    |  API release number - useful for debugging purposes
    |
    */
    
    'release' => env('API_RELEASE','01')
];