<?php

namespace App\Controller;

use App\Entity\Elemento;
use App\Form\Elemento1Type;
use App\Repository\ElementoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/elemento')]
final class ElementoController extends AbstractController
{
    #[Route(name: 'app_elemento_index', methods: ['GET'])]
    public function index(ElementoRepository $elementoRepository): Response
    {
        $elementos = $elementoRepository->findAll();
        return $this->render('elemento/index.html.twig', [
            'elementos' => $elementos
        ]);
    }

    #[Route('/new', name: 'app_elemento_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $elemento = new Elemento();
        $form = $this->createForm(Elemento1Type::class, $elemento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $elemento->setActivo(true);
            $entityManager->persist($elemento);
            $entityManager->flush();

            return $this->redirectToRoute('app_elemento_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('elemento/new.html.twig', [
            'elemento' => $elemento,
            'form' => $form,
        ]);
    }

    #[Route('/update_bd', name: 'app_elemento_update_bd', methods: ['GET'])]
    public function actualizarCssEnBaseDeDatos(EntityManagerInterface $entityManager, ElementoRepository $elementoRepository): Response
    {
        // Obtener todos los elementos
        $elementos = $elementoRepository->findAll();

        foreach ($elementos as $elemento) {
            // Obtener el CSS actual de cada elemento
            $css = $elemento->getCss();

            // Modificar el CSS reemplazando los width no porcentuales por width: 100%
            $modifiedCss = preg_replace('/\bwidth:\s*(?!\d+%)[^;]+;?/i', 'width: 100%;', $css);

            // Asignar el CSS modificado al objeto Elemento
            $elemento->setCss($modifiedCss);
        }

        // Guardar todos los cambios en la base de datos
        $entityManager->flush();
        return $this->redirectToRoute('app_elemento_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/buscar/{nombre}', name: 'app_elemento_buscar', methods: ['GET'])]
    public function buscar($nombre, ElementoRepository $elementoRepository): Response
    {
        $elementos = $elementoRepository->buscarPorNombre($nombre);
        if (empty($elementos)) {
            return $this->render('elemento/index.html.twig',[
                'elementos' => $elementos
            ], new Response('No hay elementos con ese nombre', Response::HTTP_NOT_FOUND));
        }
        return $this->render('elemento/index.html.twig',[
            'elementos' => $elementos
        ]);
    }

    #[Route('/{id}', name: 'app_elemento_show', methods: ['GET'])]
    public function show(Elemento $elemento): Response
    {
        return $this->render('elemento/show.html.twig', [
            'elemento' => $elemento,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_elemento_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Elemento $elemento, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Elemento1Type::class, $elemento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_elemento_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('elemento/edit.html.twig', [
            'elemento' => $elemento,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_elemento_delete', methods: ['POST'])]
    public function delete(Request $request, Elemento $elemento, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $elemento->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($elemento);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_elemento_index', [], Response::HTTP_SEE_OTHER);
    }
}
