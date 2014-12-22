<?php

namespace BackBee\Utils\Exception;

use Exception;

/**
 * @author Mickaël Andrieu <mickael.andrieu@lp-digital.fr>
 */
class InvalidArgumentException extends Exception
{
    /**
     * Construct
     *
     * @param string $message Message
     */
    public function __construct($message = "")
    {
        $message = empty($message) ? 'Invalid argument exception.' : $message;

        parent::__construct($message, 0, null);
    }
}
