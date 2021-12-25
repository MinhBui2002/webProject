<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\OrderDetail;

class OrderDetailController extends AbstractController
{
    /**
     * @Route("/orderdetail/viewall/" , name = "view_all_orderDetail")
     */
    public function viewAllOrderDetail () {
        $orderDetails = $this->getDoctrine()->getRepository(OrderDetail::class)->findAll();
        return $this->render("orderdetail/index.html.twig",
            [
                'orderDetails' => $orderDetails
            ]
        );
    }

    /**
     * @Route("/orderdetail/view/{id}", name = "view_orderDetail")
     */
    public function viewOrderDetail ($id) {
        $orderDetail = $this->getDoctrine()->getRepository(OrderDetail::class)->find($id);
        if ($orderDetail != null) {
            return $this->render("orderdetail/detail.html.twig",
            [
                'orderDetail' => $orderDetail
            ]
            );
        } else {
            return $this->redirectToRoute("view_all_orderDetail");
        }     
    }

    /**
     * @Route("/orderdetail/delete/{id}", name = "delete_orderDetail_by_id")
     */
    public function deleteOrderDetail ($id) {
        $orderDetail = $this->getDoctrine()->getRepository(OrderDetail::class)->find($id);
        if ($orderDetail != null) {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($orderDetail);
            $manager->flush();
        }
        return $this->redirectToRoute("view_all_orderDetail");
    }

    /**
     * @Route("/orderdetail/add", name = "add_orderDetail")
     */
    public function addOrderDetail (Request $request) {
        $orderDetail = new orderDetail;
        $orderDetailForm = $this->createForm(orderDetailType::class, $orderDetail);
        $orderDetailForm->handleRequest($request);
        if ($orderDetailForm->isSubmitted() && $orderDetailForm->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($orderDetail);
            $manager->flush();
            return $this->redirectToRoute("view_all_orderDetail");
        }
        return $this->renderForm("orderdetail/add.html.twig",
        [
            'orderDetailForm' => $orderDetailForm
        ]);
    }

    /**
     * @Route("/orderdetail/edit/{id}", name = "edit_orderDetail")
     */
    public function editOrderDetail (Request $request, $id) {
        $orderDetail = $this->getDoctrine()->getRepository(OrderDetail::class)->find($id);
        $orderDetailForm = $this->createForm(orderDetailType::class, $orderDetail);
        $orderDetailForm->handleRequest($request);
        if ($orderDetailForm->isSubmitted() && $orderDetailForm->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($orderDetail);
            $manager->flush();
            return $this->redirectToRoute("view_all_orderDetail");
        }
        return $this->renderForm("orderdetail/edit.html.twig",
        [
            'orderDetailForm' => $orderDetailForm
        ]);
    }
}
