<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Articles;
use App\Entity\Category;
use App\Repository\ArticlesRepository;

/* FORM */
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index()
    {
        $repo = $this->getDoctrine()->getRepository(Articles::class);
        $articles = $repo->findAll();

        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('blog/home.html.twig');
    }

    /**
     * @Route("/blog/new", name="blog_create")
     * @Route("/blog/{id}/edit", name="blog_edit")
     */
    public function form(Articles $article = null, Request $request, ObjectManager $manager)
    {
        // To create new article
        if(!$article) {
            $article = new Articles();
        }
        

        $form = $this->createFormBuilder($article)
                        ->add('title', TextType::class)
                        ->add('content', TextareaType::class)
                        ->add('image', TextType::class)
                        ->add('category', EntityType::class, [
                            'class' => Category::class,
                            'choice_label' => 'title'
                        ])
                        ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            // If new article
            if(!$article->getId()) {
                $article->setCreatedAt(new \Datetime());
            }
           

            $manager->persist($article);
            $manager->flush();

            return $this->redirectToRoute('blog_show', [
                'id' => $article->getId()
            ]);
        }



        return $this->render('blog/create.html.twig', [
            'formArticle' => $form->createView(),
            'editForm' => $article->getId() !== null
        ]);
    }

    /**
     * @Route("/blog/{id}", name="blog_show")
     */
    public function show($id)
    {
        $repo = $this->getDoctrine()->getRepository(Articles::class);
        $article = $repo->find($id);
        return $this->render('blog/show.html.twig', [
            'article' => $article
        ]);
    }

}
