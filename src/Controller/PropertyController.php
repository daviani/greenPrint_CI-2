<?php

namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PropertyController extends AbstractController
{
    /**
     * @var PropertyRepository
     */
    private $repository;

    public function __construct(PropertyRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route("houses", name="property.index")
     */
    public function index(): Response
    {
        $this->repository->findNotSold();

        return $this->render('property/index.html.twig', [
            'current_menu' => 'houses',
            'primary_color' => 'active',
        ]);
    }

    /**
     * @Route("houses/{slug}-{id}", name="property.show", requirements={"slug": "[a-z0-9\-]*"})
     * @param Property $property
     * @param string $slug
     * @return Response
     */
    public function show(Property $property, string $slug): Response
    {
        if ($property->getSlug() !== $slug) {
            return $this->redirectToRoute('property.show', [
                'id' => $property->getId(),
                'slug' => $property->getSlug(),
            ], 301);
        }

        return $this->render('property/show.html.twig', [
            'current_menu' => 'houses',
            'primary_color' => 'active',
            'property' => $property,
        ]);
    }
}

/*
      $property = new Property();
      $property->setTitle('property_1')
          ->setPrice(20000)
          ->setRooms(4)
          ->setBedrooms(2)
          ->setDescription('small describe')
          ->setSurface(50)
          ->setFloor(3)
          ->setHeat(3)
          ->setCity('Lyon')
          ->setAddress('23 Rue Bossuet')
          ->setPostalcode('69006')
          ->setCountry('France');

      $em = $this->getDoctrine()->getManager();
      $em->persist($property);
      $em->flush();
*/
