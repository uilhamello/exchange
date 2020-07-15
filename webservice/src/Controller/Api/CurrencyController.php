<?php

namespace App\Controller\Api;

use App\Entity\Currency;
use App\Repository\CurrencyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route(name="currency.")
 */

class CurrencyController extends AbstractController
{
    private $currencyRepository;

    public function __construct(CurrencyRepository $currencyRepository)
    {
        $this->currencyRepository = $currencyRepository;
    }

    /**
     * @Route("/api/currency/add", name="add", methods={"POST"})
     */
    public function add(Request $request, ValidatorInterface $validator): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $currency = new Currency();   

        $currency->setName($data['name']);

        $errors = $validator->validate($currency);

        if (count($errors) >0) {
            $messages = [];
            foreach ($errors as $violation) {
                 $messages[$violation->getPropertyPath()][] = $violation->getMessage();
            }
            return new JsonResponse($messages, 400);
       }

       $entityManager = $this->getDoctrine()->getManager();

       $entityManager->persist($currency);

       $entityManager->flush();

       return new JsonResponse(['status' => 'currency created! Id: '.$currency->getId()], Response::HTTP_CREATED);
    }

    /**
     * @Route("/api/currency/all", name="all", methods={"GET"})
     */
    public function all(): JsonResponse
    {
        $currencies = $this->currencyRepository->findAll();
        $data = [];

        foreach ($currencies as $currency) {
            $data[] = [
                'id' => $currency->getId(),
                'name' => $currency->getName(),
                'initials' => $currency->getInitials(),
                'image' => $currency->getImage(),
            ];
        }

        return new JsonResponse(['status' => 'success: ', 'data' => $data], Response::HTTP_ACCEPTED);
    }

    /**
     * @Route("/api/currency/{id}", name="find", methods={"GET"})
     */
    public function find($id): JsonResponse
    {
        $currency = $this->currencyRepository->findOneBy(['id' => $id]);

        if(!$currency){
            return new JsonResponse(['status' => 'error', 'message' => 'Value not exist'], 400);
        }

        $data = [
            'id' => $currency->getId(),
            'name' => $currency->getName(),
        ];

        return new JsonResponse(['status' => 'success: ', 'data' => $data], Response::HTTP_ACCEPTED);
    }

    /**
     * @Route("/api/currency/remove/{id}", name="find", methods={"GET"})
     */
    public function remove($id): JsonResponse
    {
        $currency = $this->currencyRepository->findOneBy(['id' => $id]);

        if(!$currency){
            return new JsonResponse(['status' => 'error', 'message' => 'Value not exist'], 400);
        }

        $this->currencyRepository->remove($currency);

        return new JsonResponse(['status' => 'success', 'message' => 'Customer deleted'], Response::HTTP_ACCEPTED);
    }


}
