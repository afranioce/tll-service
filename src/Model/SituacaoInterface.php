<?php

namespace App\Model;

interface SituacaoInterface
{
    const SITUACAO_INATIVO = 0;
    const SITUACAO_ATIVO = 1;

    public function setSituacao(int $situacao);
    public function getSituacao();
    public function getSituacaoLista();
}
