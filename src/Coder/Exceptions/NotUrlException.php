<?php

namespace App\Coder\Exceptions;

use InvalidArgumentException;

class NotUrlException extends InvalidArgumentException {
    protected $message = 'The pasted data is not a valid URL';
}