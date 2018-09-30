<?php

namespace PatientBundle\Controller;

use PatientBundle\Entity\metuele;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Metuele controller.
 *
 * @Route("admin/metuele")
 */
class metueleController extends Controller
{
    /**
     * Lists all metuele entities.
     *
     * @Route("/", name="admin_metuele_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $metueles = $em->getRepository('PatientBundle:metuele')->findAll();

        return $this->render('metuele/index.html.twig', array(
            'metueles' => $metueles,
        ));
    }

    /**
     * Creates a new metuele entity.
     *
     * @Route("/new", name="admin_metuele_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $metuele = new Metuele();
        $form = $this->createForm('PatientBundle\Form\metueleType', $metuele);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($metuele);
            $em->flush();

            return $this->redirectToRoute('admin_metuele_show', array('id' => $metuele->getId()));
        }

        return $this->render('metuele/new.html.twig', array(
            'metuele' => $metuele,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a metuele entity.
     *
     * @Route("/{id}", name="admin_metuele_show")
     * @Method("GET")
     */
    public function showAction(metuele $metuele)
    {
        $deleteForm = $this->createDeleteForm($metuele);

        return $this->render('metuele/show.html.twig', array(
            'metuele' => $metuele,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing metuele entity.
     *
     * @Route("/{id}/edit", name="admin_metuele_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, metuele $metuele)
    {
        $deleteForm = $this->createDeleteForm($metuele);
        $editForm = $this->createForm('PatientBundle\Form\metueleType', $metuele);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_metuele_edit', array('id' => $metuele->getId()));
        }

        return $this->render('metuele/edit.html.twig', array(
            'metuele' => $metuele,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a metuele entity.
     *
     * @Route("/{id}", name="admin_metuele_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, metuele $metuele)
    {
        $form = $this->createDeleteForm($metuele);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($metuele);
            $em->flush();
        }

        return $this->redirectToRoute('admin_metuele_index');
    }

    /**
     * Creates a form to delete a metuele entity.
     *
     * @param metuele $metuele The metuele entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(metuele $metuele)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_metuele_delete', array('id' => $metuele->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
