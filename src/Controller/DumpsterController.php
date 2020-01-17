<?php

namespace App\Controller;

use App\Repository\DumpsterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Dumpster;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DumpsterController
 * @package App\Controller
 *
 * @Route(path="/dumpster")
 */
class DumpsterController extends AbstractController
{
    private $dumpsterRepository;

    public function __construct(DumpsterRepository $DumpsterRepository)
    {
        $this->dumpsterRepository = $DumpsterRepository;
    }

    /* =====================================
       Adds uploaded JSON File to database
    ====================================== */
    /**
     * @Route("/add_json", name="add_json", methods={"POST"})
     */
    public function addJSON()
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

            $dumpsters = $this->getDoctrine()
                ->getRepository(Dumpster::class)
                ->findDumpsterByCoos($latitude, $longitude);

            if (!$dumpsters) {
                $entityManager->persist($dumpster);
                $entityManager->flush();
            }
        }
        return new Response("Json bien ajouté à la BDD(j'aime les chips)");
    }

/* ==============================================
   lists all dumpsters from database
 ============================================== */
    /**
     * @Route ("/list", name="list_all_dumpsters", methods={"GET"})
     */
    public function listAllDumpsters()
    {
        $dumpsters = $this->dumpsterRepository->findAll();
        if(!empty($dumpsters)){
            foreach($dumpsters as $dumpster){
                $data[] = array(
                    'id' => $dumpster->getId(),
                    'id_city' => $dumpster->getIdCity(),
                    'name' => $dumpster->getName(),
                    'type' => $dumpster->getType(),
                    'status' => $dumpster->getStatus(),
                    'is_enabled' => $dumpster->getIsEnabled(),
                    'upload' => $dumpster->getUpload(),
                    'coordinates' => $dumpster->getCoordinates(),
                    'created_at' => $dumpster->getCreatedAt(),
                    'updated_at' => $dumpster->getUpdatedAt()
                );
            }
            $response = new JsonResponse(['status' => $data], Response::HTTP_OK);
            $response->headers->set('Access-Control-Allow-Origin', '*');
            return $response;
        }else{
            $response = new JsonResponse(['status' => "Va niquer ta douce daronne les data sont vides"], Response::HTTP_OK);
            $response->headers->set('Access-Control-Allow-Origin', '*');
            return $response;
        }
    }

/* ==============================================
   lists all "glass" type dumpsters from database
 ============================================== */
    /**
     * @Route ("/list_glass", name="list_glass_dumpsters", methods={"GET"})
     */
    public function listGlassDumpsters()
    {
        $dumpsters = $this->dumpsterRepository->findBy(['type' => "Verre"]);
        if(!empty($dumpsters)){
            foreach($dumpsters as $dumpster){
                $data[] = array(
                    'id' => $dumpster->getId(),
                    'id_city' => $dumpster->getIdCity(),
                    'name' => $dumpster->getName(),
                    'type' => $dumpster->getType(),
                    'status' => $dumpster->getStatus(),
                    'is_enabled' => $dumpster->getIsEnabled(),
                    'upload' => $dumpster->getUpload(),
                    'coordinates' => $dumpster->getCoordinates(),
                    'created_at' => $dumpster->getCreatedAt(),
                    'updated_at' => $dumpster->getUpdatedAt()
                );
            }
            $response = new JsonResponse(['status' => $data], Response::HTTP_OK);
            $response->headers->set('Access-Control-Allow-Origin', '*');
            return $response;
        }else{
            $response = new JsonResponse(['status' => "Va niquer ta douce daronne les data sont vides"], Response::HTTP_OK);
            $response->headers->set('Access-Control-Allow-Origin', '*');
            return $response;
        }
    }

/* ============================
  Adds dumpster to database
============================ */
    /**
     * @Route ("/add_dumpster", name="add_dumpster", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function addDumpster(Request $request){
        $data = json_decode($request->getContent(), true);

        if(empty($data['name']) || empty($data['type']) || empty($data['latitude']) || empty($data['longitude']) || empty($data['idCity']) || empty($data['status'])){
            return new JsonResponse('Missing parameter - please try again');
        }

        $name = $data['name'];
        $type = $data['type'];
        $latitude = $data['latitude'];
        $longitude = $data['longitude'];
        $idCity = $data['idCity'];
        $status = $data['status'];

        $dump = $this->dumpsterRepository->findBy(['coordinates' => 'POINT('. $latitude . ' ' . $longitude.')']);
        if(empty($dump)){
            $this->dumpsterRepository->addDumpster($name, $type, $latitude, $longitude, $idCity, $status);
            $response = new JsonResponse(['status' => 'new glass dump created'], Response::HTTP_CREATED);
            $response->headers->set('Access-Control-Allow-Origin', '*');
            return $response;
        }else{
            $response = new JsonResponse(['status' => 'Dumpster already exists'], Response::HTTP_OK);
            $response->headers->set('Access-Control-Allow-Origin', '*');
            return $response;
        }
    }

/* ==============================
  Deletes dumpster from database
============================== */
    /**
     * @param $id
     * @Route ("/delete_dumpster/{id}",  name="delete_dumpster", methods={"DELETE"})
     * @return JsonResponse
     */
    public function deleteDumpster($id){
        if(!is_string($id) || (preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/', $id) !== 1 )){
            $response = new JsonResponse(['status' => "Wrong id"], Response::HTTP_OK);
            $response->headers->set('Access-Control-Allow-Origin', '*');
            return $response;
        }
        $dumpster = $this->dumpsterRepository->findOneBy(['id' => $id]);
        if(!empty($dumpster)){
            $this->dumpsterRepository->deleteDumpster($dumpster);
            $response = new JsonResponse(['status' => "Dumpster deleted"], Response::HTTP_OK);
            $response->headers->set('Access-Control-Allow-Origin', '*');
            return $response;
        }else{
            $response = new JsonResponse(['status' => "Wrong id"], Response::HTTP_OK);
            $response->headers->set('Access-Control-Allow-Origin', '*');
            return $response;
        }
    }

/* ==============================
  Updates dumpster in database
============================== */
    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     * @throws \Exception
     * @Route ("/update_dumpster/{id}", name="update_dumpster", methods={"PUT"})
     */
    public function updateDumpster(Request $request, $id){
        if(!is_string($id) || (preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/', $id) !== 1 )){
            $response = new JsonResponse(['status' => "Wrong id"], Response::HTTP_OK);
            $response->headers->set('Access-Control-Allow-Origin', '*');
            return $response;
        }
        $dumpster = $this->dumpsterRepository->findOneBy(['id' => $id]);
        $data = json_decode($request->getContent(), true);

        if(!empty($dumpster) && !empty($data)){
            $this->dumpsterRepository->updateDumpster($dumpster, $data);
            $response = new JsonResponse(['status' => "Dumpster updated"], Response::HTTP_OK);
            $response->headers->set('Access-Control-Allow-Origin', '*');
            return $response;
        }else{
            $response = new JsonResponse(['status' => "Va niquer ta douce daronne les data sont vides"], Response::HTTP_OK);
            $response->headers->set('Access-Control-Allow-Origin', '*');
            return $response;
        }
    }
}


