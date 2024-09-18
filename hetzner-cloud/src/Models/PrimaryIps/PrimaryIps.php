<?php

namespace atsicorp\HetznerCloud\Models\PrimaryIps;

use atsicorp\HetznerCloud\APIResponse;
use atsicorp\HetznerCloud\HetznerAPIClient;
use atsicorp\HetznerCloud\Models\Contracts\Resources;
use atsicorp\HetznerCloud\Models\Datacenters\Datacenter;
use atsicorp\HetznerCloud\Models\Meta;
use atsicorp\HetznerCloud\Models\Model;
use atsicorp\HetznerCloud\RequestOpts;
use atsicorp\HetznerCloud\Traits\GetFunctionTrait;

class PrimaryIps extends Model implements Resources
{
    use GetFunctionTrait;

    /**
     * @var array
     */
    protected $primary_ips;

    /**
     * Returns all primary ip objects.
     *
     * @see https://docs.hetzner.cloud/#primary-ips-get-all-primary-ips
     *
     * @param  PrimaryIPRequestOpts|RequestOpts|null  $requestOpts
     * @return array
     *
     * @throws \atsicorp\HetznerCloud\APIException
     */
    public function all(RequestOpts $requestOpts = null): array
    {
        if ($requestOpts == null) {
            $requestOpts = new PrimaryIPRequestOpts();
        }

        return $this->_all($requestOpts);
    }

    /**
     * Returns all primary ip objects.
     *
     * @see https://docs.hetzner.cloud/#primary-ips-get-all-primary-ips
     *
     * @param  PrimaryIPRequestOpts|RequestOpts|null  $requestOpts
     * @return APIResponse|null
     *
     * @throws \atsicorp\HetznerCloud\APIException
     */
    public function list(RequestOpts $requestOpts = null): ?APIResponse
    {
        if ($requestOpts == null) {
            $requestOpts = new PrimaryIPRequestOpts();
        }
        $response = $this->httpClient->get('primary_ips' . $requestOpts->buildQuery());
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
     * Returns a specific Primary IP object.
     *
     * @see https://docs.hetzner.cloud/#primary-ips-get-a-primary-ip
     *
     * @param  int  $id
     * @return \atsicorp\HetznerCloud\Models\PrimaryIps\PrimaryIp|null
     *
     * @throws \atsicorp\HetznerCloud\APIException
     */
    public function getById(int $id): ?PrimaryIp
    {
        $response = $this->httpClient->get('primary_ips/' . $id);
        if (! HetznerAPIClient::hasError($response)) {
            return PrimaryIp::parse(json_decode((string) $response->getBody())->{$this->_getKeys()['one']});
        }

        return null;
    }

    /**
     * Returns a specific Primary IP object by its name.
     *
     * @see https://docs.hetzner.cloud/#primary-ips-get-a-primary-ip
     *
     * @param  string  $name
     * @return \atsicorp\HetznerCloud\Models\PrimaryIps\PrimaryIp
     *
     * @throws \atsicorp\HetznerCloud\APIException
     */
    public function getByName(string $name): ?PrimaryIp
    {
        $resp = $this->list(new PrimaryIPRequestOpts($name));

        return (count($resp->primary_ips) > 0) ? $resp->primary_ips[0] : null;
    }

    /**
     * Creates a new Primary IP, optionally assigned to a Server.
     *
     * @see https://docs.hetzner.cloud/#primary-ips-create-a-primary-ip
     *
     * @param  string  $type
     * @param  string  $name
     * @param  string  $assigneeType
     * @param  int|null  $assigneeId
     * @param  \atsicorp\HetznerCloud\Models\Datacenters\Datacenter|null  $datacenter
     * @param  array  $labels
     * @return \atsicorp\HetznerCloud\Models\PrimaryIps\PrimaryIp|null
     *
     * @throws \atsicorp\HetznerCloud\APIException
     */
    public function create(
        string $type,
        string $name,
        string $assigneeType,
        bool $autoDelete = false,
        int $assigneeId = null,
        Datacenter $datacenter = null,
        array $labels = []
    ): ?PrimaryIp {
        $parameters = [
            'type' => $type,
            'name' => $name,
            'assignee_type' => $assigneeType,
            'auto_delete' => $autoDelete,
        ];
        if ($assigneeId != null) {
            $parameters['assignee_id'] = $assigneeId;
        }
        if ($datacenter != null) {
            $parameters['datacenter'] = $datacenter->id ?: $datacenter->name;
        }
        if (! empty($labels)) {
            $parameters['labels'] = $labels;
        }
        $response = $this->httpClient->post('primary_ips', [
            'json' => $parameters,
        ]);
        if (! HetznerAPIClient::hasError($response)) {
            return PrimaryIp::parse(json_decode((string) $response->getBody())->{$this->_getKeys()['one']});
        }

        return null;
    }

    /**
     * @param  $input
     * @return $this
     */
    public function setAdditionalData($input)
    {
        $this->primary_ips = collect($input)->map(function ($primaryIp, $key) {
            return PrimaryIp::parse($primaryIp);
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
        return ['one' => 'primary_ip', 'many' => 'primary_ips'];
    }
}
