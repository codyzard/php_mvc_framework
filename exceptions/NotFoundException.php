<?php

namespace hoangtu\phpmvc\core\exceptions;

class NotFoundException extends \Exception
{
    protected $message = 'Page not found';
    protected $code = 404;
}
