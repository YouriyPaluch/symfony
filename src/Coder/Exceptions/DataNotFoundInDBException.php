<?php

namespace App\Coder\Exceptions;

use InvalidArgumentException;

class DataNotFoundInDBException extends InvalidArgumentException {
    protected $message = 'Code was not found in DB';
}