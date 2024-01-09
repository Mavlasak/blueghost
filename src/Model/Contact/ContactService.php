<?php declare(strict_types=1);

namespace App\Model\Contact;

use App\Entity\Contact;
use App\Model\Contact\Exception\NameAlreadyExistsException;
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

    public function findAll(int $page = 1): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->contactRepository->findAll(),
            $page,
            self::PAGINATOR_COUNT
        );
    }
}
