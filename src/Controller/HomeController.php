<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController {

    /**
     * @Route("/welcome/{name}", name="welcome")
     * @Route("/welcome", name="welcome_basic")
     * Display the page that says hello
     * /!\ Annotations have to be before functions!
     *
     * @param $name
     * @return Response
     */
    public function welcome($name = 'Anon'){

        return $this->render(
            'hello.html.twig',
            [
                'name' => $name
            ]
        );
    }

    /**
     * @Route("/", name="homepage")
     */
    public function home(){

        $name = ['Ellen => 22', 'James => 27', 'Harrys => 21'];
        return $this->render(
            'home.html.twig',
            [
                'title' => "See you!",
                'age' => 27,
                'table' => $name
            ]
        );
    }
}