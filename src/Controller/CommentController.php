<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CommentController extends AbstractController
{
    public function addComment(Request $request, EntityManagerInterface $em, int $id): Response
    {
        $user = $em->getRepository(User::class)->find($id);

        $content = $request->request->get('comment_content');
        if ($content) {
            $comment = new Comment();
            $comment->setContent($content);
            $comment->setCreatedAt(new \DateTimeImmutable());
            $comment->setUser($user);

            $em->persist($comment);
            $em->flush();
        }

        return $this->redirectToRoute('user_profile', ['id' => $id]);
    }
}