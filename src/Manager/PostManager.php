<?php


namespace App\Manager;


use App\Entity\Post;
use App\Repository\PostRepository;

class PostManager implements PostManagerInterface
{
    /**
     * @var PostRepository
     */
    private $postRepository;

    private $request;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function listPost(): array
    {
        return  $this->postRepository->findAll();
    }

    public function createPost()
    {

    }
}