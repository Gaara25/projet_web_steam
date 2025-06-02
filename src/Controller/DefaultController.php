<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Parsedown;

final class DefaultController extends AbstractController
{
    #[Route('/', name: 'app_default')]
    public function index(Request $request): Response
    {
        $locale = $request->getLocale();
        $readmePath = $this->getParameter('kernel.project_dir') . "/readmeHTML/README_$locale.md";
        $readmeContent = file_get_contents($readmePath);

        $parsedown = new Parsedown();
        $parsedown->setSafeMode(true);
        $readmeHtml = $parsedown->text($readmeContent);

        return $this->render('default/index.html.twig', [
            'readme' => $readmeHtml,
        ]);
    }

    
    #[Route('/steam/{id}', name: 'steam_profile', defaults: ['id' => 1])]
    public function profile(Request $request, UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    {
        $selectedUserId = $request->query->get('user', $request->attributes->get('id'));
        $user = $entityManager->getRepository(User::class)->find($selectedUserId);
        $users = $userRepository->findAll();

        return $this->render('steam/profile.html.twig', [
            'user' => $user,
            'users' => $users,
        ]);
    }

    #[Route('/app/{vueRouting}', name: 'vue_app', requirements: ['vueRouting' => '.*'])]
    public function vueApp(): Response
    {
        return $this->render('vue/app.html.twig');
    }
}
