<?php

namespace App\Controller;

use App\Entity\Mail;
use App\Form\MailType;
use App\Service\ApiClient;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/mail')]
class MailController extends AbstractController
{
    #[Route('/', name: 'mail_new', methods: ['POST','GET'])]
    public function index(Request $request, FileUploader $fileUploader, ApiClient $apiClient): Response
    {
        $mail = new Mail();
        $form = $this->createForm(MailType::class, $mail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $attachment */
            $attachment = $form->get('attachment')->getData();
            if (!$attachment) {
                return $this->renderError($form, 'Attachment missing');
            }

            $attachmentFileName = $fileUploader->upload($attachment);
            if (!$attachmentFileName)
            {
                return $this->renderError($form, 'Error uploading file');
            }

            $result = $apiClient->uploadAttachment($mail->getIdUser(), $fileUploader->getTargetDirectory().'/'.$attachmentFileName);
            if (is_string($result))
            {
                return $this->renderError($form, $result);
            }
            
            //add default values for this project
            $mail->setDestStatut('particulier');
            
            //add attachment
            $mail->setAttachment([$result['file_id']]);
            $createdMail = $apiClient->sendMail($mail);

            if (is_string($createdMail))
            {
                return $this->renderError($form, $createdMail);
            }

            return $this->redirectToRoute('mail_new', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('mail/new.html.twig', [
            'mail' => $mail,
            'form' => $form,
        ]);
    }

    private function renderError(FormInterface $form, string $error): Response
    {
        //Return error
        return $this->render(
            'mail/new.html.twig',
            array('form' => $form->addError(new FormError($error)))
        );
    }
}
