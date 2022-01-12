<?php

namespace App\Controller\api;

use App\Entity\Property;
use App\Repository\OwnerRepository;
use App\Repository\PropertyRepository;
use function PHPUnit\Framework\isNull;
use Doctrine\Persistence\ManagerRegistry;
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
 * @Route("/property", name="property.")
 */

class PropertyController extends AbstractController
{
    private $query;
    private $query_method;
    private $Repoproperty;
    private $doctrine;
    // private $typePro;
    // private $one;
    // private $Owner;

    public function __construct(
        RequestStack $request,
        PropertyRepository $propertyRepository,
        OwnerRepository $owner,
        ManagerRegistry $entity
    ) {
        $this->query = $request->getCurrentRequest();
        $this->query_method = $this->query->getMethod();
        $this->Repoproperty = $propertyRepository;
        $this->doctrine = $entity;
        // $this->typePro = $typePro;ss
        $this->Owner = $owner;
    }

    /**
     * @Route("/", name="manageProperty")
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
                // var_dump($donnees);
                $pro = new Property();
                $pro->setName($donnees->name);
                $pro->setPropertyId($donnees->property_id);
                $pro->setOwnerId($donnees->owner_id);

                $entityManager = $this->doctrine->getManager();
                $entityManager->persist($pro);
                $entityManager->flush();

                $jsonContent = $serializer->serialize($pro, 'json', [
                    'circular_reference_handler' => function ($object) {
                        return $object->getId();
                    }
                ]);
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

            case 'PATCH':
                // var_dump($id);
                $manager = $this->doctrine->getManager();
                $newProperty = $this->Repoproperty->find($id);
                $requestData = json_decode($this->query->getContent(), true);
                $newProperty->setName($requestData['name'])
                    ->setPropertyId(!isNull($requestData['property_id']) ? $requestData['property_id'] : $newProperty->getPropertyId())
                    ->setOwnerId(!isNull($requestData['owner_id']) ? $requestData['owner_id'] : $newProperty->getOwnerId());

                var_dump($requestData);
                $manager->persist($newProperty);
                $manager->flush();
                return new jsonResponse([
                    "status" => "ok",
                    "data" => "successufully updated"
                ]);
                break;

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
