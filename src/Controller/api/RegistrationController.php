<?php

namespace App\Controller\api;

use App\Entity\Registration;
use App\Repository\OwnerRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\RegistrationRepository;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/registration", name="propertyType.")
 */

class RegistrationController extends AbstractController
{
    private $query;
    private $query_method;
    private $Repoproperty;
    private $doctrine;

    public function __construct(
        RequestStack $request,
        RegistrationRepository $propertyRepository,
        OwnerRepository $owner,
        ManagerRegistry $entity
    ) {
        $this->query = $request->getCurrentRequest();
        $this->query_method = $this->query->getMethod();
        $this->Repoproperty = $propertyRepository;
        $this->doctrine = $entity;
        $this->Owner = $owner;
    }

    /**
     * @Route("/", name="manageProperty", methods={"GET", "POST"})
     */
    public function ManageProperty(): Response
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);

        switch ($this->query_method) {

            case 'GET':
                // echo "Vyanse";
                $properties = $this->Repoproperty->getAll();
                $jsonContent = $serializer->serialize($properties, 'json', [
                    'circular_reference_handler' => function ($object) {
                        return $object->getId();
                    }
                ]);
                $response = new Response($jsonContent);
                $response->headers->set('Content-Type', 'application/json');
                return $response;
                break;

            case 'POST':
                $donnees = json_decode($this->query->getContent());
                $pro = new Registration();
                $pro->setTitle($donnees->title);
                $at = date("Y-m-d", strtotime($donnees->save_at));
                $pro->setSaveAt($at);
                $pro->setDescription($donnees->description);
                $pro->setPropertyId($donnees->proterty_id);
                $entityManager = $this->doctrine->getManager();
                $entityManager->persist($pro);
                $entityManager->flush();

                $jsonContent = $serializer->serialize($pro, 'json');
                $response = new Response($jsonContent);
                $response->headers->set('Content-Type', 'application/json');
                return $response;
        }
    }

    /**
     * @Route("/{id?}", name="OneProperty", methods={"PATCH","DELETE","GET"})
     */
    public function PropertyManager(int $id)
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        switch ($this->query_method) {

            case 'GET':
                $p = $this->Repoproperty->find($id);
                $jsonContent = $serializer->serialize($p, 'json', [
                    'circular_reference_handler' => function ($object) {
                        return $object->getId();
                    }
                ]);
                $response = new Response($jsonContent);
                $response->headers->set('Content-Type', 'application/json');
                return $response;

            case 'PUT':
                // var_dump($id);
                $manager = $this->doctrine->getManager();
                $newProperty = $this->Repoproperty->find($id);
                $requestData = json_decode($this->query->getContent());
                $newProperty->setTitle($requestData->title)
                    ->setDescription($requestData->description)
                    ->setPropertyId($requestData->property);

                // var_dump($requestData);
                // var_dump($newProperty);
                $manager->flush();
                return new jsonResponse([
                    "status" => "ok",
                    "data" => "successufully updated"
                ]);

            case 'DELETE':

                $manager = $this->doctrine->getManager();
                $p = $this->Repoproperty->find($id);
                $manager->remove($p);
                $manager->flush();
                return new jsonResponse([
                    "status" => "ok",
                    "data" => "deleted successufully"
                ]);
                break;
        }
    }
}
