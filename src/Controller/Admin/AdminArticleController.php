<?php
/**
 * Created by PhpStorm.
 * User: Ivana i Nino
 * Date: 23-Feb-19
 * Time: 10:20
 */

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Form\ArticleType;
use App\Entity\Article;
use App\Form\CategoryType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class AdminArticleController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * @Route("admin/article/new", name="newArticle")
     */
    public function newArticleAction(Request $request)
    {
        $article = new Article();

        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $article = $form->getData();

            $this->em->persist($article);
            $this->em->flush();

            return $this->redirectToRoute('adminHome');
        }

        return $this->render('Admin/Article/new.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("admin/article/{id}/edit", name="editArticle")
     */
    public function editArticleAction(Request $request, $id)
    {

        $article = $this->em
            ->getRepository(Article::class)
            ->findOneBy(['id' => $id]);

        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $article = $form->getData();

            $this->em->persist($article);
            $this->em->flush();

            return $this->redirectToRoute('adminHome');
        }

        return $this->render('admin/article/edit.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("admin/article/{id}/delete", name="deleteArticle")
     */
    public function deleteArticleAction(Request $request, $id)
    {
        $article = $this->em
            ->getRepository(Article::class)
            ->findOneBy(['id' => $id]);

        $this->em->remove($article);
        $this->em->flush();

        return $this->redirectToRoute('adminHome');
    }




}