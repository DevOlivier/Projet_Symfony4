<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Form\AdminBookingType;
use App\Repository\BookingRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminBookingController extends AbstractController
{
    /**
     * @Route("/admin/booking", name="admin_booking")
     */
    public function index(BookingRepository $repo)
    {
        return $this->render('admin/booking/index.html.twig', [
            'bookings' => $repo->findAll()
        ]);
    }

    /**
     * Permet de modifier la gestion des reservations
     *
     * @Route("/admin/booking/{id}/edit", name="admin_booking_edit")
     * 
     * @return Response
     */
    public function edit(Booking $booking , Request $request , ObjectManager $manager){

        $form = $this->createForm(AdminBookingType::class , $booking);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($booking);
            $manager->flush();

            $this->addFlash(
                'success',
                'Annonce modifiée avec succès'
            );
            return $this->redirectToRoute('admin_booking');
        }
        

        return $this->render('admin/booking/edit.html.twig', [
            'form' => $form->createView(),
            'booking' => $booking,
        ]);
    }

    /**
     * Suppression d'une réservation
     * 
     * @Route("/admin/booking/{id}/delete", name="admin_booking_delete")
     *
     * @return Response
     */
    public function delete(Booking $booking , ObjectManager $manager){
        $manager->remove($booking);
        $manager->flush();

        $this->addFlash(
            'success',
            'La réservation a bien été supprimé'
        );

        return $this->redirectToRoute('admin_booking');
    }
}
