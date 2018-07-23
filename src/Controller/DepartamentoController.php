<?php

namespace App\Controller;

use App\Entity\Departamento;
use App\Form\DepartamentoType;
use App\Repository\DepartamentoRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Nelmio\ApiDocBundle\Annotation as Doc;
use Swagger\Annotations as SWG;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use FOS\RestBundle\Controller\FOSRestController;

/**
 * @Route("/api/departamentos")
 * @SWG\Tag(name="departamentos")
 */
class DepartamentoController extends FOSRestController
{
    /**
     * Lista de departamentos
     * @FOSRest\Get()
     *
     * @SWG\Response(
     *     response=200,
     *     description="Retorna a lista de departamentos",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Doc\Model(type=Departamento::class))
     *     )
     * )
     */
    public function index(DepartamentoRepository $departamentoRepository)
    {
        $departamentos = $departamentoRepository->findAll();
        return new View($departamentos, Response::HTTP_OK);
    }

    /**
     * Cadastrar departamento
     *
     * @FOSRest\Post()
     *
     * @SWG\Response(
     *     response=200,
     *     description="Retorna o departamento criado",
     *     @Doc\Model(type=Departamento::class)
     * )
     * @SWG\Parameter(
     *     name="form",
     *     in="body",
     *     description="Formulário para criar departamento",
     *     @Doc\Model(type=App\Form\DepartamentoType::class)
     * )
     */
    public function new(Request $request)
    {
        $departamento = new Departamento();
        $form = $this->createForm(DepartamentoType::class, $departamento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($departamento);
            $em->flush();

            return $departamento;
        }

        return new View($form->getErrors(), Response::HTTP_BAD_REQUEST);
    }

    /**
     * Ver departamento
     *
     * @FOSRest\Get("/{id}")
     *
     * @SWG\Response(
     *     response=200,
     *     description="Retorna o departamento",
     *     @Doc\Model(type=Departamento::class)
     * )
     */
    public function show(Departamento $departamento)
    {
        return $departamento;
    }

    /**
     * Editar departamento
     *
     * @FOSRest\Put("/{id}")
     *
     * @SWG\Response(
     *     response=200,
     *     description="Retorna o departamento editado",
     *     @Doc\Model(type=Departamento::class)
     * )
     * @SWG\Parameter(
     *     name="form",
     *     in="body",
     *     description="Formulário para editar departamento",
     *     @Doc\Model(type=App\Form\DepartamentoType::class)
     * )
     */
    public function edit(Request $request, Departamento $departamento)
    {
        $form = $this->createForm(DepartamentoType::class, $departamento, ['method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $departamento;
        }

        return new View($form->getErrors(), Response::HTTP_BAD_REQUEST);
    }

    /**
     * Excluir departamento
     *
     * @FOSRest\Delete("/{id}")
     *
     * @SWG\Response(
     *     response=204,
     *     description="Retorna vazio"
     * )
     */
    public function delete(Request $request, Departamento $departamento)
    {
        try {
            $em = $this->getDoctrine()->getManager();
            $em->remove($departamento);
            $em->flush();
    
            return new View(null, Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
