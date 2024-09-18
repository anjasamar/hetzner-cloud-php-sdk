<?php

/**
 * Created by PhpStorm.
 * User: Anjas Amar Pradana
 * Date: 18.09.24
 * Time: 21:01.
 */

namespace atsicorp\HetznerCloud\Models\Datacenters;

use atsicorp\HetznerCloud\HetznerAPIClient;
use atsicorp\HetznerCloud\Models\Contracts\Resource;
use atsicorp\HetznerCloud\Models\Locations\Location;
use atsicorp\HetznerCloud\Models\Model;

class Datacenter extends Model implements Resource
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
     * @var \atsicorp\HetznerCloud\Models\Locations\Location
     */
    public $location;

    /**
     * @var array
     */
    public $server_types;
    /**
     * @var array
     *
     * @deprecated Use $server_types instead
     */
    public $serverTypes;

    /**
     * Datacenter constructor.
     *
     * @param  int  $id
     * @param  string  $name
     * @param  string  $description
     * @param  \atsicorp\HetznerCloud\Models\Locations\Location  $location
     * @param  array  $server_types
     */
    public function __construct(
        int $id,
        string $name,
        string $description,
        Location $location,
        $server_types = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->location = $location;
        $this->server_types = $server_types;
        $this->serverTypes = $server_types;
        parent::__construct();
    }

    /**
     * @param  $input
     * @return \atsicorp\HetznerCloud\Models\Datacenters\Datacenter|static
     */
    public static function parse($input)
    {
        if ($input == null) {
            return;
        }

        return new self($input->id, $input->name, $input->description, Location::parse($input->location), $input->server_types);
    }

    public function reload()
    {
        return HetznerAPIClient::$instance->datacenters()->get($this->id);
    }

    public function delete()
    {
        throw new \BadMethodCallException('delete on datacenter is not possible');
    }

    public function update(array $data)
    {
        throw new \BadMethodCallException('update on datacenter is not possible');
    }
}
