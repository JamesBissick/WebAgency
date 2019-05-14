<?php

namespace App\Controller;

use App\Entity\Advertising;
use App\Entity\Image;
use App\Form\AnnoucementType;
use App\Repository\AdvertisingRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdvertisingController extends AbstractController
{
    /**
     * @Route("/ads", name="ads_index")
     */
    public function index(AdvertisingRepository $repo) {

        /* Connect to doctrine, get repository(of Advertising table::class) */
        // We don't need it anymore since we import the repository directly inside our index function parameter using auto-wiring
        /*$repo = $this->getDoctrine()->getRepository(Advertising::class);*/

        /* Ask the repo to find all ads that it can */
        $ads = $repo->findAll();

        return $this->render('advertising/index.html.twig', [
            'ads' => $ads,
        ]);
    }

    /**
     * Displays a create new post page
     * Recovering the submitted form
     *
     * @Route("/ads/new", name="ads_new")
     * @param Request $request
     * @param ObjectManager $manager
     * @return Response
     */
    public function create(Request $request, ObjectManager $manager){

        // Create a new instance (object ad)
        $ad = new Advertising();

        // Handles Request and entered infos are transfered in the database
        $form = $this->createForm(AnnoucementType::class, $ad);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            //$manager = $this->getDoctrine()->getManager();
            $manager->persist($ad);
            $manager->flush();

            $this->addFlash(
                'success', "<strong>Test</strong> has been successfully added!"
            );

            return $this->redirectToRoute('ads_show', [
               'slug' => $ad->getSlug()
            ]);
        }

        // Symfony's form builder, called input label and it will make it auto, it's magic!
        $form = $this->createForm(AnnoucementType::class, $ad);

        return $this->render('advertising/new.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * Display a single advert
     * We don't need it anymore since we import the repository directly inside our index function parameter using auto-wiring: AdvertisingRepository $repo
     *
     * @Route("/ads/{slug}", name="ads_show")
     *
     * @return Response
     */
    public function show($slug, AdvertisingRepository $repo){
            // I retrieve the correspondant ad to the slug
            $ad = $repo->findOneBySlug($slug);

            return $this->render('advertising/show.html.twig', [
                    'ad' => $ad
                ]);
        }


}
