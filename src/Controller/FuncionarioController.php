<?php

namespace App\Controller;

use App\Entity\Funcionario;
use App\Form\FuncionarioType;
use App\Repository\FuncionarioRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use FOS\RestBundle\Controller\FOSRestController;

/**
 * @Route("/api/funcionarios")
 * @SWG\Tag(name="funcionarios")
 */
class FuncionarioController extends FOSRestController
{
    /**
     * Lista de funcionarios
     * @FOSRest\Get()
     *
     * @SWG\Response(
     *     response=200,
     *     description="Retorna a lista de funcionários",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=Funcionario::class, groups={"full"}))
     *     )
     * )
     */
    public function index(FuncionarioRepository $funcionarioRepository)
    {
        $funcionarios = $funcionarioRepository->findAll();
        return new View($funcionarios, Response::HTTP_OK);
    }

    /**
     * @FOSRest\Post()
     *
     * @SWG\Response(
     *     response=200,
     *     description="Retorna o funcionário criado",
     *     @Model(type=Funcionario::class)
     * )
     */
    public function new(Request $request)
    {
        $funcionario = new Funcionario();
        $form = $this->createForm(FuncionarioType::class, $funcionario);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($funcionario);
            $em->flush();

            return $funcionario;
        }

        return new View($form->getErrors(), Response::HTTP_BAD_REQUEST);
    }

    /**
     * @FOSRest\Get("/{id}")
     *
     * @SWG\Response(
     *     response=200,
     *     description="Retorna o funcionário",
     *     @Model(type=Funcionario::class)
     * )
     */
    public function show(Funcionario $funcionario)
    {
        return $funcionario;
    }

    /**
     * @FOSRest\Put("/{id}")
     * @SWG\Response(
     *     response=200,
     *     description="Retorna o funcionário editado",
     *     @Model(type=Funcionario::class)
     * )
     */
    public function edit(Request $request, Funcionario $funcionario)
    {
        $form = $this->createForm(FuncionarioType::class, $funcionario);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $funcionario;
        }

        return new View($form->getErrors(), Response::HTTP_BAD_REQUEST);
    }

    /**
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
}
