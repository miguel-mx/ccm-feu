<?php

namespace App\Controller;

use App\Entity\Feu;
use App\Form\FeuType;
use App\Repository\FeuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/feu")
 */
class FeuController extends AbstractController
{
    /**
     * @Route("/", name="app_feu_index", methods={"GET"})
     */
    public function index(FeuRepository $feuRepository): Response
    {
        return $this->render('feu/index.html.twig', [
            'feus' => $feuRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_feu_new", methods={"GET", "POST"})
     */
    public function new(Request $request, FeuRepository $feuRepository): Response
    {
        $feu = new Feu();
        $form = $this->createForm(FeuType::class, $feu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $feuRepository->add($feu, true);

            return $this->redirectToRoute('app_feu_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('feu/new.html.twig', [
            'feu' => $feu,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_feu_show", methods={"GET"})
     */
    public function show(Feu $feu): Response
    {
        return $this->render('feu/show.html.twig', [
            'feu' => $feu,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_feu_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Feu $feu, FeuRepository $feuRepository): Response
    {
        $form = $this->createForm(FeuType::class, $feu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $feuRepository->add($feu, true);

            return $this->redirectToRoute('app_feu_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('feu/edit.html.twig', [
            'feu' => $feu,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_feu_delete", methods={"POST"})
     */
    public function delete(Request $request, Feu $feu, FeuRepository $feuRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$feu->getId(), $request->request->get('_token'))) {
            $feuRepository->remove($feu, true);
        }

        return $this->redirectToRoute('app_feu_index', [], Response::HTTP_SEE_OTHER);
    }
}
