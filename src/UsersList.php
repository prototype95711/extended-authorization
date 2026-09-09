<?php

namespace AuthorizationSystem;

class UsersList extends Abstractions\PaginatedItems
{
    public function __construct($page) 
    {
        $this->setMaxItemsPerPage(USERS_LIST_MAX_PER_PAGE);
        $this->setTableName(TABLE_PREFIX . TABLE_USERS);

        $numItems = $this->giveNumItems();

        if (empty($numItems)) {
            $this->setError("Ни одного пользователя нет в базе данных!");
        }
        
        $numPages = $this->giveNumPages();
        $this->setCurrentPage($page);
        $offset = $this->giveOffset();
    }

    public function getItems()
    {
        $table = $this->getTableName();
        $limit = $this->getMaxItemsPerPage();
        $offset = $this->getOffset();

        $items = Database::getDb()->getAll("SELECT * FROM ?n LIMIT ?i OFFSET ?i", $table, $limit, $offset);

        return $items;
    }

    public function giveNumItems()
    {
        $table = $this->getTableName();

        $numItems = Database::getDb()->getOne("SELECT COUNT(*) AS num FROM ?n", $table);
        $this->setNumItems($numItems);

        return $numItems;
    }

    public function setError($errorText)
    {
        throw new \Exception($errorText);
    }
}
