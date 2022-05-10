<?php

namespace Drupal\favorites;

class FirstObject {
    protected $param;
    public function __construct() {
        $this->param = 'The First Param';
    }

    public function getParam() {
        return $this->param;
    }
}