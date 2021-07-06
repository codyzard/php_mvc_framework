<?php

namespace hoangtu\core;

use hoangtu\core\database\DbModel;

abstract class UserModel extends DbModel
{
    abstract public function getDisplayName(): string;
}
