<?php

namespace Advans\Api\Lco;

use Exception;

class Config {

    public $base_url, $key;

    /**
     * @throws Exception
     */
    public function __construct($args) {
        $this->base_url = $args['base_url'] ?? null;
        if (!$this->base_url) {
            throw new Exception('base_url is required');
        }
        if (substr($this->base_url, -1, 1) != '/') {
            $this->base_url .= '/';
        }

        $this->key = $args['key'] ?? null;
        if (!$this->key) {
            throw new Exception('key is required');
        }
    }
}