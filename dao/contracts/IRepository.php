<?php

interface IRepository
{
    function save($entity);
    function getAll();
    function get($id);
    function delete($id);
    function update($entity);
}
