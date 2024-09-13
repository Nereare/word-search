<?php

namespace App\Entity;

use App\Repository\WordRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WordRepository::class)]
class Word
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 64)]
    private ?string $word = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $morph = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $definition = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWord(): ?string
    {
        return $this->word;
    }

    public function setWord(string $word): static
    {
        $this->word = $word;

        return $this;
    }

    public function getMorph(): ?string
    {
        return $this->morph;
    }

    public function setMorph(?string $morph): static
    {
        $this->morph = $morph;

        return $this;
    }

    public function getDefinition(): ?string
    {
        return $this->definition;
    }

    public function setDefinition(string $definition): static
    {
        $this->definition = $definition;

        return $this;
    }
}
