<?php

namespace BO;

use DateTime;

class loueur {

    private int $id;
    private string $nom;
    private string $motdepasse;
    private string $pays;
    private string $email;
    private string $numTel;

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getDate(): DateTime
    {
        return $this->date;
    }

    public function setDate(DateTime $date): void
    {
        $this->date = $date;
    }

    public function getNumTel(): string
    {
        return $this->numTel;
    }

    public function setNumTel(string $numTel): void
    {
        $this->numTel = $numTel;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getMotdepasse(): string
    {
        return $this->motdepasse;
    }

    public function setMotdepasse(string $motdepasse): void
    {
        $this->motdepasse = $motdepasse;
    }

    public function getPays(): string
    {
        return $this->pays;
    }

    public function setPays(string $pays): void
    {
        $this->pays = $pays;
    }
    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function getNom(): string {
        return $this->nom;
    }

    public function setNom(string $nom): void {
        $this->nom = $nom;
    }

    public function __construct(int $id, string $nom, string $motdepasse, string $pays, string $email, string $numTel) {
        $this->id = $id;
        $this->nom = $nom;
        $this->motdepasse = $motdepasse;
        $this->pays = $pays;
        $this->email = $email;
        $this->numTel= $numTel;
    }

    public function __toString(): string {
        return "loueur : " . $this->nom . " (" . $this->id . ")";
    }
}