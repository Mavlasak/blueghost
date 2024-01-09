<?php declare(strict_types=1);

namespace App\Model\Contact;

use App\Entity\Contact;
use App\Model\Contact\Exception\NameAlreadyExistsException;
use Symfony\Component\String\Slugger\SluggerInterface;

final class ContactService
{
    public function __construct(
        private readonly ContactRepository $contactRepository,
        private readonly SluggerInterface $slugger,
    ) {
    }

    public function create(Contact $contact): void
    {
        $slug = $this->slugger->slug($contact->getName() . '-' . $contact->getSurname());
        $slug = strtolower($slug->toString());
        $slugExist = $this->contactRepository->slugExist($slug);
        if ($slugExist) {
            throw new NameAlreadyExistsException();
        }
        $contact->setSlug($slug);
        $this->save($contact);
    }

    public function update(Contact $contact): string
    {
        $slug = $this->slugger->slug($contact->getName() . '-' . $contact->getSurname());
        $slug = strtolower($slug->toString());
        $slugExist = $this->contactRepository->slugExist($slug, $contact->getId());
        if ($slugExist) {
            throw new NameAlreadyExistsException();
        }
        $contact->setSlug($slug);
        $this->save($contact);

        return $slug;
    }

    public function save(Contact $contact): void
    {
        $this->contactRepository->save($contact);
    }

    public function remove(Contact $contact): void
    {
        $this->contactRepository->remove($contact);
    }

    public function findAll(): array
    {
        return $this->contactRepository->findAll();
    }
}
