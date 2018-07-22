<?php

namespace App\Controller;

use App\Entity\Movimentacao;
use App\Form\MovimentacaoType;
use App\Repository\MovimentacaoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Nelmio\ApiDocBundle\Annotation as Doc;
use Swagger\Annotations as SWG;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use FOS\RestBundle\Controller\FOSRestController;

/**
 * @Route("/api/movimentacoes")
 * @SWG\Tag(name="movimentacoes")
 */
class MovimentacaoController extends Controller
{
    /**
     * Lista de movimentações
     * @FOSRest\Get()
     *
     * @SWG\Response(
     *     response=200,
     *     description="Retorna a lista de movimentações",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Doc\Model(type=Movimentacao::class))
     *     )
     * )
     */
    public function index(MovimentacaoRepository $movimentacaoRepository)
    {
        $movimentacoes = $movimentacaoRepository->findAll();
        return new View($movimentacoes, Response::HTTP_OK);
    }

    /**
     * Cadastrar movimentação
     *
     * @FOSRest\Post()
     *
     * @SWG\Response(
     *     response=200,
     *     description="Retorna o movimentação criado",
     *     @Doc\Model(type=Movimentacao::class)
     * )
     * @SWG\Parameter(
     *     name="form",
     *     in="body",
     *     description="Formulário para criar movimentação",
     *     @Doc\Model(type=App\Form\MovimentacaoType::class)
     * )
     */
    public function new(Request $request)
    {
        $movimentacao = new Movimentacao();
        $form = $this->createForm(MovimentacaoType::class, $movimentacao);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($movimentacao);
            $em->flush();

            return $movimentacao;
        }

        return new View($form->getErrors(), Response::HTTP_BAD_REQUEST);
    }

    /**
     * Ver movimentação
     *
     * @FOSRest\Get("/{id}")
     *
     * @SWG\Response(
     *     response=200,
     *     description="Retorna o movimentação",
     *     @Doc\Model(type=Movimentacao::class)
     * )
     */
    public function show(Movimentacao $movimentacao)
    {
        return $movimentacao;
    }

    /**
     * Editar movimentação
     *
     * @FOSRest\Put("/{id}")
     *
     * @SWG\Response(
     *     response=200,
     *     description="Retorna o movimentação editado",
     *     @Doc\Model(type=Movimentacao::class)
     * )
     * @SWG\Parameter(
     *     name="form",
     *     in="body",
     *     description="Formulário para editar movimentação",
     *     @Doc\Model(type=App\Form\MovimentacaoType::class)
     * )
     */
    public function edit(Request $request, Movimentacao $movimentacao)
    {
        $form = $this->createForm(MovimentacaoType::class, $movimentacao, ['method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $movimentacao;
        }

        return new View($form->getErrors(), Response::HTTP_BAD_REQUEST);
    }

    /**
     * Excluir movimentação
     *
     * @FOSRest\Delete("/{id}")
     *
     * @SWG\Response(
     *     response=204,
     *     description="Retorna vazio"
     * )
     */
    public function delete(Request $request, Movimentacao $movimentacao)
    {
        try {
            $em = $this->getDoctrine()->getManager();
            $em->remove($movimentacao);
            $em->flush();
    
            return new View(null, Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
