<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use function PHPUnit\Framework\throwException;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends AbstractController
{

    #[Route('/contact/{id}/update', name: 'app_contact_update')]
    #[ParamConverter('contact', options: ['mapping'=>['id'=>'id']])]
    #[IsGranted('ROLE_ADMIN')]
    public function update(ManagerRegistry $doctrine, Contact $contact, Request $request)
    {
        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($contact);
            /** @var Contact $editContact */
            $editContact = $form->getData();
            $entityManager->flush();

            return $this->redirectToRoute('app_contact_show', [
                'id' => $editContact->getId()
            ]);
        }

        return $this->renderForm('contact/update.html.twig', [
            'contact'=> $contact,
            'form' => $form
        ]);
    }

    #[Route('/contact/create', name: 'app_contact_create',requirements: ['contactId'=>'\d+'])]
    #[ParamConverter('contact', options: ['mapping'=>['id'=>'id']])]
    #[IsGranted('ROLE_USER')]
    public function create(ManagerRegistry $doctrineContact, Request $request)
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $doctrineContact->getManager();
            $entityManager->persist($contact);
            /** @var Contact $editContact */
            $entityManager->flush();
            return $this->redirectToRoute('app_contact');
        }

        return $this->renderForm('contact/create.html.twig', [
            'contact'=> $contact,
            'form' => $form
        ]);
    }

    #[Route('/contact/{id}/delete', name: 'app_contact_delete', requirements: ['contactId'=>'\d+'])]
    #[ParamConverter('contact', options: ['mapping'=>['id'=>'id']])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Contact $contact, Request $request, ManagerRegistry $doctrine)
    {
        $form = $this->createFormBuilder($contact)
            ->add('Supprimer', SubmitType::class, ['label' => 'Supprimer'])
            ->add('Annuler', SubmitType::class, ['label' => 'Annuler'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('Supprimer')->isClicked())
                {
                    $entityManager= $doctrine->getManager();
                    $entityManager->remove($contact);
                    $entityManager->flush();
                    return $this->redirectToRoute('app_contact');
                } else
                    {
                        return $this->redirectToRoute('app_contact_show', [
                            'id' => $contact->getId()
                        ]);
                    }
        } else
        {
            return $this->render('contact/delete.html.twig', [
                'contact' => $contact,
                'form'=>$form->createView()
            ]);
        }
    }

    #[Route('/contact', name: 'app_contact')]
    public function index(ContactRepository $contactRepository,Request $request): Response
    {
        //$listContacts = $contactRepository->findBy(array(), array('lastname' => 'ASC', 'firstname' => 'ASC'));
        $search= $request->query->get('search');
        if(null == $search){
            $search="";
        }
        $listContacts = $contactRepository->search($search);
        return $this->render('contact/index.html.twig', [
            'lstContacts' => $listContacts
        ]);
    }

    #[Route('/contact/{id}', name: 'app_contact_show')]
    #[Entity('contact', expr: 'repository.findWithCategory(id)')]
    public function show(Contact $contact): Response
    {
        return $this->render('contact/show.html.twig', [
            'contact' => $contact
        ]);
    }

}
