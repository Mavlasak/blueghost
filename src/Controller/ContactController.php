<?php declare(strict_types=1);

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\ParameterValue;
use App\Entity\ProductParameter;
use App\Model\Contact\ContactService;
use App\Model\Contact\Exception\NameAlreadyExistsException;
use App\Model\Contact\Form\ContactFormData;
use App\Model\Contact\Form\ContactType;
use App\Model\ParameterRepository;
use App\Model\ProductParameterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    public function __construct(
        private readonly ContactService $contactService,
        private readonly ParameterRepository $parameterRepository,
        private readonly ProductParameterRepository $productParameterRepository,
    ) {
    }

    #[Route('/{parameterValue}', name: 'contacts')]
    public function indexAction(ParameterValue $parameterValue, Request $request): Response
    {
        //dd($this->parameterRepository->xxx3($parameterValue));
        $productParameter = $this->productParameterRepository->xxx2($parameterValue);
        dd(array_map(fn(ProductParameter $productParameter)=> $productParameter->getId(),$productParameter));

        dd($this->parameterRepository->xxx());
        $contacts = $this->contactService->findAll($request->query->getInt('page', 1));

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
                $this->contactService->create($contactFormData);
                $this->addFlash('success', 'Kontakt byl úspěšně přidán.');
                return $this->redirectToRoute('contacts');
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
