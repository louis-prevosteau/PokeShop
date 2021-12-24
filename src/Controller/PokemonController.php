<?php

namespace App\Controller;

use App\Entity\Pokemon;
use App\Form\PokemonType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class PokemonController extends AbstractController
{

    public function __construct(ManagerRegistry $doctrine) {
        $this->doctrine = $doctrine;
    }

    #[Route('/pokemon', name: 'pokemon', methods: 'GET'), IsGranted('ROLE_USER')]
    public function index(): Response
    {
        $pokemons = $this->doctrine->getRepository(Pokemon::class)->findAll();
        return $this->render('pokemon/index.html.twig', [
            'pokemons' => $pokemons,
        ]);
    }

    #[Route('/pokemon/create', name: 'pokemon_create', methods: ['POST','GET']), IsGranted('ROLE_ADMIN')]
    public function create(Request $request, ManagerRegistry $mr): Response
    {
        $pokemon = new Pokemon;
        $form = $this->createForm(PokemonType::class, $pokemon);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $mr->getManager();
            $em->persist($pokemon);
            $em->flush();
            $this->addFlash('success', 'Pokemon enregistré');
            return $this->redirectToRoute('pokemon');
        }
        return $this->render('pokemon/create.html.twig', array('form' => $form->createView()));
    }

    #[Route('/pokemon/{id}', name: 'pokemon_show', methods: 'GET'), IsGranted('ROLE_USER')]
    public function show(Pokemon $pokemon): Response
    {
        return $this->render('pokemon/show.html.twig', [
            'pokemon' => $pokemon
        ]);
    }

    #[Route('/pokemon/update/{id}', name: 'pokemon_update', methods: ['POST','GET'])]
    public function update(Request $request, Pokemon $pokemon): Response
    {
        $this->denyAccessUnlessGranted("ROLE_SUPER_ADMIN");
        $form = $this->createFormBuilder($pokemon)
            ->add('Name', TextType::class)
            ->add('Image', FileType::class)
            ->add('Description', TextareaType::class)
            ->add('Price', MoneyType::class)
            ->add('Modifier', SubmitType::class)
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->doctrine->getManager();
            $em->persist($pokemon);
            $em->flush();
            $this->addFlash('success', 'Pokemon enregistré');
            return $this->redirectToRoute('pokemon');
        }
        return $this->render("pokemon/update.html.twig", [
            'form' => $form->createView()
        ]);
    }

    #[Route("/pokemon/delete/{id}", name: "pokemon_delete")]
    public function delete(Pokemon $pokemon): Response
    {
        if ($this->isGranted("ROLE_SUPER_ADMIN")) {
            $em = $this->doctrine->getManager();
            $em->remove($pokemon);
            $em->flush();
        }
        return $this->redirectToRoute("pokemon");
    }
    
}
