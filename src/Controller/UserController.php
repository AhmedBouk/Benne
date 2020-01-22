<?php

namespace App\Controller;

use App\Repository\UsersRepository;
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

    public function __construct(UsersRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

/* ========================
  Adds user to database
======================== */
    /**
     * @Route ("/api/add_user", name="add_user", methods={"POST"})
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

/* ==============================
   Updates user in database
============================== */
    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     * @throws \Exception
     * @Route ("/update_user/{id}", name="update_user", methods={"PUT"})
     */
    public function updateUser(Request $request, $id){
        if(!is_string($id) || (preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/', $id) !== 1 )){
            $response = new JsonResponse(['status' => "Wrong id"], Response::HTTP_OK);
            $response->headers->set('Access-Control-Allow-Origin', '*');
            return $response;
        }
        $users = $this->userRepository->findOneBy(['id' => $id]);
        $data = json_decode($request->getContent(), true);

        if(!empty($users) && !empty($data)){
            $this->userRepository->updateUser($users, $data);
            $response = new JsonResponse(['status' => "User updated"], Response::HTTP_OK);
            $response->headers->set('Access-Control-Allow-Origin', '*');
            return $response;
        }else{
            $response = new JsonResponse(['status' => "Data empty"], Response::HTTP_OK);
            $response->headers->set('Access-Control-Allow-Origin', '*');
            return $response;
        }
    }


/* ==============================
  Deletes user from database
============================== */
    /**
     * @param $id
     * @Route ("/delete_user/{id}",  name="delete_user", methods={"DELETE"})
     * @return JsonResponse
     */
    public function deleteDumpster($id){
        if(!is_string($id) || (preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/', $id) !== 1 )){
            $response = new JsonResponse(['status' => "Wrong id"], Response::HTTP_OK);
            $response->headers->set('Access-Control-Allow-Origin', '*');
            return $response;
        }
        $users = $this->userRepository->findOneBy(['id' => $id]);
        if(!empty($users)){
            $this->userRepository->deleteUser($users);
            $response = new JsonResponse(['status' => "User deleted"], Response::HTTP_OK);
            $response->headers->set('Access-Control-Allow-Origin', '*');
            return $response;
        }else{
            $response = new JsonResponse(['status' => "Wrong id"], Response::HTTP_OK);
            $response->headers->set('Access-Control-Allow-Origin', '*');
            return $response;
        }
    }

/* ==============================
  Finds user by given mail
============================== */
    /**
     * @param $id
     * @return JsonResponse
     * @Route ("/find_user_id/{id}", name="find_user_id", methods="GET")
     */
    public function findUserByGivenId($id)
    {
        if(!is_string($id) || (preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/', $id) !== 1 )){
            $response = new JsonResponse(['status' => "Wrong id"], Response::HTTP_OK);
            $response->headers->set('Access-Control-Allow-Origin', '*');
            return $response;
        }
        $users = $this->userRepository->findOneBy(['id' => $id]);
        if(!empty($users)){
            $data= array(
                'id' => $users->getId(),
                'mail' => $users->getMail(),
                'password' => $users->getPassword(),
                'role' => $users->getRoles(),
                'token' => $users->getToken(),
                'is_enabled' => $users->getIsEnabled(),
                'created_at' => $users->getCreatedAt(),
                'updated_at' => $users->getUpdatedAt()
            );

            $response = new JsonResponse([$data], Response::HTTP_OK);
            $response->headers->set('Access-Control-Allow-Origin', '*');
            return $response;
        }else{
            $response = new JsonResponse(['status' => "Wrong mail"], Response::HTTP_OK);
            $response->headers->set('Access-Control-Allow-Origin', '*');
            return $response;
        }
    }

/* ==============================
  lists all users from database
============================== */
    /**
     * @Route ("/list", name="list_all_users", methods={"GET"})
     */
    public function listAllUsers()
    {
        $users = $this->userRepository->findAll();
        if(!empty($users)){
            foreach($users as $user){
                $data[] = array(
                    'id' => $user->getId(),
                    'mail' => $user->getMail(),
                    'password' => $user->getPassword(),
                    'role' => $user->getRoles(),
                    'token' => $user->getToken(),
                    'is_enabled' => $user->getIsEnabled(),
                    'created_at' => $user->getCreatedAt(),
                    'updated_at' => $user->getUpdatedAt()
                );
            }
            $response = new JsonResponse([$data], Response::HTTP_OK);
            $response->headers->set('Access-Control-Allow-Origin', '*');
            return $response;
        }else{
            $response = new JsonResponse(['status' => "data empty"], Response::HTTP_OK);
            $response->headers->set('Access-Control-Allow-Origin', '*');
            return $response;
        }
    }

}
