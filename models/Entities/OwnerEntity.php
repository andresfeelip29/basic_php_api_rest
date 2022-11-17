<?php

class OwnerEntity implements JsonSerializable
{

    private $id;
    private $identification;
    private $names;
    private $phone;
    private $date;

    function __construct(
        $id,
        $identification,
        $names,
        $phone,
        $date
    ) {
        $this->id = $id;
        $this->idOwner = $identification;
        $this->type = $names;
        $this->observation = $phone;
        $this->creationDate = $date;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'identificacion' => $this->identification,
            'nombres' => $this->names,
            'telefono' => $this->phone,
            'fecha' => $this->date,
        ];
    }

    public function getId()
    {
        return $this->id;
    }

    public function getIidentification()
    {
        return $this->identification;
    }

    public function getNames()
    {
        return $this->names;
    }

    public function getPhone()
    {
        return $this->phone;
    }
    public function getDate()
    {
        return $this->date;
    }
}
