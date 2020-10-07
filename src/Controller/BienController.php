<?php

namespace App\Controller;

use App\Entity\Bien;
use App\Entity\User;
use App\Form\BienType;
use App\Repository\BienRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


/**
 * @Route("/bien")
 */
class BienController extends AbstractController
{
    /**
     * @Route("/", name="bien_index", methods={"GET"})
     */
    public function index(BienRepository $bienRepository, PaginatorInterface $paginator, Request $request): Response
    {

        $query = $bienRepository->findPaginateBiens();
        $requestedPage = $request->query->getInt('page', 1);

        $biens = $paginator->paginate(
            $query,
            $requestedPage,
            3
        );
        return $this->render('bien/index.html.twig', [
            'biens' => $biens,
        ]);
    }

    /**
     * @Route("/mes_biens", name="bien_mesbiens", methods={"GET"})
     * @IsGranted("ROLE_USER")
     */
    public function perso(BienRepository $bienRepository, PaginatorInterface $paginator, Request $request): Response
    {

        $query = $bienRepository->findPaginateBiensPerso($this->getUser()->getId());
        $requestedPage = $request->query->getInt('page', 1);

        $biens = $paginator->paginate(
            $query,
            $requestedPage,
            3
        );
        return $this->render('bien/perso.html.twig', [
            'biens' => $biens,
        ]);
    }

    /**
     * @Route("/new", name="bien_new", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     */
    public function new(Request $request): Response
    {
        $bien = new Bien();
        $bien->setProprietaire($this->getUser());
        $form = $this->createForm(BienType::class, $bien);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($bien);
            $entityManager->flush();

            return $this->redirectToRoute('bien_index');
        }

        return $this->render('bien/new.html.twig', [
            'bien' => $bien,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="bien_show", methods={"GET"})
     */
    public function show(Bien $bien): Response
    {


        return $this->render('bien/show.html.twig', [
            'bien' => $bien,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="bien_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     */
    public function edit(Request $request, Bien $bien): Response
    {
        if ($bien->getProprietaire()->getId() === $this->getUser()->getId()) {
            $form = $this->createForm(BienType::class, $bien);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $this->getDoctrine()->getManager()->flush();

                return $this->redirectToRoute('bien_index');
            }

            return $this->render('bien/edit.html.twig', [
                'bien' => $bien,
                'form' => $form->createView(),
            ]);
        } else {
            return $this->redirectToRoute('bien_index');
        }
    }

    /**
     * @Route("/{id}", name="bien_delete", methods={"DELETE"})
     * @IsGranted("ROLE_USER")
     */
    public function delete(Request $request, Bien $bien): Response
    {
        if ($bien->getProprietaire()->getId() === $this->getUser()->getId()) {
            if ($this->isCsrfTokenValid('delete' . $bien->getId(), $request->request->get('_token'))) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($bien);
                $entityManager->flush();
                return $this->redirectToRoute('bien_index');
            }
        } else {
            return $this->redirectToRoute('bien_index');
        }
    }
}
