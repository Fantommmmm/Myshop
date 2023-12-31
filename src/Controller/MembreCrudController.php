<?php

namespace App\Controller;

use App\Entity\Membre;
use App\Form\MembreType;
use App\Repository\MembreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/membre/crud')]
class MembreCrudController extends AbstractController
{
    #[Route('/', name: 'app_membre_crud_index', methods: ['GET'])]
    public function index(MembreRepository $membreRepository): Response
    {
        return $this->render('membre_crud/index.html.twig', [
            'membres' => $membreRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_membre_crud_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MembreRepository $membreRepository): Response
    {
        $membre = new Membre();
        $form = $this->createForm(MembreType::class, $membre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $membreRepository->save($membre, true);

            return $this->redirectToRoute('app_membre_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('membre_crud/new.html.twig', [
            'membre' => $membre,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_membre_crud_show', methods: ['GET'])]
    public function show(Membre $membre): Response
    {
        return $this->render('membre_crud/show.html.twig', [
            'membre' => $membre,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_membre_crud_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Membre $membre, MembreRepository $membreRepository): Response
    {
        $form = $this->createForm(MembreType::class, $membre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $membreRepository->save($membre, true);

            return $this->redirectToRoute('app_membre_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('membre_crud/edit.html.twig', [
            'membre' => $membre,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_membre_crud_delete', methods: ['POST'])]
    public function delete(Request $request, Membre $membre, MembreRepository $membreRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$membre->getId(), $request->request->get('_token'))) {
            $membreRepository->remove($membre, true);
        }

        return $this->redirectToRoute('app_membre_crud_index', [], Response::HTTP_SEE_OTHER);
    }
}
