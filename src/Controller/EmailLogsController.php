<?php

namespace App\Controller;
use App\Entity\MailEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;


class EmailLogsController extends AbstractController
{
    /**
     * @Route("/email/logs", name="email_logs")
     */
    public function index(PaginatorInterface $paginator): Response
    {
        $emailRepository = $this->getDoctrine()->getRepository(MailEntity::class);
        $emails = $emailRepository -> findAll();

        $pagination = $paginator->paginate(
            $emails, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            1/*limit per page*/
        );

        return $this->render('email_logs/index.html.twig', [
            'controller_name' => 'EmailLogsController',
            'emails'=> $pagination
        ]);
    }
}
