<?php

namespace App\Controller;

use App\Entity\Funcionario;
use App\Entity\Movimentacao;
use App\Form\FuncionarioType;
use FOS\RestBundle\View\View;
use Swagger\Annotations as SWG;
use App\Repository\FuncionarioRepository;
use App\Repository\MovimentacaoRepository;
use Nelmio\ApiDocBundle\Annotation as Doc;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as FOSRest;

/**
 * @Route("/api/funcionarios")
 * @SWG\Tag(name="funcionarios")
 */
class FuncionarioController extends FOSRestController
{
    /**
     * Lista de funcionários
     * @FOSRest\Get()
     *
     * @SWG\Response(
     *     response=200,
     *     description="Retorna a lista de funcionários",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Doc\Model(type=Funcionario::class))
     *     )
     * )
     */
    public function index(FuncionarioRepository $funcionarioRepository)
    {
        $funcionarios = $funcionarioRepository->findAll();
        return new View($funcionarios, Response::HTTP_OK);
    }

    /**
     * Cadastrar funcionário
     *
     * @FOSRest\Post()
     *
     * @SWG\Response(
     *     response=200,
     *     description="Retorna o funcionário criado",
     *     @Doc\Model(type=Funcionario::class)
     * )
     * @SWG\Parameter(
     *     name="form",
     *     in="body",
     *     description="Formulário para criar funcionário",
     *     @Doc\Model(type=App\Form\FuncionarioType::class)
     * )
     */
    public function new(Request $request)
    {
        $funcionario = new Funcionario();
        $form = $this->createForm(FuncionarioType::class, $funcionario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($funcionario);
            $em->flush();

            return $funcionario;
        }

        return new View($form->getErrors(), Response::HTTP_BAD_REQUEST);
    }

    /**
     * Ver funcionário
     *
     * @FOSRest\Get("/{id}")
     *
     * @SWG\Response(
     *     response=200,
     *     description="Retorna o funcionário",
     *     @Doc\Model(type=Funcionario::class)
     * )
     */
    public function show(Funcionario $funcionario)
    {
        return $funcionario;
    }

    /**
     * Editar funcionário
     *
     * @FOSRest\Put("/{id}")
     *
     * @SWG\Response(
     *     response=200,
     *     description="Retorna o funcionário editado",
     *     @Doc\Model(type=Funcionario::class)
     * )
     * @SWG\Parameter(
     *     name="form",
     *     in="body",
     *     description="Formulário para editar funcionário",
     *     @Doc\Model(type=App\Form\FuncionarioType::class)
     * )
     */
    public function edit(Request $request, Funcionario $funcionario)
    {
        $form = $this->createForm(FuncionarioType::class, $funcionario, ['method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $funcionario;
        }

        return new View($form->getErrors(), Response::HTTP_BAD_REQUEST);
    }

    /**
     * Excluir funcionário
     *
     * @FOSRest\Delete("/{id}")
     *
     * @SWG\Response(
     *     response=204,
     *     description="Retorna vazio"
     * )
     */
    public function delete(Request $request, Funcionario $funcionario)
    {
        try {
            $em = $this->getDoctrine()->getManager();
            $em->remove($funcionario);
            $em->flush();
    
            return new View(null, Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Listar movimentações do funcionário
     * @FOSRest\Get("/{id}/movimentacoes")
     *
     * @SWG\Response(
     *     response=200,
     *     description="Retorna a lista de movimentações de um funcionário",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Doc\Model(type=Movimentacao::class))
     *     )
     * )
     */
    public function movimentacoes(Funcionario $funcionario, MovimentacaoRepository $movimentacaoRepository)
    {
        $movimentacoes = $movimentacaoRepository->encontrarPorFuncionario($funcionario->getId());
        return new View($movimentacoes, Response::HTTP_OK);
    }

}
