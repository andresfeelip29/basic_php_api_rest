<?php

class AccountEntity implements JsonSerializable
{

    private $id;
    private $idOwner;
    private $type;
    private $observation;
    private $creationDate;
    private $registerDate;
    private $transactionNumber;
    private $balance;
    private $email;


    function __construct(
        $id,
        $idOwner,
        $type,
        $observation,
        $creationDate,
        $registerDate,
        $transactionNumber,
        $balance,
        $email
    ) {
        $this->id = $id;
        $this->idOwner = $idOwner;
        $this->type = $type;
        $this->observation = $observation;
        $this->creationDate = $creationDate;
        $this->registerDate = $registerDate;
        $this->transactionNumber = $transactionNumber;
        $this->balance = $balance;
        $this->email = $email;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'idTitular' => $this->idOwner,
            'tipo' => $this->type,
            'observacion' => $this->observation,
            'fechaCreacion' => $this->creationDate,
            'fechaRegistro' => $this->registerDate,
            'numeroTransacciones' => $this->transactionNumber,
            'saldo' => $this->balance,
            'correo' => $this->email,
        ];
    }

    public function getId()
    {
        return $this->id;
    }

    public function getIdOwner()
    {
        return $this->idOwner;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getObservation()
    {
        return $this->observation;
    }
    public function getCreationDate()
    {
        return $this->creationDate;
    }
    public function getRegisterDate()
    {
        return $this->registerDate;
    }
    public function getTransactionNumber()
    {
        return $this->transactionNumber;
    }
    public function getBalance()
    {
        return $this->balance;
    }
    public function getEmail()
    {
        return $this->email;
    }
}
