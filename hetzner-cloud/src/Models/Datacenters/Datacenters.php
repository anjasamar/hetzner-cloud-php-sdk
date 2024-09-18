<?php

/**
 * Created by PhpStorm.
 * User: Anjas Amar Pradana
 * Date: 18.09.24
 * Time: 21:01.
 */

namespace atsicorp\HetznerCloud\Models\Datacenters;

use atsicorp\HetznerCloud\APIResponse;
use atsicorp\HetznerCloud\HetznerAPIClient;
use atsicorp\HetznerCloud\Models\Contracts\Resources;
use atsicorp\HetznerCloud\Models\Meta;
use atsicorp\HetznerCloud\Models\Model;
use atsicorp\HetznerCloud\RequestOpts;
use atsicorp\HetznerCloud\Traits\GetFunctionTrait;

/**
 * Class Datacenters.
 */
class Datacenters extends Model implements Resources
{
    use GetFunctionTrait;

    /**
     * @var array
     */
    protected $datacenters;

    /**
     * Returns all datacenter objects.
     *
     * @see https://docs.hetzner.cloud/#resources-datacenters-get
     *
     * @param  string  $name
     * @return array
     *
     * @throws \atsicorp\HetznerCloud\APIException
     */
    public function all(RequestOpts $requestOpts = null): array
    {
        if ($requestOpts == null) {
            $requestOpts = new DatacenterRequestOpts();
        }

        return $this->_all($requestOpts);
    }

    /**
     * List datacenter objects.
     *
     * @see https://docs.hetzner.cloud/#resources-datacenters-get
     *
     * @param  RequestOpts|null  $requestOpts
     * @return APIResponse|null
     *
     * @throws \atsicorp\HetznerCloud\APIException
     */
    public function list(RequestOpts $requestOpts = null): ?APIResponse
    {
        if ($requestOpts == null) {
            $requestOpts = new DatacenterRequestOpts();
        }
        $response = $this->httpClient->get('datacenters' . $requestOpts->buildQuery());

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
     * Returns a specific datacenter object.
     *
     * @see https://docs.hetzner.cloud/#resources-datacenters-get-1
     *
     * @param  int  $datacenterId
     * @return \atsicorp\HetznerCloud\Models\Datacenters\Datacenter|null
     *
     * @throws \atsicorp\HetznerCloud\APIException
     */
    public function getById(int $datacenterId): ?Datacenter
    {
        $response = $this->httpClient->get('datacenters/' . $datacenterId);
        if (! HetznerAPIClient::hasError($response)) {
            return Datacenter::parse(json_decode((string) $response->getBody())->{$this->_getKeys()['one']});
        }

        return null;
    }

    /**
     * Returns a specific datacenter object by its name.
     *
     * @see https://docs.hetzner.cloud/#resources-datacenters-get-1
     *
     * @param  int  $datacenterId
     * @return \atsicorp\HetznerCloud\Models\Datacenters\Datacenter
     *
     * @throws \atsicorp\HetznerCloud\APIException
     */
    public function getByName(string $name): ?Datacenter
    {
        $resp = $this->list(new DatacenterRequestOpts($name));

        return (count($resp->datacenters) > 0) ? $resp->datacenters[0] : null;
    }

    /**
     * @param  $input
     * @return $this
     */
    public function setAdditionalData($input)
    {
        $this->datacenters = collect($input)->map(function ($datacenter, $key) {
            return Datacenter::parse($datacenter);
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
        return ['one' => 'datacenter', 'many' => 'datacenters'];
    }
}
