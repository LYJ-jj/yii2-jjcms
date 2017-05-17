<?php
$params = require(__DIR__ . '/params.php');

return [
    'components' => [
        'request' => [
            'class' => '\yii\web\Request',
            'enableCookieValidation' => false,
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
            'cookieValidationKey' => 'Oyiibai.com2trde1xww-M97_7QvwPo-5yiiBai@#720',
        ],
    ],
    'params' => $params
];