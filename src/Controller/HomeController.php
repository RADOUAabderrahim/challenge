<?php
/**
 * Created by PhpStorm.
 * User: abderrahim
 * Date: 2019-05-30
 * Time: 12:30
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class HomeController
 * @package App\Controller
 * @Route("/")
 */
class HomeController extends AbstractController
{
    /**
     * @Route("/",name="home")
     */
    public function index(){
        return $this->render('home/home.html.twig');
    }

}