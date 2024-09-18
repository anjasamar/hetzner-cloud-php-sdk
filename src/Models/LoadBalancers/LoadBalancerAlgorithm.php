<?php

namespace atsicorp\HetznerCloud\Models\LoadBalancers;

use atsicorp\HetznerCloud\Models\Model;

class LoadBalancerAlgorithm extends Model
{
    /**
     * @var string
     */
    public $type;

    /**
     * @param  string  $type
     */
    public function __construct(string $type)
    {
        $this->type = $type;
        parent::__construct();
    }

    /**
     * @param  $input
     * @return \atsicorp\HetznerCloud\Models\LoadBalancers\LoadBalancerAlgorithm|null|static
     */
    public static function parse($input)
    {
        if ($input == null) {
            return;
        }

        return new self($input->type);
    }
}
