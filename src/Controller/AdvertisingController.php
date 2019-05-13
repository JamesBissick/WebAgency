<?php

namespace App\Controller;

use App\Entity\Advertising;
use App\Form\AnnoucementType;
use App\Repository\AdvertisingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
     *
     * @Route("/ads/new", name="ads_new")
     * @return Response
     */
    public function create(){

        $ad = new Advertising();

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
