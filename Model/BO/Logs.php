<?php

namespace BO;

class Logs{
    private int $erreurKO;
    private int $erreurTimeouts;
    private DateTime $date;
    private int $loueurId;

    public function __construct(int $erreurKO, int $erreurTimeouts, DateTime $date, int $loueurId)
    {
        $this->erreurKO = $erreurKO;
        $this->erreurTimeouts = $erreurTimeouts;
        $this->date = $date;
        $this->loueurId = $loueurId;
    }

    public function getErreurKO(): int
    {
        return $this->erreurKO;
    }
    public function setErreurKO(int $erreurKO): void
    {
        $this->erreurKO = $erreurKO;
    }
    public function getErreurTimeouts(): int
    {
        return $this->erreurTimeouts;
    }
    public function setErreurTimeouts(int $erreurTimeouts): void
    {
        $this->erreurTimeouts = $erreurTimeouts;
    }
    public function getDate(): DateTime
    {
        return $this->date;
    }
    public function setDate(DateTime $date): void
    {
        $this->date = $date;
    }
    public function getLoueurId(): int
    {
        return $this->loueurId;
    }
    public function setLoueurId(int $loueurId): void
    {
        $this->loueurId = $loueurId;
    }





}