<?php

namespace App\Controller;

use App\Entity\Message;
use App\Entity\Post;
use App\Entity\SearchData;
use App\Entity\SearchPost;
use App\Form\MessageType;
use App\Form\PostSearchType;
use App\Form\PostType;
use App\Form\SearchForm;
use App\Manager\PostManagerInterface;
use App\Repository\MessageRepository;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class HomeController extends AbstractController
{

    /**
     * @Route("/", name="home", methods={"GET","POST"})
     */
    public function index(Request $request,PostRepository $postRepository): Response
    {

        $data = new SearchData();
        $formData = $this->createForm(SearchForm::class, $data);
        $formData->handleRequest($request);
        $posts = $postRepository->findSearch($data);

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
            'postForm'=>$form->createView(),
            'formData' =>$formData->createView()

        ]);
    }
    /**
     * @Route("/messages/{id}", name="message", methods={"GET","POST"})
     */
    public function messages(Request $request,Post $post,MessageRepository $messageRepository)
    {
        $receivedMessages = $messageRepository->findByReceiver($this->getUser());


        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $message->addSender($this->getUser());
            $message->setReceiver($post->getAuthor());
            $message->setCreatedAt(new \DateTime());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($message);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('home/messages.html.twig', [
            'form' => $form->createView(),
            'receivedMessages' => $receivedMessages
        ]);
    }

}
