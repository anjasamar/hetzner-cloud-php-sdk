<?php

/**
 * Created by PhpStorm.
 * User: Anjas Amar Pradana
 * Date: 18.09.24
 * Time: 20:59.
 */

namespace atsicorp\HetznerCloud\Models\Firewalls;

use atsicorp\HetznerCloud\APIResponse;
use atsicorp\HetznerCloud\HetznerAPIClient;
use atsicorp\HetznerCloud\Models\Actions\Action;
use atsicorp\HetznerCloud\Models\Contracts\Resources;
use atsicorp\HetznerCloud\Models\Meta;
use atsicorp\HetznerCloud\Models\Model;
use atsicorp\HetznerCloud\RequestOpts;
use atsicorp\HetznerCloud\Traits\GetFunctionTrait;

class Firewalls extends Model implements Resources
{
    use GetFunctionTrait;

    /**
     * @var array
     */
    protected $firewalls;

    /**
     * Returns all Firewall objects.
     *
     * @see https://docs.hetzner.cloud/#firewalls
     *
     * @param  FirewallRequestOpts|RequestOpts|null  $requestOpts
     * @return array
     *
     * @throws \atsicorp\HetznerCloud\APIException
     */
    public function all(RequestOpts $requestOpts = null): array
    {
        if ($requestOpts == null) {
            $requestOpts = new FirewallRequestOpts();
        }

        return $this->_all($requestOpts);
    }

    /**
     * Returns a specific Firewall objects.
     *
     * @see https://docs.hetzner.cloud/#firewalls-get-a-firewall
     *
     * @param  int  $firewallId
     * @return \atsicorp\HetznerCloud\Models\Firewalls\Firewall|null
     *
     * @throws \atsicorp\HetznerCloud\APIException
     */
    public function getById(int $firewallId): ?Firewall
    {
        $response = $this->httpClient->get('firewalls/' . $firewallId);
        if (! HetznerAPIClient::hasError($response)) {
            return Firewall::parse(json_decode((string) $response->getBody())->{$this->_getKeys()['one']});
        }

        return null;
    }

    /**
     * @return array
     */
    public function _getKeys(): array
    {
        return ['one' => 'firewall', 'many' => 'firewalls'];
    }

    /**
     * Returns a specific Firewall object by its name.
     *
     * @see https://docs.hetzner.cloud/#firewalls-get-all-firewalls
     *
     * @param  string  $name
     * @return \atsicorp\HetznerCloud\Models\Firewalls\Firewall
     *
     * @throws \atsicorp\HetznerCloud\APIException
     */
    public function getByName(string $name): ?Firewall
    {
        $resp = $this->list(new FirewallRequestOpts($name));

        return (count($resp->firewalls) > 0) ? $resp->firewalls[0] : null;
    }

    /**
     * Returns all Firewall objects.
     *
     * @see https://docs.hetzner.cloud/#firewalls-get-all-firewalls
     *
     * @param  FirewallRequestOpts|RequestOpts|null  $requestOpts
     * @return APIResponse|null
     *
     * @throws \atsicorp\HetznerCloud\APIException
     */
    public function list(RequestOpts $requestOpts = null): ?APIResponse
    {
        if ($requestOpts == null) {
            $requestOpts = new FirewallRequestOpts();
        }
        $response = $this->httpClient->get('firewalls' . $requestOpts->buildQuery());
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
     * @param  $input
     * @return $this|static
     */
    public static function parse($input)
    {
        return (new self())->setAdditionalData($input);
    }

    /**
     * @param  $input
     * @return $this
     */
    public function setAdditionalData($input)
    {
        $this->firewalls = collect($input)->map(function ($firewall, $key) {
            return Firewall::parse($firewall);
        })->toArray();

        return $this;
    }

    /**
     * Creates a new Firewall.
     *
     * @see https://docs.hetzner.cloud/#firewalls-create-a-firewall
     *
     * @param  string  $name
     * @param  FirewallRule[]  $rules
     * @param  FirewallResource[]  $applyTo
     * @return ?APIResponse|null
     *
     * @throws \atsicorp\HetznerCloud\APIException
     */
    public function create(
        string $name,
        array $rules = [],
        array $applyTo = [],
        array $labels = []
    ): ?APIResponse {
        $parameters = [
            'name' => $name,
        ];
        if (! empty($rules)) {
            $parameters['rules'] = collect($rules)->map(function ($r) {
                return $r->toRequestSchema();
            });
        }

        if (! empty($applyTo)) {
            $parameters['apply_to'] = collect($applyTo)->map(function ($r) {
                return $r->toRequestSchema();
            });
        }
        if (! empty($labels)) {
            $parameters['labels'] = $labels;
        }
        $response = $this->httpClient->post('firewalls', [
            'json' => $parameters,
        ]);
        if (! HetznerAPIClient::hasError($response)) {
            $payload = json_decode((string) $response->getBody());

            return APIResponse::create([
                'firewall' => Firewall::parse($payload->{$this->_getKeys()['one']}),
                'actions' => collect($payload->actions)->map(function ($action) {
                    return Action::parse($action);
                })->toArray(),
            ], $response->getHeaders());
        }

        return null;
    }
}
