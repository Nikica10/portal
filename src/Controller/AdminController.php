<?php
/**
 * Created by PhpStorm.
 * User: Ivana i Nino
 * Date: 17-Feb-19
 * Time: 13:07
 */

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/home", name="adminHome")
     */
    public function adminHome(EntityManagerInterface $em)
    {
        $repository = $em->getRepository(Article::class);
        $articles = $repository->findAll();


        return $this->render('Admin/Article/index.html.twig', array(
            'articles' => $articles
        ));
    }
    /**
     * @Route("/new", name="newArticle")
     */
    public function newArticle(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $article = new Article();


        $form = $this->createFormBuilder($article)
            ->add('title', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
            ->add('content', TextareaType::class, array(
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
            ->add('author', TextareaType::class, array(
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
            ->add('category', EntityType::class, array(
                'class'  => 'App\Entity\Category',
                'attr' => array(
                    'class' => 'form-control'
                )))
            ->add('save', SubmitType::class, array(
                'label' => 'Create Article',
                'attr' => array(
                    'class' => 'btn btn-primary'
                )
            ))

            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $article = $form->getData();

            $entityManager->persist($article);
            $entityManager->flush();

            $this->addFlash(
                'notice',
                'spremljeno u bazu'
            );

            return $this->redirectToRoute('homepage');
        }

        return $this->render('Admin/Article/new.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/category/new", name="newCategory")
     */
    public function newCategory(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $category = new Category();

        $form = $this->createFormBuilder($category)
            ->add('name', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control'
                )
                ))
            ->add('save', SubmitType::class, array(
                'label' => 'Create Category',
                'attr' => array(
                    'class' => 'btn btn-primary'
                )
            ))


        ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $category= $form->getData();

            $entityManager->persist($category);
            $entityManager->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render('Admin/Article/newCategory.html.twig', array(
            'form' => $form->createView()
        ));

    }

    /**
     * @Route("/edit/{id}", name="editArticle")
     */
    public function editArticle(Request $request, $id)
    {
        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);


        $form = $this->createFormBuilder($article)
            ->add('title', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
            ->add('content', TextareaType::class, array(
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
            ->add('author', TextareaType::class, array(
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
            ->add('category', EntityType::class, array(
                'class'  => 'App\Entity\Category',
                'attr' => array(
                    'class' => 'form-control'
                )))
            ->add('save', SubmitType::class, array(
                'label' => 'Create Article',
                'attr' => array(
                    'class' => 'btn btn-primary'
                )
            ))

            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
//            $article = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render('Admin/Article/edit.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/delete/{$id}", name="deleteArticle"),
     */
//    public function deleteArticle(Request $request, $id, EntityManagerInterface $em)
//    {
//        $article = $em->getRepository(Article::class)->find($id);
//
//        $em->remove($article);
//        $em->flush();
//    }

    public function delete(Request $request, $id) {
        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($article);
        $entityManager->flush();
        $response = new Response();
        $response->send();

        return $this->redirectToRoute('homepage');
    }
}