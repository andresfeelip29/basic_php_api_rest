<?php

require "../contracts/IAccountService.php";
require "../../dao/contracts/IAccountRepository.php";

class AccountService implements IAccountService
{
    private IAccountRepository $_accountRepository;

    public function __construct(IAccountRepository $accountRepository)
    {
        $this->_accountRepository = $accountRepository;
    }
    public function saveAccount($accountEntity)
    {
        $result = null;
        if (AccountService::validateData($accountEntity)) {
            $result = $this->_accountRepository->save($accountEntity);
            if (GenericValidators::isNumber($result) && $result > 0) {
                error_log("OwnerService::saveOwner() -> Titular agregado con exito!");
            } else {
                error_log("OwnerService::saveOwner() -> No se pudo agregar titular!");
            }
        }
        return $result;
    }
    public function getAllAccount()
    {
        return $this->_accountRepository->getAll();
    }
    public function getAccountById($id)
    {
        $result = null;
        if (GenericValidators::isNumber($id) && $id > 0) {
            $result = $this->_accountRepository->get($id);
            if (!empty($result)) {
                error_log("OwnerService::getOwnerById() -> Titular obtenido con exito!");
            } else {
                error_log("OwnerService::getOwnerById() -> No se pudo obtener titular!");
            }
        }
        return $result;
    }
    public function deleteAccount($id)
    {
        $result = false;
        if (!empty(AccountService::getAccountById($id))) {
            $result = $this->_accountRepository->delete($id);
            if ($result) {
                error_log("OwnerService::deleteOwner() -> Titular eliminado con exito!");
            } else {
                error_log("OwnerService::deleteOwner() -> No se pudo eliminar titular!");
            }
        } else {
            error_log("OwnerService::deleteOwner() -> No se econtro titular en BD!");
        }
        return $result;
    }
    public function updateAccount($accountEntity)
    {
        $result = false;
        if (!empty(AccountService::getAccountById($accountEntity->id))) {
            $result = $this->_accountRepository->update($accountEntity);

            if ($result) {
                error_log("OwnerService::updateOwner() -> Titular actualizado con exito!");
            } else {
                error_log("OwnerService::updateOwner() -> No se pudo actualizar titular!");
            }
        } else {
            error_log("OwnerService::updateOwner() -> No se econtro titular en BD!");
        }
        return $result;
    }

    private function validateData($accountEntity)
    {
        $result = true;

        if (empty($accountEntity)) {
            $result = false;
        } else {
            if (empty($accountEntity->idOwner)  || !GenericValidators::isNumber($accountEntity->idOwner) || $accountEntity->idOwner <= 0) {
                $result = false;
            }
            if (empty($accountEntity->type)) {
                $result = false;
            }
            if (empty($accountEntity->observation)) {
                $result = false;
            }
            if (empty($accountEntity->transactionNumber)) {
                $result = false;
            }
            if (empty($accountEntity->balance)) {
                $result = false;
            }
            if (empty($accountEntity->email)) {
                $result = false;
            }
        }
        return $result;
    }
}
