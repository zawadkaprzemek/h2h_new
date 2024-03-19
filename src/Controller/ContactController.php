<?php

namespace App\Controller;

use App\Entity\ContactMessage;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/contact')]
class ContactController extends AbstractController
{

    public function __construct(readonly EntityManagerInterface $entityManager)
    {
    }


    #[Route('/form', name: 'app_contact_form', methods: ['POST'])]
    public function formAction(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $form = $this->createForm(ContactType::class);
        $form->submit($data);
        if ($form->isSubmitted() && $form->isValid()) {
            $contactMessage = $form->getData();
            $this->entityManager->persist($contactMessage);
            $this->entityManager->flush();
            return $this->json([
                'message' => 'Dziękujemy za przesłaną wiadomość, niedługo odpowiemy na Państwa wiadomość ;)',
            ], Response::HTTP_CREATED);
        }

        $errors = $this->getErrorsFromForm($form);

        return $this->json([
            'errors' => $errors,
        ], Response::HTTP_BAD_REQUEST);
    }

    #[Route('/list', name: 'app_contact_list', methods: ['GET'])]
    public function listAction(): JsonResponse
    {
        $list = $this->entityManager->getRepository(ContactMessage::class)->findAll();

        return $this->json(['list' => $list]);
    }


    private function getErrorsFromForm(FormInterface $form): array
    {
        $errors = [];

        foreach ($form->getErrors(true) as $error) {
            $errors[] = $error->getMessage();
        }
        foreach ($form->all() as $childForm) {
            if ($childForm instanceof FormInterface) {
                if ($childErrors = $this->getErrorsFromForm($childForm)) {
                    $errors[$childForm->getName()] = $childErrors;
                }
            }
        }

        return $errors;
    }
}
