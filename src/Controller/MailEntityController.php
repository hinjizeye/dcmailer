<?php

namespace App\Controller;
use App\Entity\MailEntity;
use App\Entity\Emails;
use App\Form\MailEntityType;
use App\Repository\MailEntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Swift_Mailer;

/**
 * @Route("/mail/entity")
 */
class MailEntityController extends AbstractController
{
    /**
     * @Route("/", name="mail_entity_index", methods={"GET"})
     */
    public function index(Request $request, MailEntityRepository $mailEntityRepository, PaginatorInterface $paginator): Response
    {
        $emailRepository = $this->getDoctrine()->getRepository(MailEntity::class);
        $emails = $emailRepository -> findAll();

        $pagination = $paginator->paginate(
            $emails, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            5/*limit per page*/
        );
        return $this->render('mail_entity/index.html.twig', [
            'mail_entities' => $pagination
        ]);
    }

    /**
     * @Route("/new", name="mail_entity_new", methods={"GET","POST"})
     */
public function new(Request $request, MailerInterface $mailer): Response
    {
        $mailEntity = new MailEntity();
        $emails = new Emails();
        $form = $this->createForm(MailEntityType::class, $mailEntity);
        $form->handleRequest($request);



        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($mailEntity);
            $entityManager->flush();

            $subject = $mailEntity->getSubject();
            $message = $mailEntity->getMessage();
            $email = $mailEntity->getEmail();

            
        
            $Email =  (new Email())
            ->from('zeyesa.hinji@dczambia.org')
            ->to($email)
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject($subject)
            ->text($message)
            ->html($message);

        $mailer->send($Email);
        
    
         return $this->redirectToRoute('mail_entity_index');
        }

        return $this->render('mail_entity/new.html.twig', [
            'mail_entity' => $mailEntity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="mail_entity_show", methods={"GET"})
     */
    public function show(MailEntity $mailEntity): Response
    {
        return $this->render('mail_entity/show.html.twig', [
            'mail_entity' => $mailEntity,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="mail_entity_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, MailEntity $mailEntity): Response
    {
        $form = $this->createForm(MailEntityType::class, $mailEntity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('mail_entity_index');
        }

        return $this->render('mail_entity/edit.html.twig', [
            'mail_entity' => $mailEntity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="mail_entity_delete", methods={"POST"})
     */
    public function delete(Request $request, MailEntity $mailEntity): Response
    {
        if ($this->isCsrfTokenValid('delete'.$mailEntity->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($mailEntity);
            $entityManager->flush();
        }

        return $this->redirectToRoute('mail_entity_index');
    }
}
