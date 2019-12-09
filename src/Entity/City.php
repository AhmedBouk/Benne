<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CityRepository")
 */
class City
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $department;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $region;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_enbaled;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated_at;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Dumpster", mappedBy="id_city")
     */
    private $id_dumpster;

    public function __construct()
    {
        $this->id_dumpster = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDepartment(): ?string
    {
        return $this->department;
    }

    public function setDepartment(string $department): self
    {
        $this->department = $department;

        return $this;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(string $region): self
    {
        $this->region = $region;

        return $this;
    }

    public function getIsEnbaled(): ?bool
    {
        return $this->is_enbaled;
    }

    public function setIsEnbaled(bool $is_enbaled): self
    {
        $this->is_enbaled = $is_enbaled;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * @return Collection|Dumpster[]
     */
    public function getIdDumpster(): Collection
    {
        return $this->id_dumpster;
    }

    public function addIdDumpster(Dumpster $idDumpster): self
    {
        if (!$this->id_dumpster->contains($idDumpster)) {
            $this->id_dumpster[] = $idDumpster;
            $idDumpster->setIdCity($this);
        }

        return $this;
    }

    public function removeIdDumpster(Dumpster $idDumpster): self
    {
        if ($this->id_dumpster->contains($idDumpster)) {
            $this->id_dumpster->removeElement($idDumpster);
            // set the owning side to null (unless already changed)
            if ($idDumpster->getIdCity() === $this) {
                $idDumpster->setIdCity(null);
            }
        }

        return $this;
    }
}
