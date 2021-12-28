<?php

namespace App\Controller;
use App\Entity\Order;
use App\Entity\OrderDetail;
use App\Entity\Category;
use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use DateTime;
use Symfony\Component\Security\Core\Security;
use Exception;
use App\Doctrine\Persistence\ObjectManager;
use App\Form\OrderCustomerType;
use App\Form\OrderType;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class LandingPageController extends AbstractController
{
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }
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
    public function viewProduct ($id, Request $request) {

        $product = $this->getDoctrine()->getRepository(Product::class)->find($id);
        $order = new Order;
       
        $form = $this->createForm(OrderCustomerType::class,
        // [
        //    'OrderDateVariable' => $createDate,
        //     'UserNameVariable' => $user,
        //     'ProductPrice' => $productPrice,
        //     'TotalAmount'=> $total,
        //     'ProductVariable' =>$productID
        //  ]
    );
        
    if ($product != null) {
            return $this->render("customer/productDetail.html.twig",
            [
                'product' => $product,
                'form' =>$form->createView()
            ]
            );
        } else {
            return $this->redirectToRoute("landing_page_view_category");
        }    
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $order->setOrderDate(new \DateTime());

            $order->setUser($this->security->getUser()->getId());

            
            $order->getOrderDetail()->addProduct($product[$id]);
            $order->getOrderDetail()->setDetailTotal($product->getProductPrice()*$form->getData('DetailQuantity'));
            
            $manager->persist($order);
            $manager->flush();
            return $this->redirectToRoute("view_all_order");
        }
    }

    
}

