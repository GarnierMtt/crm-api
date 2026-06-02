<?php

namespace App\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Attribute\Context;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use App\Repository\CriticitesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CriticitesRepository::class)]
#[Gedmo\Loggable]
class Criticites
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    /**
     * @var Collection<int, Incidents>
     */
    #[ORM\OneToMany(targetEntity: Incidents::class, mappedBy: 'fk_criticites')]
    private Collection $fk_incidents;

    public function __construct()
    {
        $this->fk_incidents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection<int, Incidents>
     */
    #[Context([AbstractNormalizer::ATTRIBUTES => ['fkIncidents' => ['id', 'titre']]])]
    public function getFkIncidents(): Collection
    {
        return $this->fk_incidents;
    }

    public function addFkIncident(Incidents $fkIncident): static
    {
        if (!$this->fk_incidents->contains($fkIncident)) {
            $this->fk_incidents->add($fkIncident);
            $fkIncident->setFkCriticites($this);
        }

        return $this;
    }

    public function removeFkIncident(Incidents $fkIncident): static
    {
        if ($this->fk_incidents->removeElement($fkIncident)) {
            // set the owning side to null (unless already changed)
            if ($fkIncident->getFkCriticites() === $this) {
                $fkIncident->setFkCriticites(null);
            }
        }

        return $this;
    }
}
