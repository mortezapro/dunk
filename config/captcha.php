<?php

return [
    'characters' => ['5', '1','2', '3', '4', '6', '7', '8', '9'],
    'default' => [
        'length' => 5,
        'width' => 120,
        'height' => 36,
        'quality' => 90,
        'math' => false,
    ],
    'math' => [
        'length' => 6,
        'width' => 120,
        'height' => 36,
        'quality' => 100,
        'math' => true,
    ],

    'flat' => [
        'length' => 5,
        'width' => 130,
        'height' => 46,
        'quality' => 90,
        'lines' => 0,
        'bgImage' => false,
        'bgColor' => '#ecf2f4',
        'fontColors' => ['#2c3e50', '#c0392b', '#16a085', '#c0392b', '#8e44ad', '#303f9f', '#f57c00', '#795548'],
        'contrast' => -5,
    ],
    'mini' => [
        'length' => 3,
        'width' => 60,
        'height' => 32,
    ],
    'inverse' => [
        'length' => 5,
        'width' => 120,
        'height' => 36,
        'quality' => 90,
        'sensitive' => true,
        'angle' => 12,
        'sharpen' => 10,
        'blur' => 2,
        'invert' => true,
        'contrast' => -5,
    ]
];
