<?php

namespace App\Controller;


use App\Entity\Article;
use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleCategoryController extends AbstractController
{
    private $em;
    /**
     * articleCategory Controller
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * @Route("/category/{name}", name="showCategory")
     * @param $name
     * @return Response
     */
    public function articleCategoryAction(Request $request, $name)
    {
        $articleByCategory = $this->em->getRepository(Article::class)
            ->findBy(['category' => 1]);

        return $this->render('Home/category.html.twig', array(
            'article' => $articleByCategory
        ));
    }
}