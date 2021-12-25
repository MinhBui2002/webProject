<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Category;
use App\Form\CategoryType;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category/viewall/" , name = "view_all_category")
     */
    public function viewAllCategory () {
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();
        return $this->render("category/index.html.twig",
            [
                'categories' => $categories
            ]
        );
    }

    /**
     * @Route("/category/view/{id}", name = "view_category")
     */
    public function viewCategory ($id) {
        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);
        if ($category != null) {
            return $this->render("category/detail.html.twig",
            [
                'category' => $category
            ]
            );
        } else {
            return $this->redirectToRoute("view_all_category");
        }     
    }

    /**
     * @Route("/category/delete/{id}", name = "delete_category_by_id")
     */
    public function deleteCategory ($id) {
        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);
        if ($category != null) {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($category);
            $manager->flush();
        }
        return $this->redirectToRoute("view_all_category");
    }

    /**
     * @Route("/category/add", name = "add_category")
     */
    public function addCategory (Request $request) {
        $category = new category;
        $categoryForm = $this->createForm(CategoryType::class, $category);
        $categoryForm->handleRequest($request);
        if ($categoryForm->isSubmitted() && $categoryForm->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($category);
            $manager->flush();
            return $this->redirectToRoute("view_all_category");
        }
        return $this->renderForm("category/add.html.twig",
        [
            'categoryForm' => $categoryForm
        ]);
    }

    /**
     * @Route("/category/edit/{id}", name = "edit_category")
     */
    public function editCategory (Request $request, $id) {
        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);
        $categoryForm = $this->createForm(categoryType::class, $category);
        $categoryForm->handleRequest($request);
        if ($categoryForm->isSubmitted() && $categoryForm->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($category);
            $manager->flush();
            return $this->redirectToRoute("view_all_category");
        }
        return $this->renderForm("category/edit.html.twig",
        [
            'categoryForm' => $categoryForm
        ]);
    }
}
