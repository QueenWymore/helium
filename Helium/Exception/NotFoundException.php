<?php
/**
 * Created by PhpStorm.
 * User: reynevan
 * Date: 11.04.16
 * Time: 18:08
 */

namespace Helium\Exception;


use Helium\Http\Request;

class NotFoundException extends HeliumException
{
    public function __construct(Request $request)
    {
        http_response_code(404);
        $message = 'Route not found. Path: ' . $request->getPath() . ', method: ' . $request->getMethod();
        parent::__construct($message, 0, null);
    }
}