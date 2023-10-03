<?php

namespace App\Entity;

use App\Repository\BedRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BedRepository::class)]
class Bed
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $capacity = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\OneToMany(mappedBy: 'bed', targetEntity: RoomDetail::class)]
    private Collection $beds;

    public function __construct()
    {
        $this->beds = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCapacity(): ?int
    {
        return $this->capacity;
    }

    public function setCapacity(int $capacity): static
    {
        $this->capacity = $capacity;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection<int, RoomDetail>
     */
    public function getBeds(): Collection
    {
        return $this->beds;
    }

    public function addBed(RoomDetail $bed): static
    {
        if (!$this->beds->contains($bed)) {
            $this->beds->add($bed);
            $bed->setBed($this);
        }

        return $this;
    }

    public function removeBed(RoomDetail $bed): static
    {
        if ($this->beds->removeElement($bed)) {
            // set the owning side to null (unless already changed)
            if ($bed->getBed() === $this) {
                $bed->setBed(null);
            }
        }

        return $this;
    }
}
