<?php

namespace App\Entity;

use App\Annotation\GuidDependent;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity("aadharCardNumber", message="User already exists")
 * @GuidDependent()
 * @Vich\Uploadable()
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\Column(type="json")
     */
    private $roles = ["ROLE_USER"];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\NotNull(message = "Choose a valid genre.")
     * @Assert\NotBlank(message = "Choose a valid genre.")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull()
     */
    private $contactNumber;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull()
     */
    private $aadharCardNumber;

    /**
     * @ORM\Column(type="guid")
     */
    private $guid;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotNull(groups={"personal-details-validation"})
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $middleName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $district;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $taluka;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $village;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $gender;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $caste;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $profilePic;

    /**
     * @ORM\Column(name="aadhar_card_photo",type="string", length=255, nullable=true)
     */
    private $aadharCardPhoto;

    /**
     * @Vich\UploadableField(mapping="aadhar_card",fileNameProperty="aadhar_card_photo")
     * @var File
     */
    private $aadharCardFile;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->aadharCardNumber;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getContactNumber(): ?string
    {
        return $this->contactNumber;
    }

    public function setContactNumber(string $contactNumber): self
    {
        $this->contactNumber = $contactNumber;

        return $this;
    }

    public function getAadharCardNumber(): ?string
    {
        return $this->aadharCardNumber;
    }

    public function setAadharCardNumber(string $aadharCardNumber): self
    {
        $this->aadharCardNumber = $aadharCardNumber;

        return $this;
    }

    public function getGuid(): ?string
    {
        return $this->guid;
    }

    public function setGuid(string $guid): self
    {
        $this->guid = $guid;

        return $this;
    }
    public function getGuidPrefix()
    {
        return 'user';
    }

    public function getGuidLength()
    {
        return 24;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getMiddleName(): ?string
    {
        return $this->middleName;
    }

    public function setMiddleName(?string $middleName): self
    {
        $this->middleName = $middleName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getDistrict(): ?string
    {
        return $this->district;
    }

    public function setDistrict(?string $district): self
    {
        $this->district = $district;

        return $this;
    }

    public function getTaluka(): ?string
    {
        return $this->taluka;
    }

    public function setTaluka(?string $taluka): self
    {
        $this->taluka = $taluka;

        return $this;
    }

    public function getVillage(): ?string
    {
        return $this->village;
    }

    public function setVillage(?string $village): self
    {
        $this->village = $village;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(?string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getCaste(): ?string
    {
        return $this->caste;
    }

    public function setCaste(?string $caste): self
    {
        $this->caste = $caste;

        return $this;
    }

    public function getProfilePic(): ?string
    {
        return $this->profilePic;
    }

    public function setProfilePic(?string $profilePic): self
    {
        $this->profilePic = $profilePic;

        return $this;
    }

    public function getAadharCardPhoto(): ?string
    {
        return $this->aadharCardPhoto;
    }

    public function setAadharCardPhoto(?string $aadharCardPhoto): self
    {
        $this->aadharCardPhoto = $aadharCardPhoto;

        return $this;
    }


    /**
     * @param File|null $image
     * @return User
     */
    public function setAadharCardFile(File $image = null)
    {
        $this->aadharCardFile = $image;

        return $this;
    }

    public function getAadharCardFile()
    {
        return $this->aadharCardFile;
    }
}
