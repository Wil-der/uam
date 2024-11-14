<?php

namespace App\Entity;

use App\Repository\ElementoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ElementoRepository::class)]
class Elemento
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column]
    private ?bool $activo = true;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $html = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $css = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $js = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function isActivo(): ?bool
    {
        return $this->activo;
    }

    public function setActivo(bool $activo): static
    {
        $this->activo = $activo;

        return $this;
    }

    public function getHtml(): ?string
    {
        return $this->html;
    }

    public function setHtml(string $html): static
    {
        $this->html = $html;

        return $this;
    }

    public function getCss(): ?string
    {
        return $this->css;
    }

    public function setCss(?string $css): static
    {
        $this->css = $css;

        return $this;
    }

    public function getJs(): ?string
    {
        return $this->js;
    }

    public function setJs(?string $js): static
    {
        $this->js = $js;

        return $this;
    }
}
