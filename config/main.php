<?php
return [
    'components' =>
    [
        'cms' =>
        [
            'relatedHandlers' => [
                'skeeks\cms\ya\map\related\YaMap' =>
                [
                    'class' => 'skeeks\cms\ya\map\related\YaMap'
                ]
            ],
        ],

        'admin' => [
            'dashboards'         => [
                'Yandex maps' =>
                [
                    'skeeks\cms\ya\map\dashboards\PointOnMap'
                ]
            ],
        ],
    ],
];