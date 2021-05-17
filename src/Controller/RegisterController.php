<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegisterController extends AbstractController
{
    /**
     * @Route("/register", name="register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passEncoder): Response
    {
        $form = $this->createFormBuilder()
            ->add('username', TextType::class, array('label' => 'Username', 
            'attr' => array(
                'placeholder' => 'Enter username',
                'class' => 'py-4'
            )))
            ->add('password', RepeatedType::class, [
                'type'=>PasswordType::class,
                'required'=>true,
                'first_options'=>['label'=>'Password', 
                    'attr' => array(
                        'placeholder' => 'Enter password',
                    )
                ],
                'second_options'=>['label'=>'Confirm Password', 
                    'attr' => array(
                        'placeholder' => 'Confirm password',
                    )
                ],
            ])
            /*->add('roles', ChoiceType::class, [
                'choices'=> [
                    'ROLE_USER' => 'ROLE_USER',
                    'ROLE_ADMIN' => 'ROLE_ADMIN',
                    'ROLE_SUPER_ADMIN' => 'ROLE_SUPER_ADMIN',
                ],
                'multiple'=>true
            ])*/
            ->add('register', SubmitType::class, [
                'label'=>"Create Account",
                'attr' => array(
                    'class' => 'btn btn-primary btn-block' 
                )
            ])
            ->getForm();

            $form->handleRequest($request);

            if($request->isMethod('post') &&  $form->isValid()) {
                $data = $form->getData();

                $defaultRole[] = 'ROLE_USER';

                $user = new User;

                $user->setUsername($data['username']);
                $user->setPassword($passEncoder->encodePassword($user, $data['password']));
                $user->setRoles($defaultRole);
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();

                return $this->redirect($this->generateUrl('app_login'));
            }

        return $this->render('register/index.html.twig', [
            'form'=>$form->createView()
        ]);
    }
}
