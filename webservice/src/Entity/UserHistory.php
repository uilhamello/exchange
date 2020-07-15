<?php

namespace App\Entity;

use App\Repository\UserHistoryRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserHistoryRepository::class)
 */
class UserHistory
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="userHistories")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Currency::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $currency_from;

    /**
     * @ORM\ManyToOne(targetEntity=Currency::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $currency_to;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $value_from;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $value_to;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCurrencyFrom(): ?Currency
    {
        return $this->currency_from;
    }

    public function setCurrencyFrom(?Currency $currency_from): self
    {
        $this->currency_from = $currency_from;

        return $this;
    }

    public function getCurrencyTo(): ?Currency
    {
        return $this->currency_to;
    }

    public function setCurrencyTo(?Currency $currency_to): self
    {
        $this->currency_to = $currency_to;

        return $this;
    }

    public function getValueFrom(): ?string
    {
        return $this->value_from;
    }

    public function setValueFrom(string $value_from): self
    {
        $this->value_from = $value_from;

        return $this;
    }

    public function getValueTo(): ?string
    {
        return $this->value_to;
    }

    public function setValueTo(string $value_to): self
    {
        $this->value_to = $value_to;

        return $this;
    }
}
