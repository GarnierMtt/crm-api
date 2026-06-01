<?php

namespace App\Entity;

use App\Repository\IncidentsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IncidentsRepository::class)]
class Incidents
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $statut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $date_detection = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $date_resolution = null;

    #[ORM\ManyToOne(inversedBy: 'fk_incidents')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Criticites $fk_criticites = null;

    #[ORM\ManyToOne(inversedBy: 'fk_incidents')]
    private ?LiensFibre $fk_liens_fibre = null;

    #[ORM\ManyToOne(inversedBy: 'fk_incidents')]
    private ?Materiels $fk_materiels = null;

    /**
     * @var Collection<int, Utilisateurs>
     */
    #[ORM\ManyToMany(targetEntity: Utilisateurs::class, inversedBy: 'fk_incidents')]
    private Collection $fk_utilisateurs;

    public function __construct()
    {
        $this->fk_utilisateurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): static
    {
        $this->statut = $statut;

        return $this;
    }

    public function getDateDetection(): ?\DateTime
    {
        return $this->date_detection;
    }

    public function setDateDetection(\DateTime $date_detection): static
    {
        $this->date_detection = $date_detection;

        return $this;
    }

    public function getDateResolution(): ?\DateTime
    {
        return $this->date_resolution;
    }

    public function setDateResolution(?\DateTime $date_resolution): static
    {
        $this->date_resolution = $date_resolution;

        return $this;
    }

    public function getFkCriticites(): ?Criticites
    {
        return $this->fk_criticites;
    }

    public function setFkCriticites(?Criticites $fk_criticites): static
    {
        $this->fk_criticites = $fk_criticites;

        return $this;
    }

    public function getFkLiensFibre(): ?LiensFibre
    {
        return $this->fk_liens_fibre;
    }

    public function setFkLiensFibre(?LiensFibre $fk_liens_fibre): static
    {
        $this->fk_liens_fibre = $fk_liens_fibre;

        return $this;
    }

    public function getFkMateriels(): ?Materiels
    {
        return $this->fk_materiels;
    }

    public function setFkMateriels(?Materiels $fk_materiels): static
    {
        $this->fk_materiels = $fk_materiels;

        return $this;
    }

    /**
     * @return Collection<int, Utilisateurs>
     */
    public function getFkUtilisateurs(): Collection
    {
        return $this->fk_utilisateurs;
    }

    public function addFkUtilisateur(Utilisateurs $fkUtilisateur): static
    {
        if (!$this->fk_utilisateurs->contains($fkUtilisateur)) {
            $this->fk_utilisateurs->add($fkUtilisateur);
        }

        return $this;
    }

    public function removeFkUtilisateur(Utilisateurs $fkUtilisateur): static
    {
        $this->fk_utilisateurs->removeElement($fkUtilisateur);

        return $this;
    }
}
