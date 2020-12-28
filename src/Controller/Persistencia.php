<?php 

namespace Alura\Cursos\Controller;

use Alura\Cursos\Entity\Curso;
use Alura\Cursos\Infra\EntityManagerCreator;

class Persistencia implements InterfaceControladorRequisicao
{

    /** @var \Doctrine\ORM\EntityManagerInterface */
    private $entityManager;

    public function __construct()
    {
        $this->entityManager = (new EntityManagerCreator())->getEntityManager();
    }

    public function processaRequisicao(): void
    {
        // Preparar dados
        $descricao = filter_input(
            INPUT_POST,
            'descricao',
            FILTER_SANITIZE_STRING);
            
        // Montar modelo curso
        $curso = new Curso();
        $curso->setDescricao($descricao);
        // Inserir no Banco
        $this->entityManager->persist($curso);
        $this->entityManager->flush();

        header('location: /listar-cursos', false, 302);
    }

}