<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Dumpster;
use Symfony\Component\HttpFoundation\Response;

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

    /**
     * @Route("json_to_object", name="json_to_object")
     */
    public function JSONtoObject()
    {
        $string = file_get_contents('../uploads/benneMontpellier.json');

        $jsonInArray = json_decode($string, true);
    }



    /**
     * @Route("/add_json_to_database", name="add_json_to_database")
     */
    public function addJSONtoDatabase():Response
    {
        $string = file_get_contents('../uploads/benneMontpellier.json');
        $jsonInArray = json_decode($string, true);
        $bins = $jsonInArray['features'];

        $error = array(
            "type" => 0,
            "name" => 0,
            "coordinates" => 0,
        );

        foreach($bins as $json) {
            $entityManager = $this->getDoctrine()->getManager();

            $dumpster = new Dumpster();

            if(!empty($json{'properties'}{'type'}) && is_string($json{'properties'}{'type'})){
                $dumpster->setType($json['properties']['type']);
            }else{
                $error['type']++;
            }
            if(!empty($json{'properties'}{'rue'}) && is_string($json{'properties'}{'rue'})){
                $dumpster->setName($json['properties']['rue']);
            }else{
                $error['name']++;
            }
            if(!empty($json{'geometry'}{'coordinates'}['0']) && !empty($json{'geometry'}{'coordinates'}['0'])){
                $dumpster->setCoordinates('POINT(' . $json["geometry"]["coordinates"]["0"] . ' ' . $json["geometry"]["coordinates"]["1"] . ')');
            }else{
                $error['coordinates']++;
            }
            $dumpster->setStatus('testStatus');
            $dumpster->setIsEnabled(1);

            $em = $dumpster->getCoordinates();
            print_r($em);

            $entityManager->persist($dumpster);
            $entityManager->flush();

        }
        return new JsonResponse($jsonInArray{'features'}, Response::HTTP_CREATED);
    }
}
