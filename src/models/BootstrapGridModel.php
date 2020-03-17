<?php

namespace nthmedia\bootstrapgrid\models;

use yii\base\Model as BaseModel;

class BootstrapGridModel extends BaseModel
{
    /** @var ?int  */
    public $col = 12;

    /** @var ?int */
    public $offset = 0;

    public function __construct($attributes = [], array $config = [])
    {
        foreach ($attributes as $key => $value) {
            if (property_exists($this, $key)) {
                $this[$key] = $value;
            }
        }
        parent::__construct($config);
    }
}
