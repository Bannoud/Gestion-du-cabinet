<?php

namespace PatientBundle\Controller;

use PatientBundle\Entity\Patient;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Patient controller.
 *
 * @Route("admin/patient")
 */
class PatientController extends Controller
{
    /**
     * Lists all patient entities.
     *
     * @Route("/", name="admin_patient_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $patients = $em->getRepository('PatientBundle:Patient')->findAll();

        return $this->render('patient/index.html.twig', array(
            'patients' => $patients,
        ));
    }

    /**
     * Creates a new patient entity.
     *
     * @Route("/new", name="admin_patient_new")
     * @Method({"GET", "POST"})
     */

    public function newAction(Request $request)
    {
        $patient = new Patient();
        $form = $this->createForm('PatientBundle\Form\PatientType', $patient, array("validation_groups"=>array('new')));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $file = $patient->getImage();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
                $file->move($this->getParameter('uploads_post_directory'),$fileName);

            $patient->setImage($fileName);

            $em->persist($patient);
            $em->flush();

            $this->addFlash('succes',"Bienvenue ".$patient->getnom()." dans notre system");
            return $this->redirectToRoute('admin_patient_show', array('id' => $patient->getId()));
        }

        return $this->render('patient/new.html.twig', array(
            'patient' => $patient,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a patient entity.
     *
     * @Route("/{id}", name="admin_patient_show")
     * @Method("GET")
     */
    public function showAction(Patient $patient)
    {
        $deleteForm = $this->createDeleteForm($patient);

        return $this->render('patient/show.html.twig', array(
            'patient' => $patient,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing patient entity.
     *
     * @Route("/{id}/edit", name="admin_patient_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Patient $patient)
    {
        $oldPatient = $patient->getImage();
        $deleteForm = $this->createDeleteForm($patient);
        $editForm = $this->createForm('PatientBundle\Form\PatientType', $patient);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            if($patient->getImage() == null){
                $patient->setImage($oldPatient);
            }else{
                
                $file = $patient -> getImage();

                $fileName = md5(uniqid()).'.'.$file->guessExtension();
                $file->move($this->getParameter('uploads_post_directory'),$fileName);

            $patient->setImage($fileName);
            }

            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('succes',"les information de ".$patient->getnom()."  a étè modifiée avec succés");
            return $this->redirectToRoute('admin_patient_show', array('id' => $patient->getId()));
        }

        return $this->render('patient/edit.html.twig', array(
            'patient' => $patient,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a patient entity.
     *
     * @Route("/{id}", name="admin_patient_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Patient $patient)
    {
        $form = $this->createDeleteForm($patient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($patient);
            $em->flush();
        }

        return $this->redirectToRoute('admin_patient_index');
    }

    /**
     * Creates a form to delete a patient entity.
     *
     * @param Patient $patient The patient entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Patient $patient)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_patient_delete', array('id' => $patient->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
