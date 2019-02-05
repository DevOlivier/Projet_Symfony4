<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AccountType;
use App\Entity\PasswordUpdate;
use App\Form\RegistrationType;
use App\Form\PasswordUpdateType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountController extends AbstractController
{
    /**
     * Permet d'afficher et de gérer le formulaire de connexion des users
     * 
     * @Route("/login", name="account_login")
     * 
     * @return Response
     */
    public function login(AuthenticationUtils $utils)
    {
        $error = $utils->getLastAuthenticationError();
        $username = $utils->getLastUsername();
    
        return $this->render('account/login.html.twig', [
            'variableErreur' => $error !== null,
            'variableLastUser' => $username
        ]);
    }
    /**
     * Function qui sert uniquement à la deconnexion. 
     * 
     * @Route("/logout", name="account_logout")
     *
     * @return void
     */
    public function logout(){
        //...
    }
    /**
     * fonction qui permet de s'inscrire sur le site
     * 
     * @Route("/register", name="account_register")
     *
     * @return Response
     */
    public function register(Request $request , ObjectManager $manager , UserPasswordEncoderInterface $encoder){
        $user = new User();
        $form = $this->createForm(RegistrationType::class , $user);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            $hash = $encoder->encodePassword($user , $user->getHash());
            $user->setHash($hash);

            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre compte a bien été enregistré.'
            );
            return $this->redirectToRoute('account_login');
        }

        return $this->render('account/registration.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     * fonction qui va permettre de modifier un profil
     * 
     * @Route("/account/profile", name="account_profil")
     * 
     * @return Response
     */
    public function profile(Request $request , ObjectManager $manager){
        $user = $this->getUser();
        $form = $this->createForm(AccountType::class , $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                'Les données ont bien été enregistrées !'
            );
        }
        
        return $this->render('account/profile.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * Function qui permet de modifier le mot de passe 
     * 
     * @Route("/account/update-password", name="account_password")
     *
     * @return Response
     */
    public function updatePassword(Request $request , UserPasswordEncoderInterface $encoder , ObjectManager
    $manager){
        $passwordUpdate = new PasswordUpdate();
        $user = $this->getUser();
        $form = $this->createForm(PasswordUpdateType::class , $passwordUpdate);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            if(!password_verify($passwordUpdate->getOldPassword() , $user->getHash())){
                //https://api.symfony.com/4.1/Symfony/Component/Form/Form.html
                $form->get('oldPassword')->addError(new FormError('Mot de passe incorrect'));
            }else{
                $newPassword = $passwordUpdate->getNewPassword();
                $hash = $encoder->encodePassword($user , $newPassword);
                $user->setHash($hash);

                $manager->persist($user);
                $manager->flush();

                $this->addFlash(
                    'success',
                    'Mot de passe changé avec succès'
                );
                return $this->redirectToRoute('homePage');
            }
        }

        return $this->render('account/password.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet à l'utilisateur de se connecter au profil de son compte
     *
     * @Route("/account", name="account_index")
     * 
     * @return Response
     */
    public function myAccount(){
        $user = $this->getUser();
        return $this->render('user/index.html.twig' , [
            'user' => $user,
        ]);
    }
}
