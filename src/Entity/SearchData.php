<?php


namespace App\Entity;


class SearchData
{
    /**
     * @var int
     */
    public $page = 1;

    /**
     * @var string
     */
    public $q = '';

    /**
     * @var City
     */
    public $city = [];


}