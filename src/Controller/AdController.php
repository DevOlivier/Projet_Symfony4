<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Entity\Image;
use App\Form\AjouterAnnonceType;
use App\Repository\AdRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdController extends AbstractController
{
    /**
     * @Route("/ad", name="ad")
     */
    public function index(AdRepository $repo) //$repo est une instance de la classe AdRepository
    {
        //on récupére les data de l'entity Ad
        $ad = $repo->findAll();
        return $this->render('ad/index.html.twig', [
            'ads' => $ad
        ]);
    }
    /**
     * CREATION ANNONCE
     * @Route("/ad/new", name="new")
     * @return Response
     */
    public function create(Request $request , ObjectManager $manager)
    {
        $ad = new Ad();
       
        $form = $this->createForm(AjouterAnnonceType::class , $ad);
        //Passe sur chaque champs
        $form->handleRequest($request);

        //dump($ad);
        if($form->isSubmitted() && $form->isValid()){

            foreach($ad->getImages() as $image){
                $image->setAd($ad);
                $manager->persist($image);
            }
            
            $ad->setAuthor($this->getUser());

            $manager->persist($ad);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre annnoce a bien été enregistrée'
            );

            return $this->redirectToRoute('ad_show' , [
                'slug' => $ad->getSlug(),
            ]);
        }

        return $this->render('ad/create.html.twig' , [
            'form' => $form->createView(),
        ]);
    }

    /**
     * Permet de modifier une annonce
     * 
     * @Route("/ad/{slug}/edit", name="ad_edit")
     *
     * @return Response
     */
    public function edit(Ad $ad , Request $request , ObjectManager $manager)
    {
        $form = $this->createForm(AjouterAnnonceType::class , $ad);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            foreach($ad->getImages() as $image){
                $image->setAd($ad);
                $manager->persist($image);
            }
            $manager->persist($ad);
            $manager->flush();

             $this->addFlash(
                'success',
                'Votre annonce à bien été modifiée'
            );
        }

        return $this->render('ad/edit.html.twig' , [
            'form' => $form->createView(),
            'ad' => $ad,
        ]);
    }

    /**
     * RECUPERE UNE SEULE ANNONCE
     * @Route("/ad/{slug}", name="ad_show")
     * @return Response
     */
    public function show(Ad $ad)
    {
        return $this->render('ad/show.html.twig' , [
            'ad' => $ad
        ]);
    }
}
