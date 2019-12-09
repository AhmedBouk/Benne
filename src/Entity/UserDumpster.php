<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserDumpsterRepository")
 */
class UserDumpster
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private $id_user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Dumpster")
     */
    private $id_dumpster;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUser(): ?User
    {
        return $this->id_user;
    }

    public function setIdUser(?User $id_user): self
    {
        $this->id_user = $id_user;

        return $this;
    }

    public function getIdDumpster(): ?Dumpster
    {
        return $this->id_dumpster;
    }

    public function setIdDumpster(?Dumpster $id_dumpster): self
    {
        $this->id_dumpster = $id_dumpster;

        return $this;
    }
}
