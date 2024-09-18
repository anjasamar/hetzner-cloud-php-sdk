<?php

/**
 * Created by PhpStorm.
 * User: Anjas Amar Pradana
 * Date: 18.09.24
 * Time: 20:58.
 */

namespace atsicorp\HetznerCloud\Models\Servers\Types;

use atsicorp\HetznerCloud\APIResponse;
use atsicorp\HetznerCloud\HetznerAPIClient;
use atsicorp\HetznerCloud\Models\Contracts\Resources;
use atsicorp\HetznerCloud\Models\Meta;
use atsicorp\HetznerCloud\Models\Model;
use atsicorp\HetznerCloud\Models\Servers\Server;
use atsicorp\HetznerCloud\RequestOpts;
use atsicorp\HetznerCloud\Traits\GetFunctionTrait;

class ServerTypes extends Model implements Resources
{
    use GetFunctionTrait;
    /**
     * @var array
     */
    protected $server_types;

    /**
     * @param  RequestOpts  $requestOpts
     * @return array
     *
     * @throws \atsicorp\HetznerCloud\APIException
     */
    public function all(RequestOpts $requestOpts = null): array
    {
        if ($requestOpts == null) {
            $requestOpts = new RequestOpts();
        }

        return $this->_all($requestOpts);
    }

    /**
     * @param  RequestOpts  $requestOpts
     * @return APIResponse|null
     *
     * @throws \atsicorp\HetznerCloud\APIException
     */
    public function list(RequestOpts $requestOpts = null): ?APIResponse
    {
        if ($requestOpts == null) {
            $requestOpts = new RequestOpts();
        }
        $response = $this->httpClient->get('server_types' . $requestOpts->buildQuery());
        if (! HetznerAPIClient::hasError($response)) {
            $resp = json_decode((string) $response->getBody());

            return APIResponse::create([
                'meta' => Meta::parse($resp->meta),
                $this->_getKeys()['many'] => self::parse($resp->{$this->_getKeys()['many']})->{$this->_getKeys()['many']},
            ], $response->getHeaders());
        }

        return null;
    }

    /**
     * @param  int  $serverTypeId
     * @return \atsicorp\HetznerCloud\Models\Servers\Types\ServerType
     *
     * @throws \atsicorp\HetznerCloud\APIException
     */
    public function getById(int $serverTypeId): ?ServerType
    {
        $response = $this->httpClient->get('server_types/' . $serverTypeId);
        if (! HetznerAPIClient::hasError($response)) {
            return ServerType::parse(json_decode((string) $response->getBody())->server_type);
        }

        return null;
    }

    /**
     * Returns a specific server type object by its name.
     *
     * @param  int  $serverTypeId
     * @return \atsicorp\HetznerCloud\Models\Servers\Types\ServerType
     *
     * @throws \atsicorp\HetznerCloud\APIException
     */
    public function getByName(string $name): ?ServerType
    {
        $serverTypes = $this->list(new ServerTypesRequestOpts($name));

        return (count($serverTypes->server_types) > 0) ? $serverTypes->server_types[0] : null;
    }

    /**
     * @param  $input
     * @return $this
     */
    public function setAdditionalData($input)
    {
        $this->server_types = collect($input)->map(function ($serverType, $key) {
            return ServerType::parse($serverType);
        })->toArray();

        return $this;
    }

    /**
     * @param  $input
     * @return $this|static
     */
    public static function parse($input)
    {
        return (new self())->setAdditionalData($input);
    }

    /**
     * @return array
     */
    public function _getKeys(): array
    {
        return ['one' => 'server_type', 'many' => 'server_types'];
    }
}
