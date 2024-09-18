<?php

/**
 * Created by PhpStorm.
 * User: Anjas Amar Pradana
 * Date: 18.09.24
 * Time: 21:00.
 */

namespace atsicorp\HetznerCloud\Models\Locations;

use atsicorp\HetznerCloud\APIResponse;
use atsicorp\HetznerCloud\HetznerAPIClient;
use atsicorp\HetznerCloud\Models\Contracts\Resources;
use atsicorp\HetznerCloud\Models\Meta;
use atsicorp\HetznerCloud\Models\Model;
use atsicorp\HetznerCloud\RequestOpts;
use atsicorp\HetznerCloud\Traits\GetFunctionTrait;

class Locations extends Model implements Resources
{
    use GetFunctionTrait;

    /**
     * @var array
     */
    protected $locations;

    /**
     * Returns all location objects.
     *
     * @see https://docs.hetzner.cloud/#resources-locations-get
     *
     * @param  RequestOpts  $requestOpts
     * @return array
     *
     * @throws \atsicorp\HetznerCloud\APIException
     */
    public function all(RequestOpts $requestOpts = null): array
    {
        if ($requestOpts == null) {
            $requestOpts = new LocationRequestOpts();
        }

        return $this->_all($requestOpts);
    }

    /**
     * Returns all location objects.
     *
     * @see https://docs.hetzner.cloud/#resources-locations-get
     *
     * @param  RequestOpts  $requestOpts
     * @return APIResponse|null
     *
     * @throws \atsicorp\HetznerCloud\APIException
     */
    public function list(RequestOpts $requestOpts = null): ?APIResponse
    {
        if ($requestOpts == null) {
            $requestOpts = new LocationRequestOpts();
        }
        $response = $this->httpClient->get('locations' . $requestOpts->buildQuery());
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
     * Returns a specific location object.
     *
     * @see https://docs.hetzner.cloud/#resources-locations-get-1
     *
     * @param  int  $locationId
     * @return \atsicorp\HetznerCloud\Models\Locations\Location
     *
     * @throws \atsicorp\HetznerCloud\APIException
     */
    public function getById(int $locationId): ?Location
    {
        $response = $this->httpClient->get('locations/' . $locationId);
        if (! HetznerAPIClient::hasError($response)) {
            return Location::parse(json_decode((string) $response->getBody())->location);
        }

        return null;
    }

    /**
     * Returns a specific location object by its name.
     *
     * @see https://docs.hetzner.cloud/#resources-locations-get-1
     *
     * @param  int  $locationId
     * @return \atsicorp\HetznerCloud\Models\Locations\Location
     *
     * @throws \atsicorp\HetznerCloud\APIException
     */
    public function getByName(string $name): ?Location
    {
        $locations = $this->list(new LocationRequestOpts($name));

        return (count($locations->locations) > 0) ? $locations->locations[0] : null;
    }

    /**
     * @param  $input
     * @return $this
     */
    public function setAdditionalData($input)
    {
        $this->locations = collect($input)->map(function ($location, $key) {
            return Location::parse($location);
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
        return ['one' => 'location', 'many' => 'locations'];
    }
}
