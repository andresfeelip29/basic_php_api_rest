
<?php

interface IAccountService
{
    function saveAccount($accountEntity);
    function getAllAccount();
    function getAccountById($id);
    function deleteAccount($id);
    function updateAccount($accountEntity);
}
