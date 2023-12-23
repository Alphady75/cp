<?php

namespace App\Controller\Admin;

use App\Form\MessageType;
use App\Form\SendMessageType;
use App\Repository\ConvertisRepository;
use App\Service\TwilioService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twilio;

#[Route('/admin/messages')]
class AdminMessagesController extends AbstractController
{
    #[Route('/', name: 'admin_messages')]
    public function index(Request $request, EntityManagerInterface $entityManager, TwilioService $twiolio, ConvertisRepository $convertisRepository): Response
    {
        $form = $this->createForm(SendMessageType::class, []);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $convertis = $convertisRepository->findAll();

            // Envoie du message à la liste d'attente
            if ($form->get('listeAttente')->getData() == 0) {
                $convertis = $convertisRepository->findBy(['listeAttente' => 0]);
            }elseif ($form->get('listeAttente')->getData() == 1) {
                $convertis = $convertisRepository->findBy(['listeAttente' => 1]);
            }

            foreach ($convertis as $converti) {
                $twiolio->sendSms(
                    $converti->getNumero(), 
                    $form->get('contenu')->getData()
                );
            } 

            /*$alvin = "+212 65 358 7427";
            $alphady = '+242 06 965 2292';*/

            $this->addFlash('success', 'Message envoyé');

            return $this->redirectToRoute('admin_messages', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/messages/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
