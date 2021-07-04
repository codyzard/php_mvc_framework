<?php

namespace hoangtu\phpmvc;

use hoangtu\phpmvc\database\DbModel;

abstract class UserModel extends DbModel
{
    abstract public function getDisplayName(): string;
}
