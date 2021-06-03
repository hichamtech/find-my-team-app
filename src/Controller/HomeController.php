<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Manager\PostManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class HomeController extends AbstractController
{
    /**
     * @var PostManagerInterface
     */
    private $postInterface;

    /**
     * HomeController constructor.
     * @param PostManagerInterface $postInterface
     */
    public function __construct(PostManagerInterface $postInterface)
    {
        $this->postInterface = $postInterface;
    }

    /**
     * @Route("/", name="home", methods={"GET","POST"})
     */
    public function index(Request $request): Response
    {
        $posts = $this->postInterface->listPost();

        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
            $post->setAuthor($this->getUser());
            $post->setCreatedAt(new \DateTime());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('home/index.html.twig', [
            'posts' => $posts,
            'postForm'=>$form->createView()

        ]);
    }


}
