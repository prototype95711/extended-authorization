<?php

namespace AuthorizationSystem;

class UrlParser
{   
    private $root;
    private $server;
    private $delimiter = '/';
     
    public function __construct() 
    {
        $this->setServer($_SERVER);
    }

    public function parseUrl() 
    {
        $server = $this->getServer();

        $this->setRoot($server["PHP_SELF"]);

        return $this->getRequestUrl($server["REQUEST_URI"]);
    }

    public function getRoot() 
    {
        return $this->root;
    }

    public function getServer() 
    {
        return $this->server;
    }

    public function getDelimiter() 
    {
        return $this->delimiter;
    }

    private function getRequestUrl($url) 
    {
        $root = $this->getRoot();
        $url = substr($url, strlen($root));

        return $this->parseRequestUrl($url);
    }

    private function parseRequestUrl($url) 
    {
        $delimiter = $this->getDelimiter();
        $url = $this->replaceSymbol($url, '\\', $delimiter);
        $url = explode($delimiter, $url);

        $result = array();

        for ($i = 0; $i < count($url); $i++) {

            if (empty($url[$i])) {
                continue;
            } 

            $pos = strpos($url[$i], ".");

            if (empty($pos)) {
                $result[] = $url[$i];
                continue;
            }

            $result[] = substr($url[$i], 0, $pos);
        }

        return $result;
    }

    private function replaceSymbol($str='', $oldSymbol = '\\', $newSymbol = '/') 
    {
        for ($i = 0; $i < strlen($str); $i++) {

            if ($str[$i] == $oldSymbol)  {
                $str[$i] = $newSymbol;
            }
        }

        return $str;
    }

    private function setRoot($root) 
    {
        $delimiter = $this->getDelimiter();
        $root = $this->parseRequestUrl($root);
        $root = array_slice($root, 0, count($root) - 1);
        $root = $delimiter . implode($delimiter, $root);
        $this->root = $root;
    }

    private function setServer($server) 
    {
        $this->server = $server;
    }
}
