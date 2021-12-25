<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\UserDetail;
use App\Form\UserDetailType;

class UserDetailController extends AbstractController
{
    /**
     * @Route("/userdetail/viewall", name="view_all_userDetail")
     */
    public function viewAllUserDetail()
    {
        $userDetails = $this->getDoctrine()->getRepository(UserDetail::class)->findAll();
        return $this->render(
            "userdetail/index.html.twig",
            [
                'userDetails' => $userDetails
            ]
        );
    }

    /**
     * @Route("/userdetail/view/{id}", name = "view_userDetail")
     */
    public function viewUserDetail($id)
    {
        $userDetail = $this->getDoctrine()->getRepository(UserDetail::class)->find($id);
        if ($userDetail != null) {
            return $this->render(
                "userdetail/detail.html.twig",
                [
                    'userDetail' => $userDetail
                ]
            );
        } else {
            return $this->redirectToRoute("view_all_userDetail");
        }
    }

    /**
     * @Route("/userdetail/delete/{id}", name = "delete_userDetail_by_id")
     */
    public function deleteUserDetail($id)
    {
        $userDetail = $this->getDoctrine()->getRepository(UserDetail::class)->find($id);
        if ($userDetail != null) {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($userDetail);
            $manager->flush();
        }
        return $this->redirectToRoute("view_all_userDetail");
    }

    /**
     * @Route("/userdetail/add", name = "add_userDetail")
     */
    public function addOrderDetail(Request $request)
    {
        $userDetail = new userDetail;
        $userDetailForm = $this->createForm(userDetailType::class, $userDetail);
        $userDetailForm->handleRequest($request);
        if ($userDetailForm->isSubmitted() && $userDetailForm->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($userDetail);
            $manager->flush();
            return $this->redirectToRoute("view_all_userDetail");
        }
        return $this->renderForm(
            "userdetail/add.html.twig",
            [
                'userDetailForm' => $userDetailForm
            ]
        );
    }
    /**
     * @Route("/userdetail/edit/{id}", name = "edit_userDetail")
     */
    public function editUserDetail(Request $request, $id)
    {
        $userDetail = $this->getDoctrine()->getRepository(UserDetail::class)->find($id);
        $userDetailForm = $this->createForm(orderDetailType::class, $userDetail);
        $userDetailForm->handleRequest($request);
        if ($userDetailForm->isSubmitted() && $userDetailForm->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($userDetail);
            $manager->flush();
            return $this->redirectToRoute("view_all_userDetail");
        }
        return $this->renderForm(
            "userdetail/edit.html.twig",
            [
                'userDetailForm' => $userDetailForm
            ]
        );
    }
}
