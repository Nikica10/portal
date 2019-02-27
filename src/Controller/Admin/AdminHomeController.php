<?php
/**
 * Created by PhpStorm.
 * User: Ivana i Nino
 * Date: 23-Feb-19
 * Time: 9:56
 */

namespace App\Controller\Admin;


use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminHomeController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * @Route("admin/", name="adminHome")
     */
    public function adminHomeAction()
    {
        $articles = $this->em
            ->getRepository(Article::class)
            ->findAll();

        return $this->render('Admin/Article/index.html.twig', array(
            'articles' => $articles
        ));
    }
}