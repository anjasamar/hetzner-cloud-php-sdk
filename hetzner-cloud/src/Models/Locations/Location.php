<?php

/**
 * Created by PhpStorm.
 * User: Anjas Amar Pradana
 * Date: 18.09.24
 * Time: 21:00.
 */

namespace atsicorp\HetznerCloud\Models\Locations;

use atsicorp\HetznerCloud\HetznerAPIClient;
use atsicorp\HetznerCloud\Models\Contracts\Resource;
use atsicorp\HetznerCloud\Models\Model;

class Location extends Model implements Resource
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
     * @var string
     */
    public $description;

    /**
     * @var string
     */
    public $country;

    /**
     * @var string
     */
    public $city;

    /**
     * @var float
     */
    public $latitude;

    /**
     * @var float
     */
    public $longitude;

    /**
     * @var string
     */
    public $network_zone;
    /**
     * @var string
     *
     * @deprecated Use $network_zone instead
     */
    public $networkZone;

    /**
     * Location constructor.
     *
     * @param  int  $id
     * @param  string  $name
     * @param  string  $description
     * @param  string  $country
     * @param  string  $city
     * @param  float  $latitude
     * @param  float  $longitude
     * @param  string  $networkZone
     */
    public function __construct(
        int $id,
        string $name,
        string $description = null,
        string $country = null,
        string $city = null,
        float $latitude = null,
        float $longitude = null,
        string $networkZone = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->country = $country;
        $this->city = $city;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->network_zone = $networkZone;
        $this->networkZone = $networkZone;
        parent::__construct();
    }

    /**
     * @param  $input
     * @return \atsicorp\HetznerCloud\Models\Locations\Location|static
     */
    public static function parse($input)
    {
        if ($input == null) {
            return;
        }
        $networkZone = property_exists($input, 'network_zone') ? $input->network_zone : null;

        return new self($input->id, $input->name, $input->description, $input->country, $input->city, $input->latitude, $input->longitude, $networkZone);
    }

    public function reload()
    {
        return HetznerAPIClient::$instance->locations()->get($this->id);
    }

    public function delete()
    {
        throw new \BadMethodCallException('delete on location is not possible');
    }

    public function update(array $data)
    {
        throw new \BadMethodCallException('update on location is not possible');
    }
}
