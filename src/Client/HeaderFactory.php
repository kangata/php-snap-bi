<?php

namespace QuetzalStudio\PhpSnapBi\Client;

use QuetzalStudio\PhpSnapBi\Timestamp;

class HeaderFactory
{
    public static function make(array $attributes)
    {
        return new Header(
            contentType: $attributes['content_type'] ?? 'application/json',
            clientKey: $attributes['client_key'] ?? null,
            authorization: $attributes['authorization'] ?? null,
            authorizationCustomer: $attributes['authorization_customer'] ?? null,
            timestamp: (string) new Timestamp($attributes['timestamp'] ?? time()),
            signature: $attributes['signature'] ?? null,
            origin: $attributes['origin'] ?? null,
            partnerId: $attributes['partner_id'] ?? null,
            externalId: $attributes['external_id'] ?? null,
            ipAddress: $attributes['ip_address'] ?? null,
            deviceId: $attributes['device_id'] ?? null,
            latitude: $attributes['latitude'] ?? null,
            longitude: $attributes['longitude'] ?? null,
            channelId: $attributes['channel_id'] ?? null,
        );
    }
}
