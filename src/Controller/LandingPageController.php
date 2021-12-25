<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LandingPageController extends AbstractController
{
    
    /**
     * @Route("/customer/landingPage/", name="landing_page_category")
     */
    public function viewAllCategory () {
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();
        return $this->render("customer/index.html.twig",
            [
                'categories' => $categories
            ]
        );
    }

    /**
     * @Route("/customer/viewCategory/{id}", name = "landing_page_view_category")
     */
    public function viewCategory ($id) {
        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);
        if ($category != null) {
            return $this->render("customer/categoryDetail.html.twig",
            [
                'category' => $category
            ]
            );
        } else {
            return $this->redirectToRoute("landing_page_category");
        }     
    }

    /**
     * @Route("/customer/viewProduct/{id}", name = "landing_page_view_product")
     */
    public function viewProduct ($id) {
        $product = $this->getDoctrine()->getRepository(Product::class)->find($id);
        if ($product != null) {
            return $this->render("customer/productDetail.html.twig",
            [
                'product' => $product
            ]
            );
        } else {
            return $this->redirectToRoute("landing_page_view_category");
        }     
    }
}
