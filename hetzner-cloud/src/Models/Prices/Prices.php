<?php

/**
 * Created by PhpStorm.
 * User: Anjas Amar Pradana
 * Date: 18.09.24
 * Time: 21:02.
 */

namespace atsicorp\HetznerCloud\Models\Prices;

use atsicorp\HetznerCloud\HetznerAPIClient;
use atsicorp\HetznerCloud\Models\Model;
use atsicorp\HetznerCloud\RequestOpts;

/**
 * Class Prices.
 */
class Prices extends Model
{
    /**
     * @var \stdClass
     */
    public $prices;

    /**
     * Returns all pricing information.
     *
     * @see https://docs.hetzner.cloud/#pricing-get-all-prices
     *
     * @param  RequestOpts  $requestOpts
     * @return \stdClass|null
     *
     * @throws \atsicorp\HetznerCloud\APIException
     */
    public function all(RequestOpts $requestOpts = null): ?\stdClass
    {
        if ($requestOpts == null) {
            $requestOpts = new RequestOpts();
        }
        $response = $this->httpClient->get('pricing' . $requestOpts->buildQuery());
        if (! HetznerAPIClient::hasError($response)) {
            $this->prices = json_decode((string) $response->getBody())->pricing;

            return $this->prices;
        }

        return null;
    }
}
