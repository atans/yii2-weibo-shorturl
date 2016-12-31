Yii2 weibo short url
===================
Weibo short url client

# Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).


Either run

```
composer require atans/yii2-weibo-shorturl
```

or add

```
"atans/yii2-weibo-shorturl": "*"
```

to the require section of your `composer.json` file.


# Usage


```php
// app/config/main-local.php

use atans\weibo\ShortUrl;

return [
    'components' => [
        // ...
        'shortUrl' => [
          'class' => ShortUrl::className(),
          'appKey' => '<your-app-key>',
        ],
    ],
];

// Use it

$response = Yii::$app->shortUrl->shorten('http://www.yiiframework.com');


```