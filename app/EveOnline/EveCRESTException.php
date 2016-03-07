<?php

namespace App\EveOnline;

use Exception;

class EveCRESTException extends Exception
{
    function __construct($message, $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
};
