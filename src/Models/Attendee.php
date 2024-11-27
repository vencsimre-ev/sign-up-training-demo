<?php

namespace src\Models;

class Attendee
{
    private $name;
    private $date;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->date = (new \DateTime())->format('Y-m-d H:i');
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDate(): string
    {
        return $this->date;
    }
}
