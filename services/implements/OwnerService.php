<?php

require "../contracts/IOwnerService.php";
require "../../dao/contracts/IOwnerRepository.php";

class OwnerService implements IOwnerService
{
    private IOwnerRepository $_ownerRepository;

    public function __construct(IOwnerRepository $ownerRepository)
    {
        $this->_ownerRepository = $ownerRepository;
    }

    public function saveOwner($ownerEntity)
    {
        $result = null;
        if (OwnerService::validateData($ownerEntity)) {
            $result = $this->_ownerRepository->save($ownerEntity);
            if (GenericValidators::isNumber($result) && $result > 0) {
                error_log("OwnerService::saveOwner() -> Titular agregado con exito!");
            } else {
                error_log("OwnerService::saveOwner() -> No se pudo agregar titular!");
            }
        }
        return $result;
    }
    public function getAllOwner()
    {
        return $this->_ownerRepository->getAll();
    }
    public function getOwnerById($id)
    {
        $result = null;
        if (GenericValidators::isNumber($id) && $id > 0) {
            $result = $this->_ownerRepository->get($id);
            if (!empty($result)) {
                error_log("OwnerService::getOwnerById() -> Titular obtenido con exito!");
            } else {
                error_log("OwnerService::getOwnerById() -> No se pudo obtener titular!");
            }
        }
        return $result;
    }
    public function deleteOwner($id)
    {
        $result = false;
        if (!empty(OwnerService::getOwnerById($id))) {
            $result = $this->_ownerRepository->delete($id);
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
    public function updateOwner($ownerEntity)
    {
        $result = false;
        if (!empty(OwnerService::getOwnerById($ownerEntity->id))) {
            $result = $this->_ownerRepository->update($ownerEntity);

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

    private function validateData($ownerEntity)
    {
        $result = true;
        if (empty($ownerEntity)) {
            $result = false;
        } else {
            if (empty($ownerEntity->identification)) {
                $result = false;
            }
            if (empty($ownerEntity->names)) {
                $result = false;
            }
            if (empty($ownerEntity->phone)) {
                $result = false;
            }
            if (empty($ownerEntity->date)) {
                $result = false;
            }
        }
        return $result;
    }
}
