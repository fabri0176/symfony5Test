<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistroController extends AbstractController {

    /**
     * @Route("/registro", name="registro")
     */
    public function index(Request $request, UserPasswordEncoderInterface $passwordEncoder) {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        //Si el formulario fue enviado
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //Persistir el registro en la bd
            $em = $this->getDoctrine()->getManager();

            //Asignación variable requerida
            $user->setBaneado(false);

            //Asignación rol
            $user->setRoles(['ROLE_USER']);

            //Obtener contraseña de usuario y encriptar
            $user->setPassword($passwordEncoder->encodePassword($user, $form['password']->getData()));

            $em->persist($user);
            $em->flush();

            //Mensaje
            $this->addFlash('success', User::REGISTRO_EXITOSO);

            //Redireccionamos a controlador
            return $this->redirectToRoute('registro');
        }

        return $this->render('registro/index.html.twig', [
                    'controller_name' => 'RegistroController',
                    'formulario' => $form->createView()
        ]);
    }

}
