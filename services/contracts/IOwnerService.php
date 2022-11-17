<?php

interface IOwnerService
{
    function saveOwner($ownerEntity);
    function getAllOwner();
    function getOwnerById($id);
    function deleteOwner($id);
    function updateOwner($ownerEntity);
}
