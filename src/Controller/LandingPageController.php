<?php

namespace App\Controller;


use App\Entity\Order;
use App\Entity\Product;
use App\Form\OrderType;
use App\Entity\Category;
use App\Entity\OrderDetail;
use App\Form\OrderCustomerType;
use App\Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;


class LandingPageController extends AbstractController
{
    public function __construct(SessionInterface $session, Security $security)
    {
        $this->security = $security;
        $this->session = $session;
    }
    /**
     * @Route("/customer/landingPage/", name="landing_page_category")
     */
    public function viewAllCategory()
    {
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();
        return $this->render(
            "customer/index.html.twig",
            [
                'categories' => $categories
            ]
        );
    }

    /**
     * @Route("/customer/viewCategory/{id}", name = "landing_page_view_category")
     */
    public function viewCategory($id)
    {
        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);
        if ($category != null) {
            return $this->render(
                "customer/categoryDetail.html.twig",
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
    public function viewProduct($id, Request $request)
    {
        $order = new order;
        $form = $this->createForm(OrderCustomerType::class, $order);
        $form->handleRequest($request);
        $orderDetail = $order->getOrderDetail();
        $product = $this->getDoctrine()->getRepository(Product::class)->find($id);
        $var = $form["orderDetail"]["DetailQuantity"]->getData();
        if ($form->isSubmitted() && $form->isValid() && $var <= ($product->getProductQuantity())) {
            $order->setUser($this->security->getUser());
            $order->setOrderDate(new \DateTime());
            $orderDetail->setDetailPrice($product->getProductPrice());
            $orderDetail->setDetailTotal($product->getProductPrice() * $var);
            $orderDetail->addProduct($product);
            $product->setProductQuantity($product->getProductQuantity() - $var);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($order, $orderDetail);
            $manager->flush();
            return $this->redirectToRoute("landing_page_view_product", array('id' => $id));
        }
        return $this->render(
            "customer/productDetail.html.twig",
            [
                'product' => $product,
                'form' => $form->createView()
            ]
        );
    }
}