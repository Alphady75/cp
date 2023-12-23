<?php

namespace App\Controller\Admin;

use App\Entity\Convertis;
use App\Entity\Cplus;
use App\Repository\CplusRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/sold-out')]
class AdminSoldOutController extends AbstractController
{
    #[Route('/{id}', name: 'admin_sold_out', methods: ['POST'])]
    public function desable(Request $request, Cplus $cplus, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('soldout'.$cplus->getId(), $request->request->get('_token'))) {
            
            $mode = "Mode Sold out";

            if ($cplus->getSoldOut() == 0) {

                $cplus->setSoldOut(1);
                $entityManager->flush();
                $mode .= " activé";

            }elseif($cplus->getSoldOut() == 1) {

                $cplus->setSoldOut(0);
                $entityManager->flush();
                $mode .= " désactivé";
            }
            
            $this->addFlash('success', $mode);
        }

        return $this->redirectToRoute('admin_dashboard', [], Response::HTTP_SEE_OTHER);
    }
}
