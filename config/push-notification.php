<?php

return array(

    'iOS' => array(
        'environment' => 'development',
        'certificate' => app_path() . '/aps.pem',
        'passPhrase' => 'natan2',
        'service' => 'apns',
    ),
    'Android' => array(
        'environment' => 'development',
        'apiKey' => 'AIzaSyB1HlQmBX5lNive0t8wrE58ImW-redFx38',
        'service' => 'gcm',
    ),

);
