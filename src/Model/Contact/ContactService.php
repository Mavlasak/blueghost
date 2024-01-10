<?php declare(strict_types=1);

namespace App\Model\Contact;

use App\Entity\Contact;
use App\Model\Contact\Exception\NameAlreadyExistsException;
use App\Model\Contact\Form\ContactFormData;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

final class ContactService
{
    private const PAGINATOR_COUNT = 5;

    public function __construct(
        private readonly ContactRepository $contactRepository,
        private readonly SluggerInterface $slugger,
        private readonly PaginatorInterface $paginator,
    ) {
    }

    public function create(ContactFormData $contactFormData): void
    {
        $slug = strtolower($this->slugger->slug($contactFormData->getName() . '-' . $contactFormData->getSurname())->toString());
        $this->slugExistException($slug, null);
        $contact = $contactFormData->toEntity($slug);
        $this->save($contact);
    }

    private function slugExistException(string $slug, ?int $id): void
    {
        $slugExist = $this->contactRepository->slugExist($slug, $id);
        if ($slugExist) {
            throw new NameAlreadyExistsException();
        }
    }

    public function update(Contact $contact): string
    {
        $slug = strtolower($this->slugger->slug($contact->getName() . '-' . $contact->getSurname())->toString());
        $this->slugExistException($slug, $contact->getId());
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

    public function findAll(int $page = 1): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->contactRepository->findAll(),
            $page,
            self::PAGINATOR_COUNT
        );
    }
}
