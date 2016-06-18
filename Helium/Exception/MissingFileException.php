<?php

namespace Helium\Exception;


class MissingFileException extends HeliumException
{
    public function __construct($message, $code = 0, Exception $previous = null)
    {
        $message = 'Missing file: ' . $message;
        parent::__construct($message, $code, $previous);
    }
}