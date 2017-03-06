<?php

class Paging
{
    private $n = 12;
    private $p = 1;
    private $pages = 1;

    public function __construct($n)
    {
        $this->n = $n;
        $this->setP();
    }

    public function getN()
    {
        return $this->n;
    }

    public function setN($n)
    {
        $this->n = $n;
    }

    public function getP()
    {
        return $this->p;
    }

    public function setP()
    {
        if (isset($_GET['p'])) {
            $this->p = $_GET['p'];
        }
    }

    public function getPages()
    {
        return $this->pages;
    }

    public function setPages($pages)
    {
        $this->pages = $pages;
    }

    public function calcPages($all)
    {
        $this->pages = ceil($all / $this->n);
    }

    public function getOffset()
    {
        return $this->n * ($this->p - 1);
    }

}