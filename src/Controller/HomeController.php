<?php
/**
 * Created by PhpStorm.
 * User: Ivana i Nino
 * Date: 16-Feb-19
 * Time: 18:02
 */

namespace App\Controller;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class HomeController extends AbstractController
{
    private $em;

    /**
     * HomeController Constructor
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        $categoryID = 2;
        $repository = $this->em->getRepository(Article::class);
        $news = $repository->findByCategory($categoryID);

        $categoryID = 1;
        $repository = $this->em->getRepository(Article::class);
        $sport = $repository->findByCategory($categoryID);


        return $this->render('Home/index.html.twig', array(
            'sport' => $sport,
            'news' => $news
        ));
    }

    /**
     * @Route("/single/{id}", name="singleArticle")
     */
    public function singleArticle($id)
    {
        $singleArticle = $this->em->getRepository(Article::class)->findOneBy(['id'=>$id]);

        return $this->render('home/single.html.twig', array(
            'article' => $singleArticle
        ));
    }

}