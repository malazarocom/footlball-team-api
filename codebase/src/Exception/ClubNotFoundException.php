<?php

namespace App\Exception;

class ClubNotFoundException extends \RuntimeException
{

    public function __construct(int $id)
    {
        parent::__construct("Club #" . $id . " was not found");
    }
}
