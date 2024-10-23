### Install
`composer require quetzal-studio/php-snap-bi`

### Examples
#### Manual Config
```php
<?php

require __DIR__.'/vendor/autoload.php';
require __DIR__.'/vendor/quetzal-studio/php-snap-bi/src/helpers.php';

use GuzzleHttp\Exception\RequestException;
use QuetzalStudio\PhpSnapBi\Config;
use QuetzalStudio\PhpSnapBi\PrivateKey;
use QuetzalStudio\PhpSnapBi\Provider;
use QuetzalStudio\PhpSnapBi\ProviderConfig;
use QuetzalStudio\PhpSnapBi\Services\BCA\VirtualAccountInquiry\Payload;
use QuetzalStudio\PhpSnapBi\Services\VirtualAccountInquiry\AccountInquiry;
use Throwable;

$config['bca'] = [
    'host' => env('SNAP_BCA_HOST'),
    'partner_id' => env('SNAP_BCA_PARTNER_ID'),
    'client_id' => env('SNAP_BCA_CLIENT_ID'),
    'client_secret' => env('SNAP_BCA_CLIENT_SECRET'),
    'private_key' => env('SNAP_BCA_PRIVATE_KEY'),
    'public_key' => env('SNAP_BCA_PUBLIC_KEY'),
];

Config::load(
    privateKey: new PrivateKey(path: storage_path($config['bca']['private_key'])),
    origin: 'quetzalstudio.local',
);

$provider = new Provider('bca', new ProviderConfig(
    partnerId: $config['bca']['partner_id'],
    clientId: $config['bca']['client_id'],
    clientSecret: $config['bca']['client_secret'],
    privateKey: storage_path($config['bca']['private_key']),
    publicKey: $config['bca']['public_key'],
    baseUrl: $config['bca']['host'],
    apiPrefix: '/openapi',
));

try {
    $inquiry = new AccountInquiry(
        provider: $provider,
        channelId: '95051',
        externalId: time(),
    );

    $response = $inquiry->send(new Payload(
        virtualAccountNo: '1234567890',
    ));

    // handle success response
} catch (RequestException $e) {
    // handle failed request
} catch (Throwable $e) {
    // handle other error
}
```


#### Auth Config
##### Requirement
- .env
- config/snap.php
- storage/private.key

###### .env
```env
SNAP_BCA_HOST=
SNAP_BCA_PARTNER_ID=
SNAP_BCA_CLIENT_ID=
SNAP_BCA_CLIENT_SECRET=
SNAP_BCA_PRIVATE_KEY=private.key
SNAP_BCA_API_PREFIX=/openapi
```

###### config/snap.php
```php
<?php

return [
    'providers' => [
        'bca' => [
            'host' => env('SNAP_BCA_HOST'),
            'client_id' => env('SNAP_BCA_CLIENT_ID'),
            'client_secret' => env('SNAP_BCA_CLIENT_SECRET'),
            'partner_id' => env('SNAP_BCA_PARTNER_ID'),
            'private_key' => env('SNAP_BCA_PRIVATE_KEY'),
            'public_key' => env('SNAP_BCA_PUBLIC_KEY'),
            'channel_id' => '',
            'api_prefix' => env('SNAP_BCA_API_PREFIX'),
        ],
    ],
];
```

```php
<?php

require __DIR__.'/vendor/autoload.php';
require __DIR__.'/vendor/quetzal-studio/php-snap-bi/src/helpers.php';

use GuzzleHttp\Exception\RequestException;
use QuetzalStudio\PhpSnapBi\Config;
use QuetzalStudio\PhpSnapBi\PrivateKey;
use QuetzalStudio\PhpSnapBi\Provider;
use QuetzalStudio\PhpSnapBi\ProviderConfig;
use QuetzalStudio\PhpSnapBi\Services\BCA\VirtualAccountInquiry\Payload;
use QuetzalStudio\PhpSnapBi\Services\VirtualAccountInquiry\AccountInquiry;
use Throwable;

$provider = Provider::init('bca', [
    'origin' => 'quetzalstudio.local',
]);

try {
    $inquiry = new AccountInquiry(
        provider: $provider,
        channelId: '95051',
        externalId: time(),
    );

    $response = $inquiry->send(new Payload(
        virtualAccountNo: '1234567890',
    ));

    // handle success response
} catch (RequestException $e) {
    // handle failed request
} catch (Throwable $e) {
    // handle other error
}
```