<?php

namespace App\Entity;

use Assert\When;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\BoatRepository;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BoatRepository::class)]
class Boat extends Location
{
   

    #[ORM\Column(length: 255)]
    private ?string $motor = null;

    #[ORM\Column]
    private ?int $roofHeight = null;

    #[When(
        expression: 'this.isIsMoving() === true',
        constraints: [
            new Assert\Positive(),
        ],
    )]
    #[Assert\When(
        expression: 'this.isIsMoving() === false',
        constraints: [
            new Assert\Blank,
        ],
    )]
    #[ORM\Column]
    private ?bool $isMoving = null;

   
    public function getMotor(): ?string
    {
        return $this->motor;
    }

    public function setMotor(string $motor): static
    {
        $this->motor = $motor;

        return $this;
    }

    public function getRoofHeight(): ?int
    {
        return $this->roofHeight;
    }

    public function setRoofHeight(int $roofHeight): static
    {
        $this->roofHeight = $roofHeight;

        return $this;
    }

    public function isIsMoving(): ?bool
    {
        return $this->isMoving;
    }

    public function setIsMoving(bool $isMoving): static
    {
        $this->isMoving = $isMoving;

        return $this;
    }
}
