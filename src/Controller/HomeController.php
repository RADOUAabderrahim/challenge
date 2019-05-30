<?php
/**
 * Created by PhpStorm.
 * User: abderrahim
 * Date: 2019-05-30
 * Time: 12:30
 */

namespace App\Controller;


use App\Repository\ShopsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class HomeController
 * @package App\Controller
 *
 */
class HomeController extends AbstractController
{
    /**
     * @Route("/",name="home")
     * @return Response
     */
    public function nearbyShops(ShopsRepository $repository) : Response
    {
        $shops = $repository->findAll();

        return $this->render('pages/home.html.twig',
            [
                "menu_active"=>"nearby_shops",
                "shops"=>$shops
            ]
        );
    }

    /**
     * @Route("/preferred",name="shops.preferred")
     * @return Response
     */
    public function preferredShops(ShopsRepository $repository) : Response
    {
        $shops = $repository->findAll();

        return $this->render('pages/preferred_shops.html.twig',
            [
                "menu_active"=>"preferred_shops",
                "shops"=>$shops
            ]
        );
    }


}