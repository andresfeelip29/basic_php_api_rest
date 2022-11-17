<?php

require "../../libs/connection/BaseConnection.php";
require "../contracts/IAccountRepository.php";

class OwnerRepository extends BaseConnection implements IOwnerRepository
{
    function __construct()
    {
        parent::__construct();
    }

    public function save($ownerEntity)
    {
        $result = null;

        try {
            $query = $this->prepare('INSERT INTO titular (identificacion, nombres, telefono, fecha) VALUES (:identificacion, :nombres, :telefono, :fecha)');

            $query->bindParam(':identificacion', $ownerEntity->identification);
            $query->bindParam(':nombres', $ownerEntity->names);
            $query->bindParam(':telefono', $ownerEntity->phone);
            $query->bindParam(':fecha', $ownerEntity->date);

            if ($query->execute()) {
                error_log("OwnerRepository::Save -> Datos guarado con exito!");
                $result = $query->lastInsertId();
            } else {
                error_log("OwnerRepository::Save -> Erro no se ingresaron los datos!");
            }
            $this->close();
        } catch (PDOException $e) {
            error_log("OwnerRepository::Save -> PDOExepcion: " . $e);
        }


        return $result;
    }

    public function getAll()
    {
        $result = null;
        try {
            $query = $this->query('SELECT * FROM titular');
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            error_log("OwnerRepository::getAll -> Datos consultados cone exito!");
        } catch (PDOException $e) {
            error_log("OwnerRepository::getAll -> PDOExepcion " . $e);
        }

        return $result;
    }

    public function get($id)
    {
        $result = null;
        try {
            $query = $this->prepare('SELECT * FROM titular WHERE id = :id"');
            $query->bindValue('id', $id);
            if ($query->execute()) {
                error_log("OwnerRepository::get(id) -> Consulta realizada con exito en BD!");
                if ($query->rowCount() > 0) {
                    $result = $query->fetch(PDO::FETCH_ASSOC);
                    error_log("OwnerRepository::get(id) -> Usuario existe en BD!");
                } else {
                    error_log("OwnerRepository::get(id) -> Usuario no existe en BD!");
                }
            } else {
                error_log("OwnerRepository::get(id) -> Error al realizar consulta en BD!");
            }
        } catch (PDOException $e) {
            error_log("OwnerRepository::get(id) -> PDOExepcion" . $e);
        }
        return $result;
    }
    public function delete($id)
    {
        $result = false;
        if (OwnerRepository::get($id) != null) {
            try {
                $query = $this->prepare('DELETE FROM titular WHERE id = :id');
                $query->bindValue('id', $id);
                $result = $query->execute();
                if ($result) {
                    error_log("OwnerRepository::Delete(id) -> Datos eliminados con exito en BD!");
                } else {
                    error_log("OwnerRepository::Delete(id) -> No se pudieron eliminaron los datos en BD!");
                }
            } catch (PDOException $e) {
                error_log("OwnerRepository::delete(id) -> PDOExepcion " . $e);
            }
        }
        return $result;
    }

    public function update($ownerEntity)
    {
        $result = false;

        if (OwnerRepository::get($ownerEntity->id) != null) {
            try {
                $query = $this->prepare('UPDATE titular SET identificacion = :identificacion,  nombres = :nombres, telefono = :telefono, fecha = :fecha WHERE id = :id');

                $query->bindParam(':identificacion', $ownerEntity->identification);
                $query->bindParam(':nombres', $ownerEntity->names);
                $query->bindParam(':telefono', $ownerEntity->phone);
                $query->bindParam(':fecha', $ownerEntity->date);
                $result = $query->execute();
                if ($result) {
                    error_log("OwnerRepository::Update -> Datos actualizados con exito en BD!");
                } else {
                    error_log("OwnerRepository::Update -> Error no se pudieron actualizar los datos en BD!");
                }
            } catch (PDOException $e) {
                error_log("OwnerRepository::Update -> PDOExepcion: " . $e);
            }
        }
        return $result;
    }
}
