<?php
/**
 * Created by PhpStorm.
 * User: abderrahim
 * Date: 2019-05-30
 * Time: 12:30
 */

namespace App\Controller;


use App\Entity\PreferredShops;
use App\Repository\PreferredShopsRepository;
use App\Repository\ShopsRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class HomeController
 * @package App\Controller
 * @Route("/shops")
 */
class HomeController extends AbstractController
{
    /**
     * @Route("/nearby",name="shops.nearby")
     * @return Response
     */
    public function nearbyShops(ShopsRepository $repository,PaginatorInterface $paginator,Request $request) : Response
    {
        //$shops = $repository->findAll();

        $shops = $paginator->paginate(
            $repository->findAllShopNearByWLADQuery(),
            $request->query->getInt('page', 1),
            12
        );

        return $this->render('pages/nearby.html.twig',
            [
                "menu_active"=>"nearby_shops",
                "shops"=>$shops,
              //  'pagination' => $pagination
            ]
        );
    }

    /**
     * @Route("/preferred",name="shops.preferred")
     * @return Response
     */
    public function preferredShops(ShopsRepository $repository,PaginatorInterface $paginator,Request $request) : Response
    {
        $user = $this->getUser();

        $shops = $paginator->paginate(
            $repository->findAllPreferredShopQuery($user->getId()),
            $request->query->getInt('page', 1),
            12
        );

        return $this->render('pages/preferred.html.twig',
            [
                "menu_active"=>"preferred_shops",
                "shops"=>$shops,
            ]
        );

    }

    /**
     * @Route("/opinion/{id}",name="shops.opinion")
     * @return Response
     */
    public function opinion($id,Request $request,ShopsRepository $repository,PreferredShopsRepository $preferredRepository,ObjectManager $manager) : Response
    {
        $shops = $repository->findOneBy(['id'=>$id]);

        $user = $this->getUser();

        $preferredShops = $preferredRepository->findOneBy(["user"=>$user->getId(),"shops"=>$shops->getId()]);

        if(!$preferredShops) {

            $preferredShops = new PreferredShops();

            $preferredShops->setUser($user);

            $preferredShops->setShops($shops);
        }

        $preferredShops->setUpdatedAt(new \DateTime('now'));

        if(trim($request->get('submit'))=="like"){
            $preferredShops->setOpinion(PreferredShops::OPINION['liked']);
        }else{
            $preferredShops->setOpinion(PreferredShops::OPINION['disliked']);
        }

        $manager->persist($preferredShops);

        $manager->flush();

        return $this->redirectToRoute('shops.nearby');
    }

    /**
     * @Route("/preferred/remove/{id}",name="shops.preferred.remove")
     * @return Response
     */
    public function remove($id,Request $request,ShopsRepository $repository,PreferredShopsRepository $preferredRepository,ObjectManager $manager) : Response
    {
        $shops = $repository->findOneBy(['id'=>$id]);

        $user = $this->getUser();

        $preferredShops = $preferredRepository->findOneBy(["user"=>$user->getId(),"shops"=>$shops->getId()]);

        if($preferredShops){

            $manager->remove($preferredShops);

            $manager->flush();
        }

        return $this->redirectToRoute('shops.preferred');
    }
}