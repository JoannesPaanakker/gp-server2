<?php

return array(

    'iOS' => array(
        'environment' => 'development',
        'certificate' => app_path() . '/ApnsDev.pem',
        'passPhrase' => 'natan2',
        'service' => 'apns',
    ),
    'Android' => array(
        'environment' => 'production',
        'apiKey' => 'yourAPIKey',
        'service' => 'gcm',
    ),

);
