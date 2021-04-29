<?php

namespace App\Controller;

use App\Entity\BatchEmail;
use App\Entity\Emails;
use App\Form\BatchEmailType;
use App\Repository\BatchEmailRepository;
use App\Repository\EmailsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Knp\Component\Pager\PaginatorInterface;


/**
 * @Route("/batch/email")
 */
class BatchEmailController extends AbstractController
{
    /**
     * @Route("/", name="batch_email_index", methods={"GET"})
     */
    public function index(Request $request, BatchEmailRepository $batchEmailRepository, PaginatorInterface $paginator): Response
    {
        $emailRepository = $this->getDoctrine()->getRepository(BatchEmail::class);
        $emails = $emailRepository -> findAll();

        $pagination = $paginator->paginate(
            $emails, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            5/*limit per page*/
        );

        return $this->render('batch_email/index.html.twig', [
            'batch_emails' => $pagination
        ]);
    }

    /**
     * @Route("/new", name="batch_email_new", methods={"GET","POST"})
     */
    public function new(Request $request, MailerInterface $mailer, EmailsRepository $emails): Response
    {
        $batchEmail = new BatchEmail();
        $emailSent = new Emails();
        $form = $this->createForm(BatchEmailType::class, $batchEmail);
        $form->handleRequest($request);

        $emailRepository = $this->getDoctrine()->getRepository(Emails::class);
        $emails = $emailSent->getEmail();


        $to = array();

        $addresses = ['zeyesahinji@gmail.com',
                      'mumba.mwandama@dczambia.com',
                      'hope.mutale@dczambia.org',
                      'biasi@quizzito.com',
                      'zeyesa.hinji@dczambia.org'];
    
        $to = $addresses;

    

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($batchEmail);
            $entityManager->flush();
            
            $subject = $batchEmail->getSubject();
            $message = $batchEmail->getMessage();

            $email = (new Email())
                    ->from('"BookNow Zambia" <zeyesa.hinji@dczambia.org>')
                    ->to('francis.chibaye@gmail.com')
                    ->bcc(...$to)
                    ->subject($subject)
                    ->text($message)
                    ->html($message);
        
                $mailer->send($email);
             
   

            return $this->redirectToRoute('batch_email_index');
        }

        return $this->render('batch_email/new.html.twig', [
            'batch_email' => $batchEmail,
            'form' => $form->createView(),
            'emails'=> $emails
        ]);
    }

    /**
     * @Route("/{id}", name="batch_email_show", methods={"GET"})
     */
    public function show(BatchEmail $batchEmail): Response
    {
        return $this->render('batch_email/show.html.twig', [
            'batch_email' => $batchEmail,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="batch_email_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, BatchEmail $batchEmail): Response
    {
        $form = $this->createForm(BatchEmailType::class, $batchEmail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('batch_email_index');
        }

        return $this->render('batch_email/edit.html.twig', [
            'batch_email' => $batchEmail,
            'form' => $form->createView(),
            'email' => $email
        ]);
    }

    /**
     * @Route("/{id}", name="batch_email_delete", methods={"POST"})
     */
    public function delete(Request $request, BatchEmail $batchEmail): Response
    {
        if ($this->isCsrfTokenValid('delete'.$batchEmail->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($batchEmail);
            $entityManager->flush();
        }

        return $this->redirectToRoute('batch_email_index');
    }
}
