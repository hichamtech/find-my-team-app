<?php


namespace App\Manager;


use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Security\Core\Security;

/**
 * Class PostManager
 * @package App\Manager
 */
class PostManager implements PostManagerInterface
{
    /**
     * @var PostRepository
     */
    private $postRepository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var FormFactoryInterface
     */
    private $factory;

    private $security;
    public function __construct(PostRepository $postRepository,EntityManagerInterface $entityManager,FormFactoryInterface $formFactory,Security $security)
    {
        $this->postRepository = $postRepository;
        $this->entityManager = $entityManager;
        $this->factory = $formFactory;
        $this->security = $security;
    }

    public function listPost(): array
    {
        return  $this->postRepository->findAll();
    }

    public function createPost(Post $post)
    {
        $user = $this->security->getUser();

        $post = new Post();
        $post->setAuthor($user);
        $post->setCreatedAt(new \DateTime('now'));//todo crate trait
        $this->entityManager->persist($post);
        $this->entityManager->flush();

    }
}