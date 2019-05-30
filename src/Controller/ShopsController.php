<?php
/**
 * Created by PhpStorm.
 * User: abderrahim
 * Date: 2019-05-30
 * Time: 14:05
 */

namespace App\Controller;


use App\Entity\Shops;
use App\Form\ShopsType;
use App\Repository\ShopsRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ShopsController
 * @package App\Controller
 * @Route("/admin")
 */
class ShopsController extends AbstractController
{
    /**
     * @var ShopsRepository
     */
    private $repository;

    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(ShopsRepository $repository,ObjectManager $objectManager)
    {
        $this->repository = $repository;
        $this->em = $objectManager;
    }

    /**
     * @Route("/shops",name="shops.list")
     * @return Response
     */
    public function list(): Response
    {
        $shops = $this->repository->findAll();

        return $this->render('admin/list_shops.html.twig',["shops"=>$shops]);
    }

    /**
     * @Route("/shops/create",name="shops.new")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $shop = new Shops();
        $form = $this->createForm(ShopsType::class,$shop);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->em->persist($shop);
            $this->em->flush();
            return $this->redirectToRoute('shops.list');
        }
        return $this->render('admin/edit_shops.html.twig',
            [
                "form"=>$form->createView(),
                "shop" =>$shop
            ]
        );
    }

    /**
     * @Route("/shops/edit/{id}",name="shops.edit")
     * @param Request $request
     * @param Shops $shop
     * @return Response
     */
    public function edit(Request $request,Shops $shop): Response
    {
        $form = $this->createForm(ShopsType::class,$shop);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->em->flush();
            return $this->redirectToRoute('shops.list');
        }

        return $this->render('admin/edit_shops.html.twig',
            [
                "form"=>$form->createView(),
                "shop" =>$shop
            ]
        );
    }

    /**
     * @Route("/shops/delete/{id}",name="shops.delete",methods="DELETE")
     * @param Request $request
     * @param Shops $shop
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(Shops $shop,Request $request){
        if($this->isCsrfTokenValid('delete'.$shop->getId(),$request->get('_token'))){
            $this->em->remove($shop);
            $this->em->flush();
        }
        return $this->redirectToRoute('shops.list');
    }

}