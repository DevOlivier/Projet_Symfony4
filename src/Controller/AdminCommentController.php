<?php

namespace App\Controller;


use App\Entity\Comment;
use App\Repository\CommentRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminCommentController extends AbstractController
{
    /**
     * @Route("/admin/comment", name="admin_comment")
     */
    public function index(CommentRepository $repo)
    {
        return $this->render('admin/comment/index.html.twig', [
            'comments' => $repo->findAll(),
        ]);
    }

    /**
     * Fonction qui permet de supprimer un post
     * 
     * @Route("/admin/comments/{id}/delete", name="admin_comment_delete")
     *
     * @return Response
     */
    function delete(Comment $comment , ObjectManager $manager){
        $manager->remove($comment);
        $manager->flush();

        $this->addFlash(
            'success',
            'Commentaire supprimé avec succès'
        );

        return $this->redirectToRoute('admin_comment');
    }
}
