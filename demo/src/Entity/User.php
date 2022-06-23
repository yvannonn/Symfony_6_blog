<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity as ConstraintsUniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ConstraintsUniqueEntity(
    fields: 'email',
    message: 'L\' email que vous avez indiqué est déjà utilisé'
)]

class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $username;

    #[ORM\Column(type: 'string', length: 255)]
    private $email;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Length(min: 8, minMessage: 'Votre mot de passe doit faire minimum 8 caractères')]
    #[Assert\EqualTo(propertyPath: 'confirm_password', message: 'Vous n\'avez pas taper le même mot de passe ')]
    private $password;

    #[Assert\Length(min: 8, minMessage: 'Votre mot de passe doit faire minimum 8 caractères')]
    #[Assert\EqualTo(propertyPath: 'password', message: 'Vous n\'avez pas taper le même mot de passe ')]
    public $confirm_password;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function eraseCredentials()
    {
    }

    public function getRoles(): array
    {
        $role[] = 'ROLE_USER';
        return $role;
    }

    public function getSalt(): void
    {
    }
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }
}
