<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Model\BaseEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FuncionarioRepository")
 */
class Funcionario extends BaseEntity
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=200)
     * @ORM\Column(type="string", length=200)
     */
    private $nome;

    /**
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="App\Entity\Departamento", inversedBy="funcionarios")
     * @ORM\JoinColumn(nullable=false)
     */
    private $departamento;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Movimentacao", mappedBy="funcionario")
     */
    private $movimentacoes;

    public function __construct()
    {
        $this->movimentacoes = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): self
    {
        $this->nome = $nome;

        return $this;
    }

    public function getDepartamento(): ?Departamento
    {
        return $this->departamento;
    }

    public function setDepartamento(?Departamento $departamento): self
    {
        $this->departamento = $departamento;

        return $this;
    }

    /**
     * @return Collection|Movimentacao[]
     */
    public function getMovimentacoes(): Collection
    {
        return $this->movimentacoes;
    }

    public function addMovimentacao(Movimentacao $movimentacao): self
    {
        if (!$this->movimentacoes->contains($movimentacao)) {
            $this->movimentacoes[] = $movimentacao;
            $movimentacao->setFuncionario($this);
        }

        return $this;
    }

    public function removeMovimentaco(Movimentacao $movimentacao): self
    {
        if ($this->movimentacoes->contains($movimentacao)) {
            $this->movimentacoes->removeElement($movimentacao);
            // set the owning side to null (unless already changed)
            if ($movimentacao->getFuncionario() === $this) {
                $movimentacao->setFuncionario(null);
            }
        }

        return $this;
    }
}
