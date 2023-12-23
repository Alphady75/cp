<?php

namespace App\Controller\Admin;

use App\Entity\Video;
use App\Form\VideoType;
use App\Repository\VideoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/videos')]
class VideosController extends AbstractController
{
    #[Route('/', name: 'admin_videos_index', methods: ['GET', 'POST'])]
    public function index(VideoRepository $videoRepository, PaginatorInterface $paginator, Request $request, EntityManagerInterface $entityManager): Response
    {
        $videos = $paginator->paginate(
            $videoRepository->findBy([], ['created' => 'DESC']),
            $request->query->getInt('page', 1),
            12
        );

        $video = new Video();
        $form = $this->createForm(VideoType::class, $video);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success', 'Le contenu a bien été créé');
            $entityManager->persist($video);
            $entityManager->flush();
            return $this->redirectToRoute('admin_videos_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/videos/index.html.twig', [
            'videos' => $videos,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/new', name: 'admin_videos_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $video = new Video();
        $form = $this->createForm(VideoType::class, $video);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($video);
            $entityManager->flush();

            return $this->redirectToRoute('admin_videos_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/videos/new.html.twig', [
            'video' => $video,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_videos_show', methods: ['GET'])]
    public function show(Video $video): Response
    {
        return $this->render('admin/videos/show.html.twig', [
            'video' => $video,
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_videos_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Video $video, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(VideoType::class, $video);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_videos_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/videos/edit.html.twig', [
            'video' => $video,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_videos_delete', methods: ['POST'])]
    public function delete(Request $request, Video $video, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$video->getId(), $request->request->get('_token'))) {
            $entityManager->remove($video);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_videos_index', [], Response::HTTP_SEE_OTHER);
    }
}
