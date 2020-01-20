<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Users;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class UserController
 * @package App\Controller
 *
 * @Route(path="/user")
 */
class UserController extends AbstractController
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

/* ========================
  Adds user to database
======================== */
    /**
     * @Route ("/add_user", name="add_user", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function addUser(Request $request){
        $data = json_decode($request->getContent(), true);

        if(empty($data['mail']) || empty($data['password']) || empty($data['role']) || empty($data['token'])){
            return new JsonResponse('Missing parameter - please try again');
        }

        $mail = $data['mail'];
        $password = $data['password'];
        $role = $data['role'];
        $token = $data['token'];

        $user = $this->userRepository->findBy(['mail' => $mail]);
        if(empty($user)){
            $this->userRepository->addUser($mail, $password, $role, $token);
            $response = new JsonResponse(['status' => 'new User created'], Response::HTTP_CREATED);
            $response->headers->set('Access-Control-Allow-Origin', '*');
            return $response;
        }else{
            $response = new JsonResponse(['status' => 'User already exists'], Response::HTTP_OK);
            $response->headers->set('Access-Control-Allow-Origin', '*');
            return $response;
        }
    }

}
