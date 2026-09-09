<?php

namespace AuthorizationSystem\Abstractions;

abstract class PaginatedItems
{
    protected $maxItemsPerPage;

    protected $currentPage;

    protected $numItems;

    protected $numPages;

    protected $offset;

    protected $tableName;

    abstract function getItems();

    abstract function giveNumItems();

    abstract function setError($errorText);

    public function getMaxItemsPerPage()
    {
        return $this->maxItemsPerPage;
    }

    public function getCurrentPage()
    {
        return $this->currentPage;
    }

    public function getNumItems()
    {
        return $this->numItems;
    }

    public function getNumPages()
    {
        return $this->numPages;
    }

    public function getTableName()
    {
        return $this->tableName;
    }

    public function getOffset()
    {
        return $this->offset;
    }

    protected function giveNumPages()
    {
        $maxItemsPerPage = $this->getMaxItemsPerPage();
        $numItems = $this->getNumItems();

        $numPages = ceil($numItems / $maxItemsPerPage);
        $this->setNumPages($numPages);

        return $numPages;
    }

    protected function giveOffset()
    {
        $currentPage = $this->getCurrentPage();
        $maxItemsPerPage = $this->getMaxItemsPerPage();

        $offset = ($currentPage - 1) * $maxItemsPerPage;
        $this->setOffset($offset);

        return $offset;
    }

    protected function setMaxItemsPerPage($value)
    {
        $this->maxItemsPerPage = $value;
    }

    protected function setCurrentPage($value)
    {
        $numPages = $this->getNumPages();

        if ($value <= 0) {
            $this->currentPage = 1;

        } elseif ($value > $numPages) {
            $this->currentPage = $numPages;

        } else {
            $this->currentPage = $value;
        }
    }

    protected function setNumItems($value)
    {
        $this->numItems = $value;
    }

    protected function setNumPages($value)
    {
        $this->numPages = $value;
    }

    protected function setTableName($value)
    {
        $this->tableName = $value;
    }

    protected function setOffset($value)
    {
        $this->offset = $value;
    }
}
