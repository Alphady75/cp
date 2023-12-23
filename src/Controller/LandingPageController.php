<?php

namespace App\Controller;

use App\Entity\Convertis;
use App\Entity\Cplus;
use App\Entity\Message;
use App\Entity\NouvelleVisite;
use App\Entity\Recurrence;
use App\Entity\Visite;
use App\Entity\VisiteRec;
use App\Form\ConvertisType;
use App\Form\RegisterType;
use App\Repository\ConvertisRepository;
use App\Repository\CplusRepository;
use App\Repository\NouvelleVisiteRepository;
use App\Repository\RecurrenceRepository;
use App\Repository\VideoRepository;
use App\Repository\VisiteRecRepository;
use App\Repository\VisiteRepository;
use App\Service\MailerService;
//use App\Service\MessageBirdService;
use App\Service\TwilioService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\JsonResponse;

class LandingPageController extends AbstractController
{
    #[Route('/', name: 'landing_page', methods: ['GET', 'POST'])]
    public function index(
        Request $request,
        VisiteRecRepository $visiteRecRepository,
        EntityManagerInterface $entityManager,
        RecurrenceRepository $recurrenceRepository,
        ConvertisRepository $convertisRepository,
        CplusRepository $cplusRepository,
        VideoRepository $videoRepository,
        TwilioService $twiolio,
        NouvelleVisiteRepository $nouvelleVisiteRepository,
        MailerService $mailer
    ): Response {
        $cplus = $cplusRepository->findOneBy(['statut' => 'init']);

        if (!$cplus) {
            $newCplus = new Cplus();
            $newCplus->setSoldOut(0);
            $newCplus->setStatut('init');
            $entityManager->persist($newCplus);
            $entityManager->flush();
            $cplus = $newCplus;
        }

        // Recupération de l'addresse ip de l'utilisateur
        $clientIp = $request->getClientIp();
        $nombreVisite = 0;

        // Recherche de la nouvelle visite
        $nouvelleVisite = $nouvelleVisiteRepository->findOneBy(['adresseIPRec' => $clientIp]);

        // Recherche de la viste recurente
        $visiteurRecurrent = $visiteRecRepository->findOneBy(['adresseIPRec' => $clientIp]);

        /* Un visiteur est considéré comme nouveau visiteur si son adresse IP n’est pas dans la table
            NouvelleVisite ni VisiteRec. C’est-à-dire que le visiteur n’est jamais venu sur la landing page.
            On l’inscrit alors dans la table NouvelleVisite. On ajoute également son adresse IP dans la
            table Recurrence et on instancie le nombre de visite récurrentes à 1. 
        */
        if (empty($nouvelleVisite) && empty($visiteurRecurrent)) {

            dd("son adresse IP n’est pas dans la table NouvelleVisite ni VisiteRec");

            /** On l’inscrit alors dans la table NouvelleVisite */
            $nouvelleVisite = new NouvelleVisite();
            $nouvelleVisite->setIp($clientIp);
            $entityManager->persist($nouvelleVisite);
            $entityManager->flush();

            /** On inscrit son IP également dans la table recurrence */
            $recurrent = new Recurrence();
            $recurrent->setIp($clientIp);
            $recurrent->setNombreVisite(1);
            $entityManager->persist($recurrent);
            $entityManager->flush();

        } elseif (!empty($nouvelleVisite) && empty($visiteurRecurrent)) {

            dd("l’adresse IP du visiteur est contenu dans la table NouvelleVisite mais pas dans la table VisiteRec,");
            /* 
            Si l’adresse IP du visiteur est contenu dans la table NouvelleVisite mais pas dans la table
            VisiteRec, alors on l’inscrit dans la table VisiteRec et on incrémente le nombre de visite
            relatives à son adresse IP de 1 dans la table Recurrence.
            */

            // on l’inscrit dans la table VisiteRec
            $visiteRec = new VisiteRec();
            $visiteRec->setIp($clientIp);
            $visiteRecRepository->persist($visiteRec);
            $entityManager->flush();

            // on incrémente le nombre de visite relatives à son adresse IP de 1 dans la table Recurrence
            $recurence = $recurrenceRepository->findOneBy(['adresseIP' => $clientIp]);
            $recurence->setNombreVisite($recurence->getNombreVisite() + 1);
            $entityManager->flush();

        } elseif (!empty($visiteurRecurrent)) {

            #dd("l’adresse IP du visiteur est contenu dans la table VisiteRec");

            /* 
            Si l’adresse IP du visiteur est contenu dans la table VisiteRec, alors on ajoute simplement une
            nouvelle fois la visite dans la table VisiteRec.
            On incrémente le nombre de visite relatives à son adresse IP de 1 dans la table Recurrence.
            */
            $visiterec = new VisiteRec();
            $visiterec->setIp($clientIp);
            $entityManager->persist($visiterec);

            // on incrémente le nombre de visite relatives à son adresse IP de 1 dans la table Recurrence
            $recurence = $recurrenceRepository->findOneBy(['adresseIP' => $clientIp]);
            $recurence->setNombreVisite($recurence->getNombreVisite() + 1);
            $entityManager->flush();
        }

        $converti = new Convertis();
        $form = $this->createForm(RegisterType::class, $converti);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $instagram = $form->get('instagram')->getData();
            $sujet = "Nouvelle inscription";

            $listeAttente = 0;
            $message = "Salut @$instagram c’est C +, tu t’es inscrit pour le pré-lancement de l’appli. Va sur le canal  Telegram pour plus d’infos. On arrive dans le jeu.";

            if ($cplus->getSoldOut() == 1) {
                $listeAttente = 1;
                $message = "Salut @$instagram c’est C +, tu t’es inscrit sur la liste d'attente de l’appli. Va sur le canal  Telegram pour plus d’infos. On arrive dans le jeu.";
                $sujet = "Inscription à la liste d'attente";
            }

            $indicatif = $form->get('indicatif')->getData();
            $telephone = $form->get('numero')->getData();

            $converti->setIp($clientIp);
            $converti->setCountRec(0);
            $converti->setListeAttente($listeAttente);
            $converti->setNumero($indicatif . $telephone);
            $entityManager->persist($converti);
            $entityManager->flush();
            $this->addFlash('success', "Inscription réussi");

            // Envoie du message
            $testnumber = '+242 06 965 2292';

            /*$twiolio->sendSms(
                $testnumber,
               // $indicatif . $telephone,
                $message
            );*/

            //dd($messageBird->sendSms(['+31612345678'], $message));

            $clientHttp = HttpClient::create();
            $headers = [
                'Content-Type' => 'application/json'
            ];

            $body = array(
                "from" => "C +",
                "text" => $message,
                "to" => $indicatif . $telephone,
                "api_key" => "f181e209",
                "api_secret" => "gDg9AWrkC8hjwpcn"
            );

            $body = json_encode(($body));

            try {
                $response = $clientHttp->request('POST', 'https://rest.nexmo.com/sms/json', [
                    'headers' => $headers,
                    'body' => $body
                ]);

                $content = $response->toArray();
            } catch (\Exception $e) {
                return new JsonResponse(['content' => $e->getMessage(), 'error' => $e->getMessage()], 500);
            }

            # Envoie du mail
            $mailer->sendMail($sujet, $message);


            return $this->redirectToRoute('register_success', [], Response::HTTP_SEE_OTHER);
        } elseif ($form->isSubmitted() && !$form->isValid()) {
            $this->addFlash('danger', "Votre inscription n'a pas abouti, veuillez corriger les erreurs ci-dessous et ressayer de nouveau.");
        }

        return $this->render('landing_page/index.html.twig', [
            'ip' => $clientIp,
            'visites' => $nombreVisite,
            'videos' => $videoRepository->findBy([], ['created' => 'DESC']),
            'form' => $form->createView(),
            'cplus' => $cplus,
            'converti' => $convertisRepository->findBy(['ip' => $clientIp]),
            'convertis' => $convertisRepository->findBy(
                ['listeAttente' => 0],
                ['created' => 'DESC'],
                20
            ),
        ]);
    }

    #[Route('/confirme', name: 'register_success')]
    public function success()
    {
        return $this->render('landing_page/success.html.twig', []);
    }
}
