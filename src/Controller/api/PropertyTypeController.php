<?php

namespace App\Controller\api;

use App\Entity\PropertyType;

use App\Repository\PropertyTypeRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;



/**
 * @Route("/propertyType", name="propertyType.")
 */




class PropertyTypeController extends AbstractController
{
    private $_request;
    private $_request_method;
    private $_propertyType;
    private $_doctrine;

    public function __construct(RequestStack $request, PropertyTypeRepository $propertyTypeRepository, ManagerRegistry $entity)
    {
        $this->_request = $request->getCurrentRequest();
        $this->_request_method = $this->_request->getMethod();
        $this->_propertyType = $propertyTypeRepository;
        $this->_doctrine = $entity;
    }

    /**
     * @Route("/", name="manage_propertytype", methods={"GET", "POST"})
     */
    public function ManagePropertyTypes(): Response
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);


        switch ($this->_request_method) {
            case 'GET':
                $propertyTypies = $this->_propertyType->findAll();
                $data = $serializer->serialize($propertyTypies, 'json');
                return new JsonResponse($data);
            case 'POST':
                $newPropertyType = new PropertyType();
                $requestData = json_decode($this->_request->getContent(), true);
                $newPropertyType->setName($requestData['name'])->setDescription($requestData['description']);
                // var_dump($newPropertyType);
                $manager = $this->_doctrine->getManager();
                $manager->persist($newPropertyType);
                $manager->flush();
                $jsonContent = $serializer->serialize($newPropertyType, 'json');

                return new JsonResponse([
                    "status" => "ok",
                    "data" => $jsonContent
                ]);
        }
    }
    /**
     * @Route("/{id?}", name="single", methods={"PATCH", "DELETE","GET"})
     */
    public function ManagePropertyType(string $id)
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);

        switch ($this->_request_method) {

            case 'GET':
                $p = $this->_propertyType->find($id);
                $jsonContent = $serializer->serialize($p, 'json');
                // var_dump($p);
                return new jsonResponse([
                    "status" => "ok",
                    "data" => $jsonContent
                ]);
            case 'PATCH':

                $manager = $this->_doctrine->getManager();
                $newPropertyType = $this->_propertyType->find($id);
                $requestData = json_decode($this->_request->getContent(), true);
                $newPropertyType->setName($requestData['name'])->setDescription($requestData['description']);
                // var_dump($newPropertyType);

                $manager->flush();
                $jsonContent = $serializer->serialize($newPropertyType, 'json');
                return new jsonResponse([
                    "status" => "ok",
                    "data" => $jsonContent
                ]);
            case 'DELETE':

                $manager = $this->_doctrine->getManager();
                $p = $this->_propertyType->find($id);
                $manager->remove($p);
                $manager->flush();
                return new jsonResponse([
                    "status" => "ok",
                    "data" => "deleted successufully"
                ]);
        }
    }
}
