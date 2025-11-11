<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
#[ORM\Table(name: 'utilisateur')]
class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $nom = null;

    #[ORM\Column(length: 50)]
    private ?string $prenom = null;

    #[ORM\Column(length: 50, unique: true)]
    private ?string $mail = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $telephone = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $adresse = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateNaissance = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photo = null;

    #[ORM\Column(length: 50, unique: true)]
    private ?string $pseudo = null;

    #[ORM\Column]
    private ?int $credit = 20;

    /**
     * @var Collection<int, Voiture>
     */
    #[ORM\OneToMany(targetEntity: Voiture::class, mappedBy: 'utilisateur', orphanRemoval: true)]
    private Collection $voitures;

    /**
     * @var Collection<int, Covoiturage>
     */
    #[ORM\OneToMany(targetEntity: Covoiturage::class, mappedBy: 'chauffeur')]
    private Collection $covoituragesConduits;

    /**
     * @var Collection<int, Covoiturage>
     */
    #[ORM\ManyToMany(targetEntity: Covoiturage::class, inversedBy: 'passagers')]
    private Collection $covoituragesParticipes;

    /**
     * @var Collection<int, Avis>
     */
    #[ORM\OneToMany(targetEntity: Avis::class, mappedBy: 'utilisateur')]
    private Collection $avisDonnes;

    /**
     * @var Collection<int, Avis>
     */
    #[ORM\OneToMany(targetEntity: Avis::class, mappedBy: 'destinataire')]
    private Collection $avisRecus;

    #[ORM\ManyToOne(inversedBy: 'utilisateurs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Role $roles = null;

    /**
     * @var Collection<int, Configuration>
     */
    #[ORM\OneToMany(targetEntity: Configuration::class, mappedBy: 'utilisateur', orphanRemoval: true)]
    private Collection $configurations;

    public function __construct()
    {
        $this->voitures = new ArrayCollection();
        $this->covoituragesConduits = new ArrayCollection();
        $this->covoituragesParticipes = new ArrayCollection();
        $this->avisDonnes = new ArrayCollection();
        $this->avisRecus = new ArrayCollection();
        $this->configurations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): static
    {
        $this->mail = $mail;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): static
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(?\DateTimeInterface $dateNaissance): static
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): static
    {
        $this->photo = $photo;

        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): static
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getCredit(): ?int
    {
        return $this->credit;
    }

    public function setCredit(int $credit): static
    {
        $this->credit = $credit;

        return $this;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->mail;
    }

    public function eraseCredentials(): void {
        // No temporary sensitive data to clear
    }

    /**
     * @return Collection<int, Voiture>
     */
    public function getVoitures(): Collection
    {
        return $this->voitures;
    }

    public function addVoiture(Voiture $voiture): static
    {
        if (!$this->voitures->contains($voiture)) {
            $this->voitures->add($voiture);
            $voiture->setUtilisateur($this);
        }

        return $this;
    }

    public function removeVoiture(Voiture $voiture): static
    {
        if ($this->voitures->removeElement($voiture)) {
            // set the owning side to null (unless already changed)
            if ($voiture->getUtilisateur() === $this) {
                $voiture->setUtilisateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Covoiturage>
     */
    public function getCovoituragesConduits(): Collection
    {
        return $this->covoituragesConduits;
    }

    public function addCovoituragesConduit(Covoiturage $covoituragesConduit): static
    {
        if (!$this->covoituragesConduits->contains($covoituragesConduit)) {
            $this->covoituragesConduits->add($covoituragesConduit);
            $covoituragesConduit->setChauffeur($this);
        }

        return $this;
    }

    public function removeCovoituragesConduit(Covoiturage $covoituragesConduit): static
    {
        if ($this->covoituragesConduits->removeElement($covoituragesConduit)) {
            // set the owning side to null (unless already changed)
            if ($covoituragesConduit->getChauffeur() === $this) {
                $covoituragesConduit->setChauffeur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Covoiturage>
     */
    public function getCovoituragesParticipes(): Collection
    {
        return $this->covoituragesParticipes;
    }

    public function addCovoituragesParticipe(Covoiturage $covoituragesParticipe): static
    {
        if (!$this->covoituragesParticipes->contains($covoituragesParticipe)) {
            $this->covoituragesParticipes->add($covoituragesParticipe);
        }

        return $this;
    }

    public function removeCovoituragesParticipe(Covoiturage $covoituragesParticipe): static
    {
        $this->covoituragesParticipes->removeElement($covoituragesParticipe);

        return $this;
    }

    /**
     * @return Collection<int, Avis>
     */
    public function getAvisDonnes(): Collection
    {
        return $this->avisDonnes;
    }

    public function addAvisDonne(Avis $avisDonne): static
    {
        if (!$this->avisDonnes->contains($avisDonne)) {
            $this->avisDonnes->add($avisDonne);
            $avisDonne->setUtilisateur($this);
        }

        return $this;
    }

    public function removeAvisDonne(Avis $avisDonne): static
    {
        if ($this->avisDonnes->removeElement($avisDonne)) {
            // set the owning side to null (unless already changed)
            if ($avisDonne->getUtilisateur() === $this) {
                $avisDonne->setUtilisateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Avis>
     */
    public function getAvisRecus(): Collection
    {
        return $this->avisRecus;
    }

    public function addAvisRecu(Avis $avisRecu): static
    {
        if (!$this->avisRecus->contains($avisRecu)) {
            $this->avisRecus->add($avisRecu);
            $avisRecu->setDestinataire($this);
        }

        return $this;
    }

    public function removeAvisRecu(Avis $avisRecu): static
    {
        if ($this->avisRecus->removeElement($avisRecu)) {
            // set the owning side to null (unless already changed)
            if ($avisRecu->getDestinataire() === $this) {
                $avisRecu->setDestinataire(null);
            }
        }

        return $this;
    }

    public function getRole(): ?Role
    {
        return $this->roles;
    }

    /**
     * Returne les rôles de l'utilisateur pour le système de sécurité
     *
     * @return string[]
     */
    public function getRoles(): array
    {
        $roles = [];
        foreach ($this->roles as $role) {
            $roles[] = $role->getLibelle();
        }
        return $roles;
    }

    public function setRole(?Role $role): static
    {
        $this->roles = $role;

        return $this;
    }

    /**
     * @return Collection<int, Configuration>
     */
    public function getConfigurations(): Collection
    {
        return $this->configurations;
    }

    public function addConfiguration(Configuration $configuration): static
    {
        if (!$this->configurations->contains($configuration)) {
            $this->configurations->add($configuration);
            $configuration->setUtilisateur($this);
        }

        return $this;
    }

    public function removeConfiguration(Configuration $configuration): static
    {
        if ($this->configurations->removeElement($configuration)) {
            // set the owning side to null (unless already changed)
            if ($configuration->getUtilisateur() === $this) {
                $configuration->setUtilisateur(null);
            }
        }

        return $this;
    }
}
