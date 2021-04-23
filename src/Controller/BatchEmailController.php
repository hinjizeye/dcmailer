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
/**
 * @Route("/batch/email")
 */
class BatchEmailController extends AbstractController
{
    /**
     * @Route("/", name="batch_email_index", methods={"GET"})
     */
    public function index(BatchEmailRepository $batchEmailRepository): Response
    {
        return $this->render('batch_email/index.html.twig', [
            'batch_emails' => $batchEmailRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="batch_email_new", methods={"GET","POST"})
     */
    public function new(Request $request, MailerInterface $mailer, EmailsRepository $emailRepo): Response
    {
        $batchEmail = new BatchEmail();
        $emailSent = new Emails();
        $form = $this->createForm(BatchEmailType::class, $batchEmail);
        $form->handleRequest($request);

        $emailRepository = $this->getDoctrine()->getRepository(Emails::class);
        $emails = $emailRepository -> findAll();

        $to = array();

        // $addresses = [
        //     'kabwe.kasoma@dczambia.org',
        //     'mitiviktor@gmail.com',
        //     'francischibaye@gmail.com',
        //     'francis.chibaye@dczambia.org',
        //     'louise.kalusa@dczambia.com',
        //     'mumba.mwandama@dczambia.com',
        //     'fps@freight.co.zm',
        //     'yrobbie@kdlzambia.co.zm',
        //     'logisticsadmin@novatek.co.zm',
        //     'chileshec@zambeef.co.zm',
        //     'shaanncarriers@gmail.com',
        //     'jamesl@zambeef.co.zm',
        //     'technical@supaoilzambia.com',
        //     'oscar@jjzam.com',
        //     'Jackson.Phiri@parmalat.co.zm',
        //     'luyan_mat@yahoo.com',
        //     'amwakoi@shoprite.co.za',
        //     'mandeep@satwant.co.zm',
        //     'sales@umcil.co.zm',
        //     'lukman@swissbake.co.zm',
        //     'admin@headlandlogistics.com',
        //     'paul@advancezambia.com',
        //     'accounts@copperzone.co.za',
        //     'logisticsadmin@novatek.co.zm',
        //     'chandra.rao@superdoll-tz.com',
        //     'atatuloads@gmail.com',
        //     'trevor@zalawi.com',
        //     'darshan@hazida.co.zm',
        //     'dexter@kasembo.com',
        //     'ops@standard-sales.com',
        //     'm1saeed@hotmail.com',
        //     'brian.hwalima@gmail.com',
        //     'damaventures@gmail.com',
        //     'anitazkosor@cetina.co.zm',
        //     'joel@copacabana.co.zm',
        //     'accounts@yoyofoods.com',
        //     'accounts1@zambulktankers.com',
        //     'chanda.funda@natbrew.co.zm',
        //     'peggy@mountmeru.co.zm',
        //     'edgar@southgateltdzambia.com',
        //     'accounts@quattro.co.zm',
        //     'africancargocarriers@gmail.com',
        //     'rowepaper@gmail.com',
        //     'melanie.bousfield@jcb.co.zm',
        //     'jonathan@lualuazambia.com',
        //     'kunald@zambeef.co.zm',
        //     'wilford.chidongo@jubatransport.co.zm',
        //     'rob@jumaraslimited.com',
        //     'ISamalama@ccbagroup.com',
        //     'sagar@parrogate.com.zm',
        //     'j.kabwata@gsmgroup.africa',
        //     'pjoats13@gmail.com',
        //     'mita@cancamcarriers.com',
        //     'belinda.lilema@colas-africa.com',
        //     'Edward.Banda@sabot-group.com',
        //     'michael.mwape@termitesmeat.com',
        //     'collen@zambia-tsa.com',
        //     'accounts@quattro.co.zm',
        //     'abdirashid@championlogistic.com',
        //     'faizel.master@gmail.com',
        //     'achanda@yalelo.com',
        //     'logistics@rainetlogistics.co.za',
        //     'mwewahumphrey@gmail.com',
        //     'dmyikona@yahoo.com',
        //     'adminmanager@simba.sch.zm',
        //     'jaaflogistics@gmail.com',
        //     'mwansa.zam@sun-line.cn',
        //     'Engineering.Dept@tigerfeeds.com.zm',
        //     'ntazanak@gmail.com',
        //     'motalayahya4@gmail.com',
        //     'yangzhenlong_gogo@163.com',
        //     'joshua.mwenya@volcanlogistics.com',
        //     'roxytps@gmail.com',
        //     'accounts@kachema.com',
        //     'japhet.banda@quattro.co.zm',
        //     'shammah.zam@sun-line.cn',
        //     'japhet.banda@quattro.co.zm',
        //     'Jackson.Phiri@parmalat.co.zm',
        //     'chanda.funda@natbrew.co.zm',
        //     'makorainvestmentsltd@gmail.com',
        //     'operations.liftandshift@gmail.com',
        //     'tajfreight@hotmail.com',
        //     'sylvester@agrofuelinvestments.com',
        //     'keptcool@keptcool.com',
        //     'ISeklawi@ccbagroup.com',
        //     'raphael@cinetra.co.za',
        //     'thankstransport@yahoo.co.uk',
        //     'george.shinganya@sgcil.com',
        //     'dalalashraf@gmail.com',
        //     'nkhatasuzyo@gmail.com',
        //     'm1saeed@hotmail.com',
        //     'sakala@ilo.org',
        //     'bonaventure.haandondo@wfp.org',
        //     'oswald.musenge@undp.org',
        //     'accounts1@capfish.com',
        //     'peggy@mountmeru.co.zm',
        //     'peggy@mountmeru.co.zm',
        //     'darfarms@yahoo.com',
        //     'EMusonda@zamsugar.zm',
        //     'philipd@zambeef.co.zm',
        //     'japhet.banda@quattro.co.zm',
        //     'logistics@waltergenius.co.zm',
        //     'japhet.banda@quattro.co.zm',
        //     'charles@rossafrica.com',
        //     'elmoreau122000@gmail.com',
        //     'abdul.khalif@khalifmotorsltd.com',
        //     'forshantradingltd@gmail.com',
        //     'dekit@tesuco.com.zm',
        //     'praveenyerrasani@gmail.com',
        //     'simon@ammotors.co.zm',
        //     'roryp@zamnet.zm',
        //     'lenji20@hotmail.com',
        //     'peggy@mountmeru.co.zm',
        //     'vic@vecturazambia.com',
        //     'ZambiaAPMauNoCC@ab-inbev.com',
        //     'badatagencies@gmail.com',
        //     'ZambiaAPMauNoCC@ab-inbev.com',
        //     'gmdzambia@yahoo.com',
        //     'pmalindi2001@gmail.com',
        //     'stallion@stallion.co.zm',
        //     'tantruckingzm@gmail.com',
        //     'chungusylvester@gmail.com',
        //     'abigail.musinga@oneacrefund.org',
        //     'ronaldmwiinga@gmail.com',
        //     'peggy@mountmeru.co.zm',
        //     'abdul.khalif@khalifmotorsltd.com',
        //     'abdul.khalif@khalifmotorsltd.com',
        //     'danieleventriglia@yahoo.it ',
        //     'irfantejani8@gmail.com',
        //     'disputes@dczambia.org',
        //     'inquiries@fendezalogistics.com',
        //     'digir99@gmail.com',
        //     'samulla@hazidamotors.co.zm',
        //     'albrightimonda@gmail.com',
        //     'blitzambia@gmail.com',
        //     'allan.hambulo@techserve.co.zm',
        //     'reuben.muwapela@gmail.com',
        //     'data.transport@outlook.com',
        //     'Pritul.naik@urestfoam.com',
        //     'Pritul.naik@urestfoam.com',
        //     'Pritul.naik@urestfoam.com',
        //     'Pritul.naik@urestfoam.com',
        //     'chella.chola@gmail.com',
        //     'a@dczambia.com',
        //     'mumochaenterprises@gmail.com',
        //     'dannychishimba30@gmail.com',
        //     'mutabaolsen@gmail.com',
        //     'wilford.chidongo@jubatransport.co.zm',
        //     'kroupwood@micmar.co.zm',
        //     'umarbux8749zm@yahoo.com',
        //     'naikp@unity.co.zm',
        //     'bemmotors@iconnect.zm',
        //     'mwaba.makasa@undss.org',
        //     'accounts@antelope.co.zm',
        //     'luyang@wonderfulgroup2010.com',
        //     'nisarg7799@gmail.com',
        //     'asher@nashexplosives.co.zm',
        //     'nmbawo@onsitefuel.co.zm',
        //     'admin.trucks@rotexzambia.com',
        //     'Jamie.xi@hotmail.com',
        //     'moses@sarazilogistics.com',
        //     'heartlandhaulage1@gmail.com',
        //     'terence.mwansa@tcmsgrp.com',
        //     'sotaultd@gmail.com',
        //     'zadoli2019@gmail.com',
        //     'mita@wavelengthszambia.com',
        //     'murray@gdczambia.co.zm',
        //     'andrewkakoma@gmail.com',
        //     'operations@avdwtrp.com',
        //     'canberjac@gmail.com',
        //     'simon@jjzam.com',
        //     'mawano.kambeu@dczambia.com',
        //     'mawano.kambeu@dczambia.com',
        //     'admin@dczambia.com',
        //     'zoe.graham@africon.biz',
        //     'melai@nexgistix.com',
        //     'zoe.graham@africon.biz',
        //     'deborahannbarker64@gmail.com',
        //     'road.tolls@africon.biz',
        //     'finance.docomodities@gmail.com',
        //     'dinahm88@gmail.com',
        //     'alicemwanza@gmail.com',
        //     'webby@urbanstonegroup.com',
        //     'road.tolls@africon.biz',
        //     'AFR01151004@dczambia.com',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'Road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'Road.tolls@africon.biz',
        //     'Road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.bi',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'roads.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'Road.tolls@africon.biz',
        //     'Road.tolls@africon.biz',
        //     'Road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'admin@buyabamba.com',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'deophisterlogistix@gmail.com',
        //     'road.tolls@africon.biz',
        //     'lenny@greendoorlogistics.co.za',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'Road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'sakalacharles1@gmail.com',
        //     'tamara@rossafrica.com',
        //     'road.tolls@africon.biz',
        //     'road.toll@africon.biz',
        //     'road.tolls@africon.biz',
        //     'supdispatch@rossafrica.com',
        //     'Road.toll@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'acccounts@varvagroup.com',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'Patmatinvestmentltd@gmail.com',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'davidglensoma1@gmail.com',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@aricon.biz',
        //     'natasha.mwansa@giz.de',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'pierre@rpafricagroup.co.za',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'services@africon.biz',
        //     'road.tolls@africon.biz',
        //     'dalitso.phiri@vanwaycarriers.co.zm',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'mwapesilaskabwe@gmail.com',
        //     'natasha.mwansa@giz.de',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'info@mwakafreight.com',
        //     'stevennyangu06@gmail.com',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'Road.tolls@africon.biz',
        //     'road.tolls@african.co.za',
        //     'road.tolls@africon.biz',
        //     'raod.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'isaac.afrigrip@gmail.com',
        //     'road.tolls@africaon.biz',
        //     'prince.ghtransport@gmail.com',
        //     'jay@truckmec.co.zm',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.co.za',
        //     'road.tolls@africon.biz',
        //     'raod.tolls@africon.biz',
        //     'dan.musiska@atlascopco.com',
        //     'road.tolls@africon.biz',
        //     'emmanuel@lechweexpress.co.zm',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'artness.lungu@cbforest.co.zm',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'bilefarah1986@gmail.com',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'speedwayszambia@gmail.com',
        //     'chileyanoah8@gmail.com',
        //     'road.tolls@africon.biz',
        //     'swebepeter01@gmail.com',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'byrong.modernauto@gmail.com',
        //     'recoregeneraltrading@gmail.com',
        //     'road.tolls@africon.biz',
        //     'kabaso.knight@redpathmining.com',
        //     'alyusrah2016@gmail.com',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'chanda.funda@natbrew.co.zm',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'roqd.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'mwenzi@strongpak.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'mwenzi@sakizaspinning.biz',
        //     'bhaskar@usangugroup.com',
        //     'farahandsonsltd@gmail.com',
        //     'road.tolls@africon.biz',
        //     'brohoodlogistics@gmail.com',
        //     'road.tolls@africon.biz',
        //     'stella.dubler@gmail.com',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'moonze.truck@gmail.com',
        //     'jonathan.mukosha@quattro.co.zm',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'sanjay@theprintshopltd.com',
        //     'road.tolls@africon.biz',
        //     'road.toll@africon.biz',
        //     'lazchinyanga@outlook.com',
        //     'os1@statushitech.co.zm',
        //     'divyaplastbrijesh@gmail.com',
        //     'danielbanda0354@yahoo.com',
        //     'road.tolls@africon.biz',
        //     'simbalashiphiri@gmail.com',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'apgmilling@yahoo.co.uk',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'ebmmwale@gmail.com',
        //     'logistics@aregashzambia.com',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'road.tolls@africon.biz',
        //     'info@elmantransport.com',
        //     'jeff.mwape@candsinvestmentsltd.com',
        //     'road.tolls@africon.biz'
        // ];

    

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($batchEmail);
            $entityManager->flush();
            
            $subject = $batchEmail->getSubject();
            $message = $batchEmail->getMessage();

            $email = (new Email())
                    ->from('etolls@dczambia.org')
                    ->to('zeyesahinji@gmail.com')
                    // ->cc(...$addresses)
                    //->bcc('bcc@example.com')
                    //->priority(Email::PRIORITY_HIGH)
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
