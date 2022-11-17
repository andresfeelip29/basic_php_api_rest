

<?php

require "../../libs/connection/BaseConnection.php";
require "../contracts/IAccountRepository.php";

class AccountRepository extends BaseConnection implements IAccountRepository
{
    function __construct()
    {
        parent::__construct();
    }

    public function save($accountEntity)
    {
        $result = null;

        try {
            $query = $this->prepare('INSERT INTO cuentas (id_titular, tipo, observacion, fecha_registro, numero_transacciones, saldo, corre_activacion)
            VALUES (:id_titular, :tipo, :observacion, :fecha_registro, :numero_transacciones, :saldo, :corre_activacion)');

            $query->bindValue(':id_titular', $accountEntity->idOwner);
            $query->bindValue(':tipo', $accountEntity->type);
            $query->bindValue(':observacion', $accountEntity->observation);
            $query->bindValue(':fecha_registro', $accountEntity->registerDate);
            $query->bindValue(':numero_transacciones', $accountEntity->transactionNumber);
            $query->bindValue(':saldo', $accountEntity->balance);
            $query->bindValue(':corre_activacion', $accountEntity->email);

            if ($query->execute()) {
                error_log("AccountRepository::Save -> Datos guarado con exito!");
                $result = $query->lastInsertId();
            } else {
                error_log("AccountRepository::Save -> Erro no se ingresaron los datos!");
            }
            $this->close();
        } catch (PDOException $e) {
            error_log("AccountRepository::Save -> PDOExepcion: " . $e);
        }


        return $result;
    }

    public function getAll()
    {
        $result = null;
        try {
            $query = $this->query('SELECT * FROM cuentas AS c INNER JOIN titular AS t ON t.id = c.id_titular');
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            error_log("AccountRepository::getAll -> Datos consultados cone exito!");
        } catch (PDOException $e) {
            error_log("AccountRepository::getAll -> PDOExepcion " . $e);
        }

        return $result;
    }

    public function get($id)
    {
        $result = null;
        try {
            $query = $this->prepare('SELECT * FROM cuentas AS c
            INNER JOIN titular AS t ON t.id = c.id_titular
            WHERE c.id = :id');
            $query->bindValue('id', $id);
            if ($query->execute()) {
                error_log("AccountRepository::get(id) -> Consulta realizada con exito en BD!");
                if ($query->rowCount() > 0) {
                    $result = $query->fetch(PDO::FETCH_ASSOC);
                    error_log("AccountRepository::get(id) -> Usuario existe en BD!");
                } else {
                    error_log("AccountRepository::get(id) -> Usuario no existe en BD!");
                    $result = 0;
                }
            } else {
                error_log("AccountRepository::get(id) -> Error al realizar consulta en BD!");
            }
        } catch (PDOException $e) {
            error_log("AccountRepository::get(id) -> PDOExepcion" . $e);
        }
        return $result;
    }
    public function delete($id)
    {
        $result = false;
        if (AccountRepository::get($id) != null) {
            try {
                $query = $this->prepare('DELETE FROM cuentas WHERE id = :id');
                $query->bindValue('id', $id);
                $result = $query->execute();
                if ($result) {
                    error_log("AccountRepository::Delete(id) -> Datos eliminados con exito en BD!");
                } else {
                    error_log("AccountRepository::Delete(id) -> No se pudieron eliminaron los datos en BD!");
                }
            } catch (PDOException $e) {
                error_log("AccountRepository::delete(id) -> PDOExepcion " . $e);
            }
        }
        return $result;
    }
    public function update($accountEntity)
    {
        $result = false;

        if (AccountRepository::get($accountEntity->id) != null) {
            try {
                $query = $this->prepare('UPDATE cuentas SET id_titular = :id_titular, tipo = :tipo,
                observacion = :observacion, fecha_registro = :fecha_registro,
                numero_transacciones = :numero_transacciones, saldo = :saldo,
                corre_activacion = :corre_activacion WHERE id = :id');

                $query->bindParam(':id', $accountEntity->id);
                $query->bindParam(':id_titular', $accountEntity->idOwner);
                $query->bindParam(':tipo', $accountEntity->type);
                $query->bindParam(':observacion', $accountEntity->observation);
                $query->bindParam(':fecha_registro', $accountEntity->registerDate);
                $query->bindParam(':numero_transacciones', $accountEntity->transactionNumber);
                $query->bindParam(':saldo', $accountEntity->balance);
                $query->bindParam(':corre_activacion', $accountEntity->email);

                $result = $query->execute();
                if ($result) {
                    error_log("AccountRepository::Update -> Datos actualizados con exito en BD!");
                } else {
                    error_log("AccountRepository::Update -> Error no se pudieron actualizar los datos en BD!");
                }
            } catch (PDOException $e) {
                error_log("AccountRepository::Update -> PDOExepcion: " . $e);
            }
        }
        return $result;
    }
}
