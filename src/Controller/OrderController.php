<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Order;
use App\Form\OrderType;

class OrderController extends AbstractController
{
    
    /**
     * @Route("/order/viewAllOrder/" , name = "view_all_order")
     */
    public function viewAllOrders () {
        $orders = $this->getDoctrine()->getRepository(Order::class)->findAll();
        return $this->render("order/index.html.twig",
            [
                'orders' => $orders
            ]
        );
    }

    /**
     * @Route("/order/view/{id}", name = "view_order")
     */
    public function viewOrder ($id) {
        $order = $this->getDoctrine()->getRepository(Order::class)->find($id);
        if ($order != null) {
            return $this->render("order/detail.html.twig",
            [
                'order' => $order
            ]
            );
        } else {
            return $this->redirectToRoute("view_all_order");
        }     
    }

    /**
     * @Route("/order/delete/{id}", name = "delete_order_by_id")
     */
    public function deleteOrder ($id) {
        $order = $this->getDoctrine()->getRepository(Order::class)->find($id);
        if ($order != null) {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($order);
            $manager->flush();
        }
        return $this->redirectToRoute("view_all_order");
    }

    /**
     * @Route("/order/add", name = "add_order")
     */
    public function addOrder (Request $request) {
        $order = new order;
        $orderForm = $this->createForm(OrderType::class, $order);
        $orderForm->handleRequest($request);
        if ($orderForm->isSubmitted() && $orderForm->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($order);
            $manager->flush();
            return $this->redirectToRoute("view_all_order");
        }
        return $this->renderForm("order/add.html.twig",
        [
            'orderForm' => $orderForm
        ]);
    }

    /**
     * @Route("/order/edit/{id}", name = "edit_order")
     */
    public function editOrder (Request $request, $id) {
        $order = $this->getDoctrine()->getRepository(Order::class)->find($id);
        $orderForm = $this->createForm(OrderType::class, $order);
        $orderForm->handleRequest($request);
        if ($orderForm->isSubmitted() && $orderForm->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($order);
            $manager->flush();
            return $this->redirectToRoute("view_all_order");
        }
        return $this->renderForm("order/edit.html.twig",
        [
            'orderForm' => $orderForm
        ]);
    }
}
