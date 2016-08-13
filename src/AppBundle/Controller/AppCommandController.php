<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Command;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AppCommandController extends AbstractAppController
{
    /**
     * @Route("/run/{id}",name="command_run")
     */
    public function runAction(Request $request, Command $command)
    {

        $output= '';
        exec($command->getSrc(),$output);

        $this->addFlash(
            'notice',
            $output
        );

        return $this->redirectToRoute('homepage');
    }
}
