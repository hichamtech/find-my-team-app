<?php


namespace App\Manager;


use App\Entity\Post;

interface PostManagerInterface
{
    public function listPost():array;
    public function createPost();

}