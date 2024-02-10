### Install
`composer require quetzal-studio/php-snap-bi`

### Examples
```php
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
    // handle failed response
} catch (Throwable $e) {
    // handle other error
}
```