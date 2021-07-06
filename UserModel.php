<?php

namespace hoangtu\phpmvc\core;

use hoangtu\phpmvc\core\database\DbModel;

abstract class UserModel extends DbModel
{
    abstract public function getDisplayName(): string;
}
