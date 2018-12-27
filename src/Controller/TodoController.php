<?php
namespace App\Controller;

use App\Entity\Todo;
use App\Form\AddType;
use App\Repository\TodoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TodoController extends AbstractController
{
    /**
     * @Route("/", name="todo_home")
     */
    public function home(TodoRepository $repository)
    {
        $todos = $repository->findTodos();

        return $this->render('index.html.twig', array(
            'todos' => $todos
        ));
    }

    /**
     * @Route("/add", name="todo_add")
     */
    public function add(Request $request)
    {
        $todo = new Todo();
        $form = $this->createForm(AddType::class, $todo);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $date = new \DateTime();
            $todo->setDate($date);


            $em = $this->getDoctrine()->getManager();

            $em->persist($todo);
            $em->flush();
        }

        return $this->render("add.html.twig", array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/done/{id}", name="todo_done")
     */
    public function done(Todo $todo)
    {
       $em = $this->getDoctrine()->getManager();

       $todo->setDone(true);

       $em->flush();

       return $this->redirectToRoute('todo_home');
    }
}