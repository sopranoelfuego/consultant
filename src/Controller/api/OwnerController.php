<?php

namespace App\Controller\api;

use App\Entity\Owner;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\OwnerRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @Route("/owner")
 */
class OwnerController extends AbstractController
{
    private $_request;
    private $_request_method;
    private $_owner;
    private $_doctrine;


    public function __construct(RequestStack $request, OwnerRepository $owner_repo, ManagerRegistry $entity)
    {
        $this->_request = $request->getCurrentRequest();
        $this->_request_method = $this->_request->getMethod();
        $this->_owner = $owner_repo;
        $this->_doctrine = $entity;
    }

    /**
     * @Route("/", name="manage_owners", methods={"GET", "POST"})
     */
    public function ManageOwners()
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);
        switch ($this->_request_method) {
            case 'GET':
                $data = $this->_owner->getAll();
                $jsonContent = $serializer->serialize($data, 'json');


                return new JsonResponse([
                    "status" => "ok",
                    "data" => $jsonContent
                ]);
            case 'POST':
                $newOwner = new Owner();

                $requestData = json_decode($this->_request->getContent(), true);
                $newOwner->setName($requestData['name'])->setMobile($requestData['mobile'])->setAdress($requestData['adress']);
                $manager = $this->_doctrine->getManager();
                $manager->persist($newOwner);
                $manager->flush();
                $jsonContent = $serializer->serialize($newOwner, 'json');

                return new JsonResponse([
                    "status" => "ok",
                    "data" => $jsonContent
                ]);
        }
    }

    /**
     * @Route("/{owner_id?}", name="manage_owner", methods={"PATCH","GET", "DELETE"})
     */
    public function ManageOwner(string $owner_id)
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);
        switch ($this->_request_method) {
            case 'PATCH':
                $newOwner = $this->_owner->find($owner_id);
                $requestData = json_decode($this->_request->getContent(), true);
                $newOwner->setName($requestData['name'])->setMobile($requestData['mobile'])->setAdress($requestData['adress']);
                $manager = $this->_doctrine->getManager();

                $manager->flush();
                $jsonContent = $serializer->serialize($newOwner, 'json');

                return new JsonResponse([
                    "status" => "ok",
                    "data" => $jsonContent
                ]);
            case 'DELETE':
                $result = $this->_owner->delete($owner_id);
                if ($result) {

                    $manager = $this->_doctrine->getManager();
                    $manager->flush();

                    return new JsonResponse([
                        "status" => "ok",
                        "data" => "successfull delete"
                    ]);
                } else
                    return new JsonResponse([
                        "status" => "ok",
                        "data" => "errorr not deleted"
                    ]);
            case 'GET':
                $newOwner = $this->_owner->find($owner_id);
                $jsonContent = $serializer->serialize($newOwner, 'json');

                return new JsonResponse([
                    "status" => "ok",
                    "data" => $jsonContent
                ]);
        }
    }
}
