<?php

/**
 * Created by PhpStorm.
 * User: Anjas Amar Pradana
 * Date: 18.09.24
 * Time: 13:51.
 */

namespace atsicorp\HetznerCloud\Models\Datacenters;

use atsicorp\HetznerCloud\RequestOpts;

class DatacenterRequestOpts extends RequestOpts
{
    /**
     * @var string
     */
    public $name;

    /**
     * RequestOpts constructor.
     *
     * @param  $name
     * @param  $perPage
     * @param  $page
     * @param  $labelSelector
     */
    public function __construct(string $name = null, int $perPage = null, int $page = null, string $labelSelector = null)
    {
        parent::__construct($perPage, $page, $labelSelector);
        $this->name = $name;
    }
}
