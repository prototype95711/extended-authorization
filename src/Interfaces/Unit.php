<?php

namespace AuthorizationSystem\Interfaces;

interface Unit
{
    public function getTableName();
    public function getData();
    public function prepareDataForDatabase();
    public function setError($errorText);
}
