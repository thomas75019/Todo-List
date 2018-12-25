<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TodoController extends AbstractController
{
    /**
     * @Route("/", name="todo_homel")
     */
    public function home()
    {
        return $this->render('index.html.twig');
    }

    /**
     * @Route("/add", name="todo_add")
     */
    public function add()
    {
        return $this->render("add.html.twig");
    }

    public function done()
    {

    }
}