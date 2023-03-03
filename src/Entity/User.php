<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

#[ORM\Table('users')]
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity('username')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[NotBlank]
    #[Regex('/^\w{3,180}$/')]
    private ?string $username = null;

    #[ORM\Column]
    private array $roles = ['ROLE_USER'];

    #[ORM\Column]
    #[NotBlank]
    #[Regex('/^.{3,180}$/')]
    private ?string $password = null;

    private $plainPassword;

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getUsername(): string
    {
        return (string) $this->username;
    }
    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }
    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';
        return array_unique($roles);
    }
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;
        return $this;
    }
    public function getPassword(): string
    {
        return $this->password;
    }
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }
    public function getSalt(): ?string
    {
        return null;
    }
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
	public function getPlainPassword() 
    {
		return $this->plainPassword;
	}
	public function setPlainPassword($plainPassword): self 
    {
		$this->plainPassword = $plainPassword;
		return $this;
	}
}