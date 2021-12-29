<?php

namespace App\Controller;

use App\Entity\Order;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Security;

class CartController extends AbstractController
{

    public function __construct(SessionInterface $session, Security $security)
    {
        $this->security = $security;
        $this->session = $session;
    }
    /**
     * @Route("/cart/viewAllOrder", name="view_cart")
     */
    public function index(): Response
    {
        $orders = $this->security->getUser()->getOrders();
        return $this->render('cart/index.html.twig', [
            'orders' => $orders,
        ]);
    }

    /**
     * @Route("/cart/delete/{id}", name = "cart_delete_order_by_id")
     */
    public function deleteOrder ($id) {
        $order = $this->getDoctrine()->getRepository(Order::class)->find($id);
        if ($order != null) {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($order);
            $manager->flush();
        }
        return $this->redirectToRoute("view_cart");
    }

}
