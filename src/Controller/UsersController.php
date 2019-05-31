<?php
/**
 * Created by PhpStorm.
 * User: abderrahim
 * Date: 2019-05-30
 * Time: 11:41
 */

namespace App\Controller;


use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\EventDispatcher\EventDispatcher;

class UsersController extends AbstractController
{

    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(UserPasswordEncoderInterface $encoder,ObjectManager $objectManager)
    {
        $this->encoder = $encoder;
        $this->em = $objectManager;
    }

    /**
     * @Route("/",name="app_login",methods={"GET", "POST"})
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('pages/login.html.twig',
            [
                'last_username' => $lastUsername,
                'error' => $error,
            ]
        );
    }

    /**
     * @Route("/registre", name="user.registre")
     */
    public function user_registre(Request $request, UserRepository $repository) {

        $user = $repository->findOneBy(['email'=>$request->request->get("email")]);

        $isValidRequest = $this->isCsrfTokenValid("authenticate", $request->request->get("_csrf_token"));

        $error = null;

        if ($user instanceof User) {
            $error = "this account already exists";
        }else if ($isValidRequest == false) {
            $error = "csrf invalid";
        }else{

            $user = new User();
            $user->setEmail($request->request->get("email"));
            $user->setPassword($this->encoder->encodePassword($user,$request->request->get("password")));
            $user->setRoles(implode(';',['ROLE_USER']));

            $this->em->persist($user);
            $this->em->flush();

            $stackRequest = new \Symfony\Component\HttpFoundation\RequestStack();
            $stackRequest->push($request);

            //TODO: check this instruction is not working !!!
            return $this->forward('App\Controller\UsersController::login', [
                'authenticationUtils'  => new AuthenticationUtils($stackRequest),
            ]);
        }

        return $this->render('pages/login.html.twig',
            [
                'last_username' => "",
                'error' => $error,
                'has_error' => ($error == null ? false : true)
            ]
        );
    }





}