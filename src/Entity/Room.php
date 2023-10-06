<?php

namespace App\Entity;

use App\Repository\RoomRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RoomRepository::class)]
class Room
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'room', targetEntity: RoomDetail::class, cascade:['persist'])]
    private Collection $roomDetails;

    #[ORM\ManyToOne(inversedBy: 'rooms')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Location $location = null;

    public function __construct()
    {
        $this->roomDetails = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, RoomDetail>
     */
    public function getRoomDetails(): Collection
    {
        return $this->roomDetails;
    }

    public function addRoomDetail(RoomDetail $roomDetail): static
    {
        if (!$this->roomDetails->contains($roomDetail)) {
            $this->roomDetails->add($roomDetail);
            $roomDetail->setRoom($this);
        }

        return $this;
    }

    public function removeRoomDetail(RoomDetail $roomDetail): static
    {
        if ($this->roomDetails->removeElement($roomDetail)) {
            // set the owning side to null (unless already changed)
            if ($roomDetail->getRoom() === $this) {
                $roomDetail->setRoom(null);
            }
        }

        return $this;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): static
    {
        $this->location = $location;

        return $this;
    }
}
