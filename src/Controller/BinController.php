<?php

namespace App\Controller;

use http\Client\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Dumpster;

class BinController extends AbstractController
{
    /**
     * @Route("/bin", name="bin")
     */
    public function index()
    {
        $entityManager = $this->getDoctrine()->getManager();
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/BinController.php',
        ]);
    }

    /**
     * @Route("/add_bin", name="add_bin")
     */
    public function addBin() : Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $dumpster = new Dumpster();
        $dumpster->setName('test');
        $dumpster->setType('typeTest');
        $dumpster->setIsEnabled(1);
        $dumpster->setStatus('testStatus');
        $dumpster->setCoordinates('POINT(37.4220761 -122.0845187)');
        $entityManager->persist($dumpster);
        $entityManager->flush();
        return new Response('Saved new client with id '.$dumpster->getId());


    }
}
