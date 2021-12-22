<?php

namespace App\Controller;

use App\Entity\Donation;
use App\Form\DonationType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DonationController extends AbstractController
{

    public function __construct(ManagerRegistry $doctrine) {
        $this->doctrine = $doctrine;
    }

    #[Route('/donation', name: 'donation', methods: 'GET')]
    public function index(): Response
    {
        $donations = $this->doctrine->getRepository(Donation::class)->findAll();
        return $this->render('donation/index.html.twig', [
            'donations' => $donations,
        ]);
    }

    #[Route('/donation/create', name: 'create_donation', methods: ['POST', 'GET'])]
    public function create(Request $request, ManagerRegistry $mr)
    {
        $donation = new Donation;
        $form = $this->createForm(DonationType::class, $donation);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $donation->setDateOfDonation(new \DateTime());
            $em = $mr->getManager();
            $em->persist($donation);
            $em->flush();
            $this->addFlash('success', 'Don enregisqtré');
            return $this->redirectToRoute('donation');
        }
        return $this->render('donation/create.html.twig', array('form' => $form->createView()));
    }
}
