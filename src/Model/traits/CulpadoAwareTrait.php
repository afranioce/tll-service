<?php

namespace App\Model\traits;

use FOS\UserBundle\Model\UserInterface;

trait CulpadoAwareTrait
{
    public function getCriadoPor(): UserInterface
    {
        return $this->criadoPor;
    }

    public function setCriadoPor(UserInterface $usuario): self
    {
        $this->criadoPor = $usuario;

        return $this;
    }

    public function getAtualizadoPor(): ?UserInterface
    {
        return $this->atualizadoPor;
    }

    public function setAtualizadoPor(?UserInterface $usuario): self
    {
        $this->atualizadoPor = $usuario;

        return $this;
    }
}
