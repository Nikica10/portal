<?php
/**
 * Created by PhpStorm.
 * User: Ivana i Nino
 * Date: 16-Feb-19
 * Time: 18:02
 */

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;




class HomeController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(EntityManagerInterface $em)
    {
        $category = 2;
        $repository = $em->getRepository(Article::class);
        $news = $repository->findByCategory($category);

        $category = 1;
        $repository = $em->getRepository(Article::class);
        $sport = $repository->findByCategory($category);


        return $this->render('Home/index.html.twig', array(
            'sport' => $sport,
            'news' => $news
        ));
    }

//    /**
//     * @Route("/category/{$name}", name="categorypage")
//     */
//    public function categoryAction(Request $request, $name)
//    {
//
//
//        $category = $this->getDoctrine()
//            ->getRepository(Article::class)
//            ->findBy($name);
//
//        return $this->render('Home/category.html.twig', array(
//            'category' => $category
//        ));
//    }

    /**
     * @Route("category/{$name}", name="category_article")
     * @param $name
     * @return Response
     */
    public function categoryArticleAction(Request $request, $name)
    {

        $category = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findBy(['category' => $name]);



//dump($category);die();

        return $this->render('Home/category.html.twig', array(
            'category' => $category
        ));
    }

    /**
     * @Route("/single/{$id}", name="categorypage")
     * @param $id
     * @return Response
     */
    public function singleArticleAction(Request $request, $id)
    {
        $article = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findOneBy(['id' => $id]);

        return $this->render('Home/single.html.twig', array(
            'article' => $article
        ));
    }
}