<?php

namespace Alura\Cursos\Controller;

use Alura\Cursos\Entity\Usuario;
use Alura\Cursos\Infra\EntityManagerCreator;

class RealizarLogin implements InterfaceControladorRequisicao
{
    private $entityManager;
    private $repositorioDeUsuario;

    public function __construct()
    {
        $this->entityManager = (new EntityManagerCreator())->getEntityManager();
        $this->repositorioDeUsuario = $this->entityManager->getRepository(Usuario::class);
    }

    public function processaRequisicao(): void
    {
        $email = filter_input(
            INPUT_POST,
            'email', 
            FILTER_VALIDATE_EMAIL
        );

        if(is_null($email) || $email === false){
            echo "Email Invalido";
            return;
        }

        $senha = filter_input(
            INPUT_POST,
            'senha', 
            FILTER_SANITIZE_STRING
        );

        /** @var Usuario $usuario */
        $usuario = $this->repositorioDeUsuario->findOneBy(['email' => $email]);

        if(is_null($usuario) || !$usuario->senhaEstaCorreta($senha)){
            echo "E-mail ou Senha invalidos";
            return;
        }

        header('Location: /listar-cursos');
    }

}