<?php

/**
 * Created by PhpStorm.
 * User: Anjas Amar Pradana
 * Date: 18.09.24
 * Time: 21:02.
 */

namespace atsicorp\HetznerCloud\Models\ISOs;

use atsicorp\HetznerCloud\APIResponse;
use atsicorp\HetznerCloud\HetznerAPIClient;
use atsicorp\HetznerCloud\Models\Contracts\Resources;
use atsicorp\HetznerCloud\Models\Meta;
use atsicorp\HetznerCloud\Models\Model;
use atsicorp\HetznerCloud\RequestOpts;
use atsicorp\HetznerCloud\Traits\GetFunctionTrait;

class ISOs extends Model implements Resources
{
    use GetFunctionTrait;

    /**
     * @var array
     */
    public $isos;

    /**
     * Returns all iso objects.
     *
     * @see https://docs.hetzner.cloud/#resources-isos-get
     *
     * @param  RequestOpts  $requestOpts
     * @return array
     *
     * @throws \atsicorp\HetznerCloud\APIException
     */
    public function all(RequestOpts $requestOpts = null): array
    {
        if ($requestOpts == null) {
            $requestOpts = new ISORequestOpts();
        }

        return $this->_all($requestOpts);
    }

    /**
     * Returns all iso objects.
     *
     * @see https://docs.hetzner.cloud/#resources-isos-get
     *
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
        $response = $this->httpClient->get('isos' . $requestOpts->buildQuery());
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
     * Returns a specific iso object.
     *
     * @see https://docs.hetzner.cloud/#resources-iso-get-1
     *
     * @param  int  $isoId
     * @return \atsicorp\HetznerCloud\Models\ISOs\ISO|null
     *
     * @throws \atsicorp\HetznerCloud\APIException
     */
    public function getById(int $isoId): ?ISO
    {
        $response = $this->httpClient->get('isos/' . $isoId);
        if (! HetznerAPIClient::hasError($response)) {
            return ISO::parse(json_decode((string) $response->getBody())->iso);
        }

        return null;
    }

    /**
     * Returns a specific iso object by its name.
     *
     * @see https://docs.hetzner.cloud/#resources-iso-get-1
     *
     * @param  int  $isoId
     * @return \atsicorp\HetznerCloud\Models\ISOs\ISO
     *
     * @throws \atsicorp\HetznerCloud\APIException
     */
    public function getByName(string $name): ?ISO
    {
        $resp = $this->list(new ISORequestOpts($name));

        return (count($resp->isos) > 0) ? $resp->isos[0] : null;
    }

    /**
     * @param  $input
     * @return $this
     */
    public function setAdditionalData($input)
    {
        $this->isos = collect($input)->map(function ($iso, $key) {
            return ISO::parse($iso);
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
        return ['one' => 'iso', 'many' => 'isos'];
    }
}
