<?php

return [

    /*
    |--------------------------------------------------------------------------
    | File name
    |--------------------------------------------------------------------------
    |
    | Here you may specify the configuration options that should be used when
    | passwords are hashed using the Argon algorithm. These will allow you
    | to control the amount of time it takes to hash the given password.
    |
    */

    'file_types' => [
        'image' => 'png|jpg|jpeg|tmp|gif',
        'word'  => 'doc|docx',
        'ppt'   => 'ppt|pptx',
        'pdf'   => 'pdf',
        'code'  => 'php|js|java|python|ruby|go|c|cpp|sql|m|h|json|html|aspx',
        'zip'   => 'zip|tar\.gz|rar|rpm',
        'txt'   => 'txt|pac|log|md',
        'audio' => 'mp3|wav|flac|3pg|aa|aac|ape|au|m4a|mpc|ogg',
        'video' => 'mkv|rmvb|flv|mp4|avi|wmv|rm|asf|mpeg',
    ],

    /*
    |--------------------------------------------------------------------------
    | Image sizes
    |--------------------------------------------------------------------------
    |
    | Here you may specify the configuration options that should be used when
    | passwords are hashed using the Argon algorithm. These will allow you
    | to control the amount of time it takes to hash the given password.
    |
    */

    'image_sizes' => [
        'thumbnail' => [
            'width' => 150,
            'height' => 150,
        ],
        'mobile' => [
            'width' => 500,
        ],
        'tablet' => [
            'width' => 1000,
        ],
        'desktop' => [
            'width' => 1920,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | WebP
    |--------------------------------------------------------------------------
    |
    | Here you may specify the configuration options that should be used when
    | passwords are hashed using the Argon algorithm. These will allow you
    | to control the amount of time it takes to hash the given password.
    |
    */

    'webp' => [
        'convert' => true,
        'options' => [
            'png' => [
                'encoding' => 'auto',    /* Try both lossy and lossless and pick smallest */
                'near-lossless' => 60,   /* The level of near-lossless image preprocessing (when trying lossless) */
                'quality' => 85,         /* Quality when trying lossy. It is set high because pngs is often selected to ensure high quality */
            ],
            'jpeg' => [
                'encoding' => 'auto',     /* If you are worried about the longer conversion time, you could set it to "lossy" instead (lossy will often be smaller than lossless for jpegs) */
                'quality' => 'auto',      /* Set to same as jpeg (requires imagick or gmagick extension, not necessarily compiled with webp) */
                'max-quality' => 80,      /* Only relevant if quality is set to "auto" */
                'default-quality' => 75,  /* Fallback quality if quality detection isnt working */
            ]
        ]
    ],


];
