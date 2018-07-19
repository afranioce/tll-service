<?php

namespace App\Model;

use App\Model\SituacaoInterface;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use App\Model\traits\CulpadoAwareTrait;
use App\Model\traits\SituacaoAwareTrait;
use App\Model\traits\TempoAwareTrait;

/**
 * @ORM\MappedSuperclass
 */
abstract class BaseEntity implements SituacaoInterface
{
    use SituacaoAwareTrait;
    use TempoAwareTrait;
    use CulpadoAwareTrait;

    /**
     * @ORM\Column(name="status", type="smallint", options={"default"=1})
     */
    protected $situacao = SituacaoInterface::SITUACAO_ATIVO;

    /**
     * @ORM\Column(type="datetime", options={"default"="CURRENT_TIMESTAMP"})
     */
    protected $criadoEm;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $atualizadoEm;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Usuario", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @JMS\Exclude()
     */
    protected $criadoPor;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Usuario", cascade={"persist"})
     * @JMS\Exclude()
     */
    protected $atualizadoPor;

    public function getSituacaoLista() : array
    {
        return [
            SituacaoInterface::SITUACAO_ATIVO => 'ativo',
            SituacaoInterface::SITUACAO_INATIVO => 'inativo'
        ];
    }
}
