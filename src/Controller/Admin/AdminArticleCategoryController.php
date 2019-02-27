<?php
/**
 * Created by PhpStorm.
 * User: Ivana i Nino
 * Date: 24-Feb-19
 * Time: 16:06
 */

namespace App\Controller\Admin;


use App\Entity\Category;
use App\Form\CategoryType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminArticleCategoryController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * @Route("/category", name="categoryList")
     */
    public function categoryList()
    {
        $categoryList = $this->em
            ->getRepository(Category::class)
            ->findAll();

        return $this->render('admin/category/index.html.twig', array(
            'category' => $categoryList
        ));
    }

    /**
     * @Route("admin/category/new", name="newCategory")
     */
    public function newCategoryAction(Request $request)
    {
        $category = new Category();

        $form =$this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $category = $form->getData();

            $this->em->persist($category);
            $this->em->flush();

            return $this->redirectToRoute('adminHome');
        }

        return $this->render('admin/article/newCategory.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("admin/category/{id}/edit", name="editCategory")
     */
    public function editCategory(Request $request, $id)
    {
        $category = $this->em->getRepository(Category::class)->find($id);

        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $form->getData();

            $this->em->persist($category);
            $this->em->flush();

            return $this->redirectToRoute('categoryList');
        }

        return $this->render('admin/category/categoryEdit.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("admin/category/{id)/delete", name="deleteCategory")
     */
    public function deleteCategoryAction(Request $request, $id)
    {
        $category = $this->em->getRepository(Category::class)->find($id);

        $this->em->remove($category);
        $this->em->flush();

        return $this->redirectToRoute('adminHome');
    }
}