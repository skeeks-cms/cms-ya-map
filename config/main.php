<?php
return [
    'components' =>
    [
        'cms' =>
        [
            'relatedProperies' => [
                'skeeks\cms\ya\map\related\YaMap'
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