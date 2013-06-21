<?php

namespace Digitalthoreau\FileBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Digitalthoreau\FileBundle\Entity\File;
use Digitalthoreau\FileBundle\Form\FileType;
use Digitalthoreau\FileBundle\Form\UploadType;

/**
 * File controller.
 *
 * @Route("/file")
 */
class FileController extends Controller
{

    /**
     * Lists all File entities.
     *
     * @Route("/", name="file")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('DigitalthoreauFileBundle:File')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    
    /**
     * Displays a form to create a new File entity.
     *
     * @Route("/new", name="file_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new File();
        $form   = $this->createForm(new FileType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    
    /**
     * Displays a form to create a new File entity.
     *
     * @Route("/upload", name="file_upload")
     * @Method("GET")
     * @Template("DigitalthoreauFileBundle:File:upload.html.twig")
     */
    public function uploadAction()
    {
        $entity = new File();
        $form   = $this->createForm(new UploadType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new File entity.
     *
     * @Route("/", name="file_createupload")
     * @Method("POST")
     * @Template("DigitalthoreauFileBundle:File:upload.html.twig")
     */
    public function createuploadAction(Request $request)
    {
        $entity  = new File();
        $form = $this->createForm(new UploadType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('file_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }    
    
    /**
     * Creates a new File entity.
     *
     * @Route("/", name="file_create")
     * @Method("POST")
     * @Template("DigitalthoreauFileBundle:File:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new File();
        $form = $this->createForm(new FileType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('file_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }


    /**
     * Finds and displays a File entity.
     *
     * @Route("/{id}", name="file_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DigitalthoreauFileBundle:File')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find File entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing File entity.
     *
     * @Route("/{id}/edit", name="file_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DigitalthoreauFileBundle:File')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find File entity.');
        }

        $editForm = $this->createForm(new FileType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing File entity.
     *
     * @Route("/{id}", name="file_update")
     * @Method("PUT")
     * @Template("DigitalthoreauFileBundle:File:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DigitalthoreauFileBundle:File')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find File entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new FileType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('file_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a File entity.
     *
     * @Route("/{id}", name="file_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('DigitalthoreauFileBundle:File')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find File entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('file'));
    }

    /**
     * Creates a form to delete a File entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
    
    /**
     * Finds and displays a File.
     *
     * @Route("/{id}/view", name="file_view")
     * 
     */     
    public function viewAction($id)
	{
                     
             $em = $this->getDoctrine()->getManager();
             $file = $em->getRepository('DigitalthoreauFileBundle:File')->find($id);
             $name = $file->getName();
             $helper = $this->container->get('vich_uploader.templating.helper.uploader_helper');
             $path = $helper->asset($file, 'file');
             $ext = $file->getExt();
             $filename = $name.'.'.$ext;
		
	     $response = new Response();
		
		$response->setStatusCode(200);
                switch ($ext) {
                      case "dtd":
                      $response->headers->set('Content-Type', 'text/xml');
                      $response->headers->set('Content-Disposition', 'attachment;filename="'.$filename.'"');
                      break;
                      case "xsl":
                      $response->headers->set('Content-Type', 'text/xml');
                      $response->headers->set('Content-Disposition', 'attachment;filename="'.$filename.'"');
                      break;
                      case "xml":
                      $response->headers->set('Content-Type', 'text/xml');
                      $response->headers->set('Content-Disposition', 'attachment;filename="'.$filename.'"');
                      break;                  
                      case "png":
                      $response->headers->set('Content-Type', 'image/png');
                      $response->headers->set('Content-Disposition', 'filename="'.$filename.'"');
                      break;
                      case "gif":
                      $response->headers->set('Content-Type', 'image/gif');
                      $response->headers->set('Content-Disposition', 'filename="'.$filename.'"');    
                      break;
                      case "jpeg":
                      $response->headers->set('Content-Type', 'image/jpeg');
                      $response->headers->set('Content-Disposition', 'filename="'.$filename.'"');     
                      break;
                      case "jpg":
                      $response->headers->set('Content-Type', 'image/jpeg');
                      $response->headers->set('Content-Disposition', 'filename="'.$filename.'"');     
                      break;
                      case "odt":
                      $response->headers->set('Content-Type', 'application/vnd.oasis.opendocument.text');
                      $response->headers->set('Content-Disposition', 'attachment; filename="'.$filename.'"');     
                      break;
                      case "ods":
                      $response->headers->set('Content-Type', 'application/vnd.oasis.opendocument.spreadsheet');
                      $response->headers->set('Content-Disposition', 'attachment; filename="'.$filename.'"');     
                      break;
                      case "odp":
                      $response->headers->set('Content-Type', 'application/vnd.oasis.opendocument.presentation');
                      $response->headers->set('Content-Disposition', 'attachment; filename="'.$filename.'"');     
                      break;
                      case "doc":
                      $response->headers->set('Content-Type', 'application/vnd.msword');
                      $response->headers->set('Content-Disposition', 'attachment; filename="'.$filename.'"');     
                      break;
                      case "docx":
                      $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document');
                      $response->headers->set('Content-Disposition', 'attachment; filename="'.$filename.'"');     
                      break;                  
                      case "ppt":
                      $response->headers->set('Content-Type', 'application/vnd.mspowerpoint');
                      $response->headers->set('Content-Disposition', 'attachment; filename="'.$filename.'"');     
                      break;
                      case "pptx":
                      $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.presentationml.presentation');
                      $response->headers->set('Content-Disposition', 'attachment; filename="'.$filename.'"');     
                      break;                  
                      case "xls":
                      $response->headers->set('Content-Type', 'application/vnd.ms-excel');
                      $response->headers->set('Content-Disposition', 'attachment; filename="'.$filename.'"');     
                      break;  
                      case "xlsx":
                      $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                      $response->headers->set('Content-Disposition', 'attachment; filename="'.$filename.'"');     
                      break;                   
                      case "pdf":
                      $response->headers->set('Content-Type', 'application/pdf');
                      $response->headers->set('Content-Disposition', 'attachment; filename="'.$filename.'"');   
                      break;
                      default:
                      $response->headers->set('Content-Type', 'application/octet-stream');    
                      }
		$response->setContent( file_get_contents( $path));
		
		$response->send();
		
		return $response;
	} 
        
        
    /**
     * Finds and displays an XSL transformation of a File entity.
     *
     * @Route("/{xml_id}/{xsl_id}/transform", name="file_transform")
     * @Template()
     */
    public function tranformAction($xml_id,$xsl_id)
    {
             $em = $this->getDoctrine()->getManager();
             $xml_file = $em->getRepository('DigitalthoreauFileBundle:File')->find($xml_id);
             $xml_name = $xml_file->getName();
             $helper = $this->container->get('vich_uploader.templating.helper.uploader_helper');
             $xml_path = $helper->asset($xml_file, 'file');
             
             $xsl_file = $em->getRepository('DigitalthoreauFileBundle:File')->find($xsl_id);
             $xsl_name = $xsl_file->getName();
             $helper = $this->container->get('vich_uploader.templating.helper.uploader_helper');
             $xsl_path = $helper->asset($xsl_file, 'file');             
             

        if (!$xml_file) {
            throw $this->createNotFoundException('Unable to find File entity.');
        }

                $xp = new \XsltProcessor();
                
                $xsl = new \DomDocument;
                $xsl->load($xsl_path);             
                $xp->importStylesheet($xsl);
                
                $xml_doc = new \DomDocument;
                $xml_doc->load($xml_path);
                
                if ($html = $xp->transformToXML($xml_doc)) {
                } else {
                 trigger_error('XSL transformation failed.', E_USER_ERROR);
                }
          
		$response = new Response();		
		$response->setStatusCode(200);
                $response->headers->set('Content-Type', 'text/html');
		$response->setContent( $html );
                return $response;

    }
 
    
}
