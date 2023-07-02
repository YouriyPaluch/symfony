<?php

namespace App\Coder\Exceptions;

use Exception;

class EntityNotSaveException extends Exception {
    protected $message = 'Entity not save in DB';
}