<?php

namespace App\Entity;

class Mail
{
    private ?int $id = null;

    private ?int $idUser = null;

    private ?string $toLastname = null;

    private ?string $toFirstname = null;

    private ?string $toEmail = null;

    private ?string $destStatut = null;

    private ?string $content = null;

    private array $attachment = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUser(): ?int
    {
        return $this->idUser;
    }

    public function setIdUser(int $idUser): static
    {
        $this->idUser = $idUser;

        return $this;
    }

    public function getToLastname(): ?string
    {
        return $this->toLastname;
    }

    public function setToLastname(string $toLastname): static
    {
        $this->toLastname = $toLastname;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }
    
    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getToFirstname(): ?string
    {
        return $this->toFirstname;
    }

    public function setToFirstname(string $toFirstname): static
    {
        $this->toFirstname = $toFirstname;

        return $this;
    }

    public function getToEmail(): ?string
    {
        return $this->toEmail;
    }

    public function setToEmail(string $toEmail): static
    {
        $this->toEmail = $toEmail;

        return $this;
    }

    public function getDestStatut(): ?string
    {
        return $this->destStatut;
    }

    public function setDestStatut(string $destStatut): static
    {
        $this->destStatut = $destStatut;

        return $this;
    }

    public function getAttachment(): array
    {
        return $this->attachment;
    }

    public function setAttachment(array $attachment): static
    {
        $this->attachment = $attachment;

        return $this;
    }
}
