<?php

namespace App\Entity;

use Assert\Length;
use Assert\NotBlank;
use ReflectionClass;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\LocationRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\InheritanceType('JOINED')]
#[ORM\DiscriminatorColumn(name: 'locationType', type: 'string')]
#[ORM\DiscriminatorMap(['treeHouse' => TreeHouse::class, 'house' => House::class, 'appart' => Appart::class, 'boat' => Boat::class])]
#[ORM\Entity(repositoryClass: LocationRepository::class)]
abstract class Location
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[NotBlank(message: "L'adresse  est requise.")]
    #[Length(min: 10, maxMessage: "L'adresse doit faire au moins {{ limit }} caractères.")]
    #[ORM\Column(length: 255)]
    private ?string $address = null;



    #[ORM\Column]
    private ?int $nbrRoom = null;

    #[Assert\NotBlank(message: "Une description est requise.")]
    #[Assert\Length(min: 10, maxMessage: "La description ne doit pas dépasser {{ limit }} caractères.")]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $nightPrice = null;

    #[ORM\Column]
    private ?int $area = null;

    #[ORM\Column]
    private ?int $longitude = null;

    #[ORM\Column]
    private ?int $latitude = null;

    #[ORM\Column(length: 255)]
    private ?string $city = null;

    #[ORM\ManyToOne(inversedBy: 'locations')]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'location', targetEntity: Booking::class)]
    private Collection $bookings;

    #[ORM\OneToMany(mappedBy: 'location', targetEntity: Room::class)]
    private Collection $rooms;

   
    
    private ?\DateTimeInterface $dateStart = null;

    #[Assert\GreaterThan(propertyPath:"beginDate", message:"Error")]
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\GreaterThan('today UTC')]
    private ?\DateTimeInterface $dateEnd = null;

    public function __construct()
    {
        $this->bookings = new ArrayCollection();
        $this->rooms = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }
    /* permet de recuper typelocation */
    public function getClassName(){
        $class = new ReflectionClass($this);
         
        return $class->getShortName();
     }

    public function getNbrRoom(): ?int
    {
        return $this->nbrRoom;
    }

    public function setNbrRoom(int $nbrRoom): static
    {
        $this->nbrRoom = $nbrRoom;

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

    public function getNightPrice(): ?int
    {
        return $this->nightPrice;
    }

    public function setNightPrice(int $nightPrice): static
    {
        $this->nightPrice = $nightPrice;

        return $this;
    }

    public function getArea(): ?int
    {
        return $this->area;
    }

    public function setArea(int $area): static
    {
        $this->area = $area;

        return $this;
    }

    public function getLongitude(): ?int
    {
        return $this->longitude;
    }

    public function setLongitude(int $longitude): static
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getLatitude(): ?int
    {
        return $this->latitude;
    }

    public function setLatitude(int $latitude): static
    {
        $this->latitude = $latitude;

        return $this;
    }



    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Booking>
     */
    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    public function addBooking(Booking $booking): static
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings->add($booking);
            $booking->setLocation($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): static
    {
        if ($this->bookings->removeElement($booking)) {
            // set the owning side to null (unless already changed)
            if ($booking->getLocation() === $this) {
                $booking->setLocation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Room>
     */
    public function getRooms(): Collection
    {
        return $this->rooms;
    }

    public function addRoom(Room $room): static
    {
        if (!$this->rooms->contains($room)) {
            $this->rooms->add($room);
            $room->setLocation($this);
        }

        return $this;
    }

    public function removeRoom(Room $room): static
    {
        if ($this->rooms->removeElement($room)) {
            // set the owning side to null (unless already changed)
            if ($room->getLocation() === $this) {
                $room->setLocation(null);
            }
        }

        return $this;
    }


    public function getDateStart(): ?\DateTimeInterface
    {
        return $this->dateStart;
    }

    public function setDateStart(\DateTimeInterface $dateStart): static
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    public function getDateEnd(): ?\DateTimeInterface
    {
        return $this->dateEnd;
    }

    public function setDateEnd(\DateTimeInterface $dateEnd): static
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    public function getTotalCapacity(): int
    {
        $capacity = 0;
          foreach ($this->getRooms() as $room) {
          foreach ($room->getRoomDetails() as $detail) {
                $capacity += ($detail->getQuantity() * $detail->getBed()?->getCapacity());
            
        } 
    }
        
        return $capacity;
    }

}
