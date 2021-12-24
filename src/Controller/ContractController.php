<?php

namespace App\Controller;

use App\Entity\Contract;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContractController extends AbstractController
{

    public function __construct(ManagerRegistry $doctrine) {
        $this->doctrine = $doctrine;
    }

    #[Route('/contract', name: 'contract')]
    public function index(): Response
    {
        $contracts = $this->doctrine->getRepository(Contract::class)->findAll();
        return $this->render('contract/index.html.twig', [
            'contracts' => $contracts,
        ]);
    }
}
