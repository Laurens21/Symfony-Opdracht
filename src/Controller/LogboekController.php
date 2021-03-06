<?php

namespace App\Controller;

use App\Entity\Logboek;
use App\Form\LogboekType;
use App\Repository\LogboekRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * @Route("/logboek")
 */
class LogboekController extends AbstractController
{
    private $security;

     public function __construct(Security $security)
     {
         $this->security = $security;
     }

    /**
     * @Route("/", name="logboek_index", methods={"GET"})
     */
    public function index(LogboekRepository $logboekRepository): Response
    {
        $user = $this->getUser()->getId();
        if ($this->security->isGranted('ROLE_CHAUFFEUR')) {
            return $this->render('logboek/index.html.twig', [
                'logboeks' => $logboekRepository->findBy(['userId' => $user]),
            ]);
        } elseif($this->security->isGranted('ROLE_ADMIN')) {
            return $this->render('logboek/index.html.twig', [
                'logboeks' => $logboekRepository->findAll(),
            ]);
        } elseif($this->security->isGranted('ROLE_USER')) {
            return $this->render('logboek/index.html.twig', [
                'logboeks' => $logboekRepository->findBy(['userId' => $user]),
            ]);
        } else {
            return $this->redirectToRoute('default');
        }
    }

    /**
     * @Route("/new", name="logboek_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {

        if ($this->security->isGranted('ROLE_ADMIN') || $this->security->isGranted('ROLE_CHAUFFEUR')) {

        $logboek = new Logboek();
        $form = $this->createForm(LogboekType::class, $logboek);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($logboek);
            $entityManager->flush();

            return $this->redirectToRoute('logboek_index');
        }

        return $this->render('logboek/new.html.twig', [
            'logboek' => $logboek,
            'form' => $form->createView(),
        ]);
        } else {
            return $this->redirectToRoute('logboek_index');
        }
    }

    /**
     * @Route("/{id}", name="logboek_show", methods={"GET"})
     */
    public function show(Logboek $logboek): Response
    {
        if ($this->security->isGranted('ROLE_ADMIN') || $this->security->isGranted('ROLE_CHAUFFEUR')) {

        return $this->render('logboek/show.html.twig', [
            'logboek' => $logboek,
        ]);
        } else {
            return $this->redirectToRoute('default');
        }
    }

    /**
     * @Route("/{id}/edit", name="logboek_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Logboek $logboek): Response
    {

        if ($this->security->isGranted('ROLE_ADMIN')) {

        $form = $this->createForm(LogboekType::class, $logboek);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('logboek_index', [
                'id' => $logboek->getId(),
            ]);
        }

        return $this->render('logboek/edit.html.twig', [
            'logboek' => $logboek,
            'form' => $form->createView(),
        ]);
        } else {
            return $this->redirectToRoute('default');
        }
    }

    /**
     * @Route("/{id}", name="logboek_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Logboek $logboek): Response
    {
        if (!$this->security->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('logboek_index');
        }

        if ($this->isCsrfTokenValid('delete'.$logboek->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($logboek);
            $entityManager->flush();
        }

        return $this->redirectToRoute('logboek_index');
    }
}
