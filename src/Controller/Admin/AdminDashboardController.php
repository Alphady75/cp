<?php

namespace App\Controller\Admin;

use App\Entity\Cplus;
use App\Entity\SearchConvertis;
use App\Entity\SearchVisites;
use App\Form\FilterType;
use App\Form\SearchType;
use App\Form\SearchVisiteType;
use App\Repository\ConvertisRepository;
use App\Repository\CplusRepository;
use App\Repository\NouvelleVisiteRepository;
use App\Repository\VisiteRecRepository;
use App\Repository\VisiteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Gedmo\Mapping\Annotation\Tree;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin')]
class AdminDashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'admin_dashboard', methods: ['GET', 'POST'])]
    public function index(
        NouvelleVisiteRepository $nouvelleVisiteRepository,
        ConvertisRepository $convertisRepository,
        VisiteRecRepository $visiteRecRepository,
        Request $request,
        VisiteRepository $visiteRepository,
        CplusRepository $cplusRepository,
        EntityManagerInterface $entityManager
    ): Response {

        $cplus = $cplusRepository->findOneBy(['statut' => 'init']);

        if (!$cplus) {
            $cplus = new Cplus();
            $cplus->setSoldOut(0);
            $cplus->setStatut('init');
            $entityManager->persist($cplus);
            $entityManager->flush();
        }

        $nouvellevisites = $nouvelleVisiteRepository->findAll();
        $visiterecurentes = $visiteRecRepository->findAll();
        $totalvisites = count($visiterecurentes) + count($nouvellevisites);
        $inscrits = $convertisRepository->findAll();
        $listeattente = $convertisRepository->findBy(['listeAttente' => true]);

        /** Donnéées des graphiques */
        $nouvelleVisites = $nouvelleVisiteRepository->countByDate();
        $visiteRecurentes = $visiteRecRepository->countByDate();
        $visitescollection = $visiteRepository->countByDate();
        $prelancements = $convertisRepository->countByDateListeAttente(false);
        $listeAttente = $convertisRepository->countByDateListeAttente(true);

        $formFilter =  $this->createForm(FilterType::class, []);
        $formFilter->handleRequest($request);

        if ($formFilter->isSubmitted() && $formFilter->isValid()) {

            $minDate = $formFilter->get('minDate')->getData();
            $maxDate = $formFilter->get('maxDate')->getData();

            $nouvellevisites = $nouvelleVisiteRepository->filterByDate($minDate, $maxDate);
            $visiterecurentes = $visiteRecRepository->filterByDate($minDate, $maxDate);
            $totalvisites = count($visiterecurentes) + count($nouvellevisites);
            $inscrits = $convertisRepository->filterByDate($minDate, $maxDate);
            $listeattente = $convertisRepository->filterByDateListeAttente($minDate, $maxDate);

            /** Donnéées des graphiques */
            $nouvelleVisites = $nouvelleVisiteRepository->countFilterByDate($minDate, $maxDate);
            $visiteRecurentes = $visiteRecRepository->countFilterByDate($minDate, $maxDate);
            $visitescollection = $visiteRepository->countByDate();
            $prelancements = $convertisRepository->countByDateListeAttente(false, $minDate, $maxDate);
            $listeAttente = $convertisRepository->countByDateListeAttente(true, $minDate, $maxDate);
        }

        /** Visites Ok */
        $dataVisites = [];
        foreach ($visitescollection as $visite) {
            array_push(
                $dataVisites,
                array(
                    "y" => $visite['count'],
                    'label' => $visite['dateVisite']
                )
            );
        }

        /** Visite recurente Ok */
        $dataNouvelleVisite = [];
        foreach ($nouvelleVisites as $newvisite) {
            array_push($dataNouvelleVisite, array(
                "y" => $newvisite['count'],
                'label' => $newvisite['dateVisite']
            ));
        }

        /** Visite recurente Ok */
        $dataVisiteRecurentes = [];
        foreach ($visiteRecurentes as $visite) {
            array_push($dataVisiteRecurentes, array(
                "y" => $visite['count'],
                'label' => $visite['dateVisite']
            ));
        }

        /** Prélancements Ok */
        $dataprelancements = []; //dd($prelancements);
        foreach ($prelancements as $prelance) {
            array_push($dataprelancements, array(
                "y" => $prelance['count'],
                'label' => $prelance['dateConv']
            ));
        }

        /** listeAttente Ok */
        $dataListeAttente = []; //dd($listeAttente);
        foreach ($listeAttente as $liste) {
            array_push($dataListeAttente, array(
                "y" => $liste['count'],
                'label' => $liste['dateConv']
            ));
        }

        //dd(count($convertis));
        /** Taux de reconversion */
        $taux = 1;
        $dataTaux = [];

        return $this->render('admin/admin_dashboard/index.html.twig', [
            'nouvellevisites' => count($nouvellevisites),
            'visiterecurentes' => count($visiterecurentes),
            'totalvisites' => $totalvisites,
            'totalinscrits' => count($inscrits),
            'listeattente' => count($listeattente),
            'taux' => (count($inscrits) / (count($nouvelleVisites) == 0 ? 1 : count($nouvelleVisites))),

            'query' => $request->get('instagram'),
            'visiteForm' => $formFilter->createView(),
            'cplus' => $cplus,

            'dataVisites' => json_encode($dataVisites, JSON_NUMERIC_CHECK),
            'dataVisitesRecurentes' => json_encode($dataVisiteRecurentes, JSON_NUMERIC_CHECK),
            'dataprelancements' => json_encode($dataprelancements, JSON_NUMERIC_CHECK),
            'dataListeAttente' => json_encode($dataListeAttente, JSON_NUMERIC_CHECK),
            'dataNouvellesVisites' => json_encode($dataNouvelleVisite, JSON_NUMERIC_CHECK),
            'dataTaux' => json_encode($dataTaux, JSON_NUMERIC_CHECK),

        ]);
    }
}
