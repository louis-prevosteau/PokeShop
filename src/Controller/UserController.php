<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RoleType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'update_role')]
    public function updateRole(Request $request, EntityManagerInterface $em, UserRepository $repo): Response
    {
        $user = new User;
        $form = $this->createForm(RoleType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $repo->find($form->get("user")->getData());
            $user->setRoles($form->get("roles")->getData());
            $em->persist($user);
            $em->flush();
        }
        return $this->render('user/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
