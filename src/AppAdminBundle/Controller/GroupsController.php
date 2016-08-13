<?php

namespace AppAdminBundle\Controller;

use AppBundle\Controller\AbstractAppController;
use AppBundle\Entity\CommandGroup;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;


/**
 * @Route("/groups")
 */
class GroupsController extends AbstractAppController
{
    /**
     * Lists all CommandGroup entities.
     *
     * @Route("/", name="admin_group_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $commandGroups = $em->getRepository('AppBundle:CommandGroup')->findAll();

        return $this->render('commandgroup/index.html.twig', array(
            'commandGroups' => $commandGroups,
        ));
    }

    /**
     * Creates a new CommandGroup entity.
     *
     * @Route("/new", name="admin_group_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $commandGroup = new CommandGroup();
        $form = $this->createForm('AppBundle\Form\CommandGroupType', $commandGroup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($commandGroup);
            $em->flush();

            return $this->redirectToRoute('admin_group_show', array('id' => $commandGroup->getId()));
        }

        return $this->render('commandgroup/new.html.twig', array(
            'commandGroup' => $commandGroup,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a CommandGroup entity.
     *
     * @Route("/{id}", name="admin_group_show")
     * @Method("GET")
     */
    public function showAction(CommandGroup $commandGroup)
    {
        $deleteForm = $this->createDeleteForm($commandGroup);

        return $this->render('commandgroup/show.html.twig', array(
            'commandGroup' => $commandGroup,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing CommandGroup entity.
     *
     * @Route("/{id}/edit", name="admin_group_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, CommandGroup $commandGroup)
    {
        $deleteForm = $this->createDeleteForm($commandGroup);
        $editForm = $this->createForm('AppBundle\Form\CommandGroupType', $commandGroup);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($commandGroup);
            $em->flush();

            return $this->redirectToRoute('admin_group_edit', array('id' => $commandGroup->getId()));
        }

        return $this->render('commandgroup/edit.html.twig', array(
            'commandGroup' => $commandGroup,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a CommandGroup entity.
     *
     * @Route("/{id}", name="admin_group_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, CommandGroup $commandGroup)
    {
        $form = $this->createDeleteForm($commandGroup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($commandGroup);
            $em->flush();
        }

        return $this->redirectToRoute('admin_group_index');
    }

    /**
     * Creates a form to delete a CommandGroup entity.
     *
     * @param CommandGroup $commandGroup The CommandGroup entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CommandGroup $commandGroup)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_group_delete', array('id' => $commandGroup->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}
