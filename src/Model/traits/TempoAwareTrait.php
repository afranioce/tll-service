<?php

namespace App\Model\traits;

trait TempoAwareTrait
{
    /**
     * Set criadoEm
     */
    public function setCriadoEm(\DateTimeInterface $criadoEm): self
    {
        $this->criadoEm = $criadoEm;

        return $this;
    }

    /**
     * Get criadoEm
     *
     * @return \DateTimeInterface
     */
    public function getCriadoEm(): \DateTimeInterface
    {
        return $this->criadoEm;
    }

    /**
     * Set atualizadoEm
     */
    public function setAtualizadoEm(?\DateTimeInterface $atualizadoEm): self
    {
        $this->atualizadoEm = $atualizadoEm;

        return $this;
    }

    /**
     * Get atualizadoEm
     *
     * @return \DateTimeInterface
     */
    public function getAtualizadoEm(): ?\DateTimeInterface
    {
        return $this->atualizadoEm;
    }
}
