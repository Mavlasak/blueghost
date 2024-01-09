<?php declare(strict_types=1);

namespace App\Controller;

use App\Entity\Contact;
use App\Model\Contact\ContactService;
use App\Model\Contact\Exception\NameAlreadyExistsException;
use App\Model\Contact\Form\ContactFormData;
use App\Model\Contact\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    public function __construct(
        private readonly ContactService $contactService
    ) {
    }

    #[Route('/', name: 'contacts')]
    public function indexAction(): Response
    {
        $contacts = $this->contactService->findAll();

        return $this->render('contact/index.html.twig', [
            'contacts' => $contacts,
        ]);
    }

    #[Route('/vytvorit', name: 'contact_create')]
    public function createAction(Request $request): Response
    {
        $contactFormData = new ContactFormData();
        $form = $this->createForm(ContactType::class, $contactFormData);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->contactService->create($contactFormData->toEntity());
                $this->addFlash('success', 'Kontakt byl úspěšně přidán.');
            } catch (NameAlreadyExistsException $exception) {
                $this->addFlash('danger', 'Jméno již existuje.');
            }
        }

        return $this->render('contact/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route(path: '/{slug}', name: 'contact_detail')]
    public function detailAction(Contact $contact, Request $request): Response
    {
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $slug = $this->contactService->update($contact);
                $this->addFlash('success', 'Kontakt byl úspěšně upraven.');
                return $this->redirectToRoute('contact_detail', ['slug' => $slug]);
            } catch (NameAlreadyExistsException $exception) {
                $this->addFlash('danger', 'Jméno již existuje.');
            }
        }

        return $this->render('contact/edit.html.twig', [
            'form' => $form,
            'contact' => $contact,
        ]);
    }

    #[Route(path: '/{id}/delete', name: 'contact_delete')]
    public function deleteAction(Contact $contact): Response
    {
        $this->contactService->remove($contact);
        $this->addFlash('success', 'Kontakt byl úspěšně odebrán');

        return $this->redirectToRoute('contacts');
    }
}
