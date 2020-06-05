<?php

namespace App\Controller;

use App\Entity\Posts;
use App\Form\PostsType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PostsController extends AbstractController {

    /**
     * @Route("/registrar-posts", name="posts")
     */
    public function index(Request $request) {
        $post = new Posts();
        $form = $this->createForm(PostsType::class,$post);

        //Si fue enviado
        $form->handleRequest($request);
        //Si el formulario fue enviado y es valido
        if($form->isSubmitted() && $form->isValid()){

            //Cargar usuario logueado
            $user = $this->getUser();

            $post->setUser($user);

            //Guardamos en la base de datos
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();
            return $this->redirectToRoute('dashboard');
        }

        return $this->render('posts/index.html.twig', [
                    'form' => $form->createView()
        ]);
    }

}
