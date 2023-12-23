<?php

namespace App\Controller\Admin;

use App\Entity\Convertis;
use App\Entity\Message;
use App\Entity\SearchConvertis;
use App\Form\ConvertisType;
use App\Form\EditConvertisType;
use App\Form\MessageType;
use App\Form\SearchType;
use App\Repository\ConvertisRepository;
use App\Repository\CplusRepository;
use App\Service\TwilioService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twilio;

#[Route('/admin/convertis')]
class AdminConvertisController extends AbstractController
{
    #[Route('/', name: 'admin_convertis_index', methods: ['GET', 'POST'])]
    public function index(ConvertisRepository $convertisRepository, Request $request, CplusRepository $cplusRepository, TwilioService $twiolio): Response
    {
        $cplus = $cplusRepository->findOneBy(['statut' => 'init']);

        $search = new SearchConvertis();
        $search->page = $request->get('page', 1);

        $form = $this->createForm(SearchType::class, $search);
        $form->handleRequest($request);

        $convertis = $convertisRepository->findSearch($search);
        $messageTosend = "Salut c’est C +, tu t’es inscrit pour le pré-lancement de l’appli. Va sur le canal  Telegram pour plus d’infos. On arrive dans le jeu.";

        $cancontact = false;
        $liste = "";
        $listeTitre = "Convertis/inscrits";

        if (isset($_GET['listeAttente'])) {
            $cancontact = true;
            $getliste = $_GET['listeAttente'];

            if ($getliste == 0) {
                $messageTosend = '';
            }

            $liste = $_GET['listeAttente'] == 1 ? "à la liste d'attente" : 'aux convertis/inscrits';
            $listeTitre = $_GET['listeAttente'] == 1 ? "Liste d'attente" : 'Convertis/inscrits';
        }

        $message = new Message();
        $message->setContenu($messageTosend);
        $formMessage = $this->createForm(MessageType::class, $message);
        $formMessage->handleRequest($request);

        if ($formMessage->isSubmitted() && $formMessage->isValid()) {
            $numerotest = '+242 06 965 2292';
            foreach ($convertis as $converti) {
                $twiolio->sendSms(
                    //$converti->getNumero(),
                    $numerotest,
                    $formMessage->get('contenu')->getData()
                );
            } 

            /*$alvin = "+212 65 358 7427";
            $alphady = '+242 06 965 2292';*/

            $this->addFlash('success', 'Message envoyé');

            return $this->redirectToRoute('admin_convertis_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/admin_convertis/index.html.twig', [
            'convertis' => $convertis,
            'form' => $form->createView(),
            'formMessage' => $formMessage->createView(),
            'cplus' => $cplus,
            'cancontact' => $cancontact,
            'liste' => $liste,
            'listeTitre' => $listeTitre,
            'query' => $request->get('instagram'),
        ]);
    }

    #[Route('/new', name: 'admin_convertis_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $converti = new Convertis();
        $form = $this->createForm(ConvertisType::class, $converti);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($converti);
            $entityManager->flush();

            return $this->redirectToRoute('admin_convertis_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/admin_convertis/new.html.twig', [
            'converti' => $converti,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_convertis_show', methods: ['GET'])]
    public function show(Convertis $converti): Response
    {
        return $this->render('admin/admin_convertis/show.html.twig', [
            'converti' => $converti,
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_convertis_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Convertis $converti, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EditConvertisType::class, $converti);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Le contenu a bien été modifié');
            return $this->redirectToRoute('admin_convertis_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/admin_convertis/edit.html.twig', [
            'converti' => $converti,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_convertis_delete', methods: ['POST'])]
    public function delete(Request $request, Convertis $converti, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$converti->getId(), $request->request->get('_token'))) {
            $entityManager->remove($converti);
            $entityManager->flush();

            $this->addFlash('success', 'Le contenu a bien été supprimé');
        }

        return $this->redirectToRoute('admin_convertis_index', [], Response::HTTP_SEE_OTHER);
    }
}
