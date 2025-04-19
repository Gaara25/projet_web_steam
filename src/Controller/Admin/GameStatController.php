<?php

namespace App\Controller\Admin;

use App\Entity\GameStat;
use App\Form\GameStatType;
use App\Repository\GameStatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @IsGranted("ROLE_ADMIN")
 */
#[Route('/game/stat')]
final class GameStatController extends AbstractController
{
    #[Route(name: 'app_game_stat_index', methods: ['GET'])]
    public function index(GameStatRepository $gameStatRepository): Response
    {
        return $this->render('game_stat/index.html.twig', [
            'game_stats' => $gameStatRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_game_stat_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $gameStat = new GameStat();
        $form = $this->createForm(GameStatType::class, $gameStat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($gameStat);
            $entityManager->flush();

            return $this->redirectToRoute('app_game_stat_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('game_stat/new.html.twig', [
            'game_stat' => $gameStat,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_game_stat_show', methods: ['GET'])]
    public function show(GameStat $gameStat): Response
    {
        return $this->render('game_stat/show.html.twig', [
            'game_stat' => $gameStat,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_game_stat_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, GameStat $gameStat, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(GameStatType::class, $gameStat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_game_stat_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('game_stat/edit.html.twig', [
            'game_stat' => $gameStat,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_game_stat_delete', methods: ['POST'])]
    public function delete(Request $request, GameStat $gameStat, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$gameStat->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($gameStat);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_game_stat_index', [], Response::HTTP_SEE_OTHER);
    }
}
