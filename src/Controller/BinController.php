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
    public function addBin(): Response
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
        return new Response('Saved new client with id ' . $dumpster->getId());
    }

    /**
     * @Route("/add_json_to_database", name="add_json_to_database")
     */
    //Misses duplicates protection in DB
    public function addJSONtoDatabase()
    {
        $string = file_get_contents('../uploads/benneMontpellier.json');
        $json = json_decode($string, true);
        $obj = $json['features'];
        $count = count($obj);

        $error = array(
            "type" => 0,
            "name" => 0,
            "coordinates" => 0,
        );

        for ($i = 0; $i < $count; $i++) {
            $type = $obj[$i]['properties']['type'];
            $address = $obj[$i]['properties']['rue'];
            $latitude = $obj[$i]['geometry']['coordinates']['0'];
            $longitude = $obj[$i]['geometry']['coordinates']['1'];
            $entityManager = $this->getDoctrine()->getManager();
            $dumpster = new Dumpster();

            if (!empty($type) && is_string($type)) {
                $dumpster->setType($type);
            } else {
                $error['type']++;
            }
            if (!empty($address) && is_string($address)) {
                $dumpster->setName($address);
            } else {
                $error['name']++;
            }
            if (!empty($latitude) && !empty($longitude)) {
                $dumpster->setCoordinates('POINT(' . $latitude . ' ' . $longitude . ')');
            } else {
                $error['coordinates']++;
            }
            $dumpster->setStatus('testStatus');
            $dumpster->setIsEnabled(1);

            $dumpsters = $this->getDoctrine()->getRepository(Dumpster::class)->findDumpsterByCoos($latitude, $longitude);

            if($dumpsters){
                echo 'error';
            }else {
                $entityManager->persist($dumpster);
                $entityManager->flush();
            }
        }
        return new Response("j'aime les chips");
    }
}


