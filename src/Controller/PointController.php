<?php

namespace App\Controller;

use App\Entity\Point;
use App\Entity\Personne;
use App\Form\Point1Type;
use App\Repository\PointRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/point')]
class PointController extends AbstractController
{
    #[Route('/', name: 'app_point_index', methods: ['GET'])]
    public function index(PointRepository $pointRepository): Response
    {
        return $this->render('point/index.html.twig', [
            'points' => $pointRepository->findAll(),
        ]);
    }

    #[Route('/new/{id?}', name: 'app_point_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PointRepository $pointRepository): Response
    {
        $point = new Point();
        $id=($request->get('id'));
        $personne=$this->getDoctrine()->getRepository(Personne::class)->find($id);
        
        $form = $this->createForm(Point1Type::class, $point);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pointRepository->save($point, true);

            return $this->redirectToRoute('app_personne_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('point/new.html.twig', [
            'point' => $point,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_point_show', methods: ['GET'])]
    public function show(Point $point): Response
    {
        return $this->render('point/show.html.twig', [
            'point' => $point,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_point_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Point $point, PointRepository $pointRepository): Response
    {
        $form = $this->createForm(Point1Type::class, $point);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pointRepository->save($point, true);

            return $this->redirectToRoute('app_point_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('point/edit.html.twig', [
            'point' => $point,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_point_delete', methods: ['POST'])]
    public function delete(Request $request, Point $point, PointRepository $pointRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$point->getId(), $request->request->get('_token'))) {
            $pointRepository->remove($point, true);
        }

        return $this->redirectToRoute('app_point_index', [], Response::HTTP_SEE_OTHER);
    }
}
