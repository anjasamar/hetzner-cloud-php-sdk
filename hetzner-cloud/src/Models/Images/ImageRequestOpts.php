<?php

/**
 * Created by PhpStorm.
 * User: Anjas Amar Pradana
 * Date: 18.09.24
 * Time: 13:51.
 */

namespace atsicorp\HetznerCloud\Models\Images;

use atsicorp\HetznerCloud\RequestOpts;

class ImageRequestOpts extends RequestOpts
{
    /**
     * @var string
     */
    public $name;

    /** @var string */
    public $architecture;

    /**
     * RequestOpts constructor.
     *
     * @param  string|null  $name
     * @param  int|null  $perPage
     * @param  int|null  $page
     * @param  string|null  $labelSelector
     * @param  string|null  $architecture
     */
    public function __construct(string $name = null, int $perPage = null, int $page = null, string $labelSelector = null, string $architecture = null)
    {
        parent::__construct($perPage, $page, $labelSelector);
        $this->name = $name;
        $this->architecture = $architecture;
    }
}
