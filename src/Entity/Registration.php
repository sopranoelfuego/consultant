<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\RegistrationRepository;
use Symfony\Component\Validator\Constraints\Date;

#[ORM\Entity(repositoryClass: RegistrationRepository::class)]
class Registration
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    // #[ORM\Column(type: 'datetime')]
    private $save_at;

    #[ORM\Column(type: 'string', length: 255)]
    private $description;

    #[ORM\Column(type: 'integer')]
    private $property_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSaveAt(): ?string
    {
        return $this->save_at;
    }

    public function setSaveAt(string $save_at): self
    {
        $this->save_at = $save_at;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPropertyId(): ?int
    {
        return $this->property_id;
    }

    public function setPropertyId(int $property_id): self
    {
        $this->property_id = $property_id;

        return $this;
    }
}
