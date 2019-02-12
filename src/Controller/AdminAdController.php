<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Form\AjouterAnnonceType;
use App\Repository\AdRepository;

use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminAdController extends AbstractController
{
    /**
     * @Route("/admin/ads", name="admin_ads")
     */
    public function index(AdRepository $repo)
    {
        return $this->render('admin/ad/index.html.twig', [
            'ads' => $repo->findAll(),
        ]);
    }

    /**
     * Permet de créer un formulaire d'édition des annonce : On récupére les data du form AjouterAnnonceType
     *
     * @Route("/admin/ads/{id}/edit", name="admin_ads_edit")
     * 
     * @param Ad $ad
     * @return Response
     */
    public function edit(Ad $ad , Request $request , ObjectManager $manager){
        $form = $this->createForm(AjouterAnnonceType::class , $ad);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($ad);
            $manager->flush();

            $this->addFlash(
                'success',
                'C\'est enregistré'
            );
        }

        return $this->render('admin/ad/edit.html.twig', [
            'ad' => $ad,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Supprime une annonce
     * 
     * @Route("/admin/ads/{id}/delete", name="admin_ads_delete")
     *
     * @return Response
     */
    public function delete(Ad $ad , ObjectManager $manager){
        if(count($ad->getBookings()) > 0 ){
            $this->addFlash(
                'warning',
                'Impossible de supprimer cette annonce. Celle ci contient des réservations en cours'
            );
        }else {
                $manager->remove($ad);
                $manager->flush();

                $this->addFlash(
                    'success',
                    'L\'annonce a bien été supprimer avec succès '
            );
        }
        return $this->redirectToRoute('admin_ads');
    }
}
