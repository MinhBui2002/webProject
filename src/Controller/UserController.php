<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Form\UserType;

class UserController extends AbstractController
{
    /**
     * @Route("/user/viewAllUser/" , name = "view_all_user")
     */
    public function viewAllUser()
    {
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();
        return $this->render(
            "user/index.html.twig",
            [
                'users' => $users
            ]
        );
    }

    /**
     * @Route("/user/view/{id}", name = "view_user")
     */
    public function viewUser($id)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        if ($user != null) {
            return $this->render(
                "user/detail.html.twig",
                [
                    'user' => $user
                ]
            );
        } else {
            return $this->redirectToRoute("view_all_user");
        }
    }

    /**
     * @Route("/user/delete/{id}", name = "delete_user_by_id")
     */
    public function deleteUser($id)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        if ($user != null) {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($user);
            $manager->flush();
        }
        return $this->redirectToRoute("view_all_user");
    }

    /**
     * @Route("/user/add", name = "add_user")
     */
    public function addUser(Request $request, UserPasswordHasherInterface $userPasswordHasher)
    {
        $user = new user;
        $userForm = $this->createForm(userType::class, $user);
        $userForm->handleRequest($request);
        if ($userForm->isSubmitted() && $userForm->isValid()) {
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $userForm->get('plainPassword')->getData()
                )
            );
            $user->setRoles(['ROLE_CUSTOMER']);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();
            return $this->redirectToRoute("view_all_user");
        }
        return $this->renderForm(
            "user/add.html.twig",
            [
                'userForm' => $userForm
            ]
        );
    }

    /**
     * @Route("/user/edit/{id}", name = "edit_user")
     */
    public function editUser(Request $request, $id, UserPasswordHasherInterface $userPasswordHasher)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        $userForm = $this->createForm(userType::class, $user);
        $userForm->handleRequest($request);
        if ($userForm->isSubmitted() && $userForm->isValid()) {
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $userForm->get('plainPassword')->getData()
                )
            );
            $user->setRoles(['ROLE_CUSTOMER']);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();
            return $this->redirectToRoute("view_all_user");
        }
        return $this->renderForm(
            "user/edit.html.twig",
            [
                'userForm' => $userForm
            ]
        );
    }
}