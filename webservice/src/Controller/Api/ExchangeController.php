<?php

namespace App\Controller\Api;

use App\Entity\UserHistory;
use App\Repository\CurrencyRepository;
use App\Repository\UserHistoryRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(name="exchange.")
 */
class ExchangeController extends AbstractController
{

    private $currencyRepository;
    private $userRepository;
    private $userHistoryRepository;

    public function __construct(UserHistoryRepository $userHistoryRepository, CurrencyRepository $currencyRepository, UserRepository $userRepository)
    {
        $this->currencyRepository = $currencyRepository;
        $this->userRepository = $userRepository;
        $this->userHistoryRepository = $userHistoryRepository;
    }
    
    /**
     * @Route("/api/exchange", name="index", methods={"POST"})
     */
    public function index(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $currencyFrom = $this->currencyRepository->findOneBy(['id' => $data['currency_from']]);
        $currencyTo = $this->currencyRepository->findOneBy(['id' => $data['currency_to']]);
        $user = $this->userRepository->findOneBy(['id' => $this->getUser()->getId()]);

        //Fake to simulate exchange, just as a prototype
        $value_to = "27673.975864";

        $userHistorty = new UserHistory();

        $userHistorty->setCurrencyFrom($currencyFrom);
        $userHistorty->setCurrencyTo($currencyTo);
        $userHistorty->setValueFrom($data['value_from']);
        $userHistorty->setValueTo($value_to);
        $userHistorty->setUser($user);

        $entityManager = $this->getDoctrine()->getManager();
        
        $entityManager->persist($userHistorty);

        $entityManager->flush();

        return new JsonResponse(['status' =>'success', 'retorn' => $value_to], Response::HTTP_CREATED);

    }

    /**
     * @Route("api/exchange/all", name="all", methods={"GET"})
     */
    public function all(): JsonResponse
    {
        $userHistories = $this->userHistoryRepository->findAll();

        foreach ($userHistories as $userHistory) {
            $data[] = [
                'id' => $userHistory->getId(),
                'user' => $userHistory->getUser()->getUsername(),
                'current_from' => $userHistory->getCurrencyFrom()->getInitials(),
                'current_to' => $userHistory->getCurrencyTo()->getInitials(),
                'current_from_name' => $userHistory->getCurrencyFrom()->getName(),
                'current_to_name' => $userHistory->getCurrencyTo()->getName(),
                'value_from' => $userHistory->getValueFrom(),
                'value_to' => $userHistory->getValueTo(),
            ];
        }
        
        return new JsonResponse(['status' => 'success', 'data' => $data], Response::HTTP_CREATED);
    }
}
