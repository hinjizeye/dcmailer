<?php

namespace App\Controller;
use App\Entity\MailEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EmailLogsController extends AbstractController
{
    /**
     * @Route("/email/logs", name="email_logs")
     */
    public function index(): Response
    {
        $emailRepository = $this->getDoctrine()->getRepository(MailEntity::class);
        $emails = $emailRepository -> findAll();

        return $this->render('email_logs/index.html.twig', [
            'controller_name' => 'EmailLogsController',
            'emails'=> $emails
        ]);
    }
}
