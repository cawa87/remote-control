<?php

namespace AppAdminBundle\Controller;

use AppBundle\Controller\AbstractAppController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Command;
use AppBundle\Form\CommandType;

/**
 * Command controller.
 *
 * @Route("/command")
 */
class CommandController extends AbstractAppController
{
    /**
     * Lists all Command entities.
     *
     * @Route("/", name="admin_command_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $commands = $em->getRepository('AppBundle:Command')->findAll();

        return $this->render('command/index.html.twig', array(
            'commands' => $commands,
        ));
    }

    /**
     * Creates a new Command entity.
     *
     * @Route("/new", name="admin_command_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $command = new Command();
        $form = $this->createForm('AppBundle\Form\CommandType', $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($command);
            $em->flush();

            return $this->redirectToRoute('admin_command_show', array('id' => $command->getId()));
        }

        return $this->render('command/new.html.twig', array(
            'command' => $command,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Command entity.
     *
     * @Route("/{id}", name="admin_command_show")
     * @Method("GET")
     */
    public function showAction(Command $command)
    {
        $deleteForm = $this->createDeleteForm($command);

        return $this->render('command/show.html.twig', array(
            'command' => $command,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Command entity.
     *
     * @Route("/{id}/edit", name="admin_command_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Command $command)
    {
        $deleteForm = $this->createDeleteForm($command);
        $editForm = $this->createForm('AppBundle\Form\CommandType', $command);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($command);
            $em->flush();

            return $this->redirectToRoute('admin_command_edit', array('id' => $command->getId()));
        }

        return $this->render('command/edit.html.twig', array(
            'command' => $command,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Command entity.
     *
     * @Route("/{id}", name="admin_command_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Command $command)
    {
        $form = $this->createDeleteForm($command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($command);
            $em->flush();
        }

        return $this->redirectToRoute('admin_command_index');
    }

    /**
     * Creates a form to delete a Command entity.
     *
     * @param Command $command The Command entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Command $command)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_command_delete', array('id' => $command->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Test Command src.
     *
     * @Route("/test/{id}", name="admin_command_test")
     * @Method("GET")
     * @Template(":command:test.html.twig")
     */
    public function testAction(Command $command)
    {

        $output= '';
        exec($command->getSrc(),$output);


        return [
            'output' => $output
        ];
    }
}
