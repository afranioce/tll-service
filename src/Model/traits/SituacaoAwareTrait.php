<?php

namespace App\Model\traits;

trait SituacaoAwareTrait
{
    public function setSituacao(int $situacao): self
    {
        $this->situacao = $situacao;
        return $this;
    }

    public function getSituacao(): int
    {
        return $this->situacao;
    }
}
