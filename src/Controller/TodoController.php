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
     * @Route("/", methods={"GET"}, name="todo_home")
     */
    public function home(TodoRepository $repository)
    {
        $todos = $repository->findTodos();


        return $this->render('index.html.twig', array(
            'todos' => $todos
        ));
    }

    /**
     * @Route("/add",  name="todo_add")
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
            $todo->setDone(false);


            $em = $this->getDoctrine()->getManager();

            $em->persist($todo);
            $em->flush();

            return $this->redirectToRoute('todo_home');
        }

        return $this->render("add.html.twig", array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/done/{id}", methods={"POST"}, name="todo_done")
     */
    public function done(Todo $todo)
    {
       $em = $this->getDoctrine()->getManager();

       $todo->setDone(true);

       $em->flush();

       return $this->redirectToRoute('todo_home');
    }

    /**
     * @Route("/viewDone", methods={"GET"}, name="todo_done_view")
     */
    public function viewDone(TodoRepository $repository)
    {
        $todos = $repository->findBy(array('done' => true));

        return $this->render('done.html.twig', array(
            'todos' => $todos
        ));
    }

    /**
     * @Route("/purge", methods={"POST"}, name="todo_purge")
     */
    public function purge(TodoRepository $repository, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $todos = $repository->findBy(array('done' => true));

        if ( null === $todos)
        {
            return $this->redirectToRoute('todo_done_view');
        }

        foreach ($todos as $todo)
        {
            $em->remove($todo);
        }
        $em->flush();

        $this->addFlash('success', 'Les Todos faient ont étés purgés');

        return $this->redirectToRoute('todo_done_view');

    }
}