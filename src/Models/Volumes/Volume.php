<?php

/**
 * Created by PhpStorm.
 * User: Anjas Amar Pradana
 * Date: 18.09.24
 * Time: 15:58.
 */

namespace atsicorp\HetznerCloud\Models\Volumes;

use GuzzleHttp\Client;
use atsicorp\HetznerCloud\APIResponse;
use atsicorp\HetznerCloud\HetznerAPIClient;
use atsicorp\HetznerCloud\Models\Actions\Action;
use atsicorp\HetznerCloud\Models\Contracts\Resource;
use atsicorp\HetznerCloud\Models\Locations\Location;
use atsicorp\HetznerCloud\Models\Model;
use atsicorp\HetznerCloud\Models\Protection;
use atsicorp\HetznerCloud\Models\Servers\Server;

/**
 * Class Volume.
 */
class Volume extends Model implements Resource
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var int
     */
    public $size;

    /**
     * @var Server
     */
    public $server;

    /**
     * @var Location
     */
    public $location;
    /**
     * @var Protection
     */
    public $protection;

    /**
     * @var array
     */
    public $labels;

    /**
     * @var string
     */
    public $linux_device;

    /**
     * @param  int  $volumeId
     * @param  Client|null  $httpClient
     */
    public function __construct(int $volumeId = null, Client $httpClient = null)
    {
        $this->id = $volumeId;
        parent::__construct($httpClient);
    }

    /**
     * @param  $data
     * @return Volume
     */
    public function setAdditionalData($data)
    {
        $this->id = $data->id;
        $this->name = $data->name;
        $this->linux_device = $data->linux_device;
        $this->size = $data->size;

        $this->server = $data->server;
        $this->location = Location::parse($data->location);
        $this->protection = $data->protection ?: Protection::parse($data->protection);
        $this->labels = get_object_vars($data->labels);

        return $this;
    }

    /**
     * Deletes a volume. This immediately removes the volume from your account, and it is no longer accessible.
     *
     * @see https://docs.hetzner.cloud/#resources-servers-delete
     *
     * @return APIResponse|null
     *
     * @throws \atsicorp\HetznerCloud\APIException
     */
    public function delete(): ?APIResponse
    {
        $response = $this->httpClient->delete('volumes/' . $this->id);
        if (! HetznerAPIClient::hasError($response)) {
            return APIResponse::create([], $response->getHeaders());
        }

        return null;
    }

    /**
     * @param  Server  $server
     * @param  bool|null  $automount
     * @return APIResponse|null
     *
     * @see https://docs.hetzner.cloud/#volume-actions-attach-volume-to-a-server
     *
     * @throws \atsicorp\HetznerCloud\APIException
     */
    public function attach(Server $server, $automount = null): ?APIResponse
    {
        $payload = [
            'server' => $server->id,
        ];
        if ($automount !== null) {
            $payload['automount'] = $automount;
        }

        $response = $this->httpClient->post('volumes/' . $this->id . '/actions/attach', [
            'json' => $payload,
        ]);

        if (! HetznerAPIClient::hasError($response)) {
            return APIResponse::create([
                'action' => Action::parse(json_decode((string) $response->getBody())->action),
            ], $response->getHeaders());
        }

        return null;
    }

    /**
     * @return APIResponse|null
     *
     * @see https://docs.hetzner.cloud/#volume-actions-detach-volume
     *
     * @throws \atsicorp\HetznerCloud\APIException
     */
    public function detach(): ?APIResponse
    {
        $response = $this->httpClient->post('volumes/' . $this->id . '/actions/detach');
        if (! HetznerAPIClient::hasError($response)) {
            return APIResponse::create([
                'action' => Action::parse(json_decode((string) $response->getBody())->action),
            ], $response->getHeaders());
        }

        return null;
    }

    /**
     * @param  int  $size
     * @return APIResponse|null
     *
     * @see https://docs.hetzner.cloud/#volume-actions-resize-volume
     *
     * @throws \atsicorp\HetznerCloud\APIException
     */
    public function resize(int $size): ?APIResponse
    {
        $response = $this->httpClient->post('volumes/' . $this->id . '/actions/resize', [
            'json' => [
                'size' => $size,
            ],
        ]);
        if (! HetznerAPIClient::hasError($response)) {
            return APIResponse::create([
                'action' => Action::parse(json_decode((string) $response->getBody())->action),
            ], $response->getHeaders());
        }

        return null;
    }

    /**
     * Update a volume with new meta data.
     *
     * @see https://docs.hetzner.cloud/#resources-volume-put
     *
     * @param  array  $data
     * @return APIResponse|null
     *
     * @throws \atsicorp\HetznerCloud\APIException
     */
    public function update(array $data): ?APIResponse
    {
        $response = $this->httpClient->put('volumes/' . $this->id, [
            'json' => $data,
        ]);
        if (! HetznerAPIClient::hasError($response)) {
            return APIResponse::create([
                'volume' => self::parse(json_decode((string) $response->getBody())->volume),
            ], $response->getHeaders());
        }

        return null;
    }

    /**
     * Changes the protection configuration of the volume.
     *
     * @see https://docs.hetzner.cloud/#volume-actions-change-volume-protection
     *
     * @param  bool  $delete
     * @return APIResponse|null
     *
     * @throws \atsicorp\HetznerCloud\APIException
     */
    public function changeProtection(bool $delete = true): ?APIResponse
    {
        $response = $this->httpClient->post('volumes/' . $this->id . '/actions/change_protection', [
            'json' => [
                'delete' => $delete,
            ],
        ]);
        if (! HetznerAPIClient::hasError($response)) {
            return APIResponse::create([
                'action' => Action::parse(json_decode((string) $response->getBody())->action),
            ], $response->getHeaders());
        }

        return null;
    }

    /**
     * @param  $input
     * @return Volume|static
     */
    public static function parse($input)
    {
        if ($input == null) {
            return;
        }

        return (new self($input->id))->setAdditionalData($input);
    }

    /**
     * Reload the data of the volume.
     *
     * @return Volume
     *
     * @throws \atsicorp\HetznerCloud\APIException
     */
    public function reload()
    {
        return HetznerAPIClient::$instance->volumes()->get($this->id);
    }
}
