<?php
return [
    'components' =>  [
        'cms' => [
            'relatedHandlers' => [
                'skeeks\cms\ya\map\related\YaMap' => [
                    'class' => 'skeeks\cms\ya\map\related\YaMap'
                ]
            ],
        ],

        'yaMap' => [
            'class' => 'skeeks\cms\ya\map\YaMapComponent'
        ],

    ],
];