<?php
namespace App\Controller;

use App\Form\AddType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function add(Request $request)
    {
        $form = $this->createForm(AddType::class);

        return $this->render("add.html.twig", array(
            'form' => $form->createView(),
        ));
    }

    public function done()
    {

    }
}