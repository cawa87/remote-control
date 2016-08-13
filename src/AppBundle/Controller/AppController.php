<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AppController extends AbstractAppController
{
    /**
     * @Route("/",name="homepage")
     */
    public function indexAction()
    {

        $commandGroups = $this->getDoctrine()->getRepository('AppBundle:CommandGroup')->findAll();


        return $this->render(':default:index.html.twig',[
            'commandGroups' => $commandGroups
        ]);
    }
}
