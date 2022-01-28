<?php

declare(strict_types=1);

namespace Vinium\SyliusManagePricePlugin\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Sylius\Component\Channel\Repository\ChannelRepositoryInterface;
use Vinium\SyliusManagePricePlugin\Form\ManagePriceSearchType;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class ManagePriceController extends AbstractController
{
    private RepositoryInterface $channelPricingRepository;
    private ChannelRepositoryInterface $channelRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(
        RepositoryInterface $channelPricingRepository,
        ChannelRepositoryInterface $channelRepository,
        EntityManagerInterface $entityManager
    ) {
        $this->channelPricingRepository = $channelPricingRepository;
        $this->channelRepository = $channelRepository;
        $this->entityManager = $entityManager;
    }

    public function index(Request $request): Response
    {
        $form = $this->createForm(ManagePriceSearchType::class);
        $form->handleRequest($request);
        $channelCode = $products = null;
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $channelCode = $data['channelCode'];
            $products = $data['productsCode'];
        }
        $channelPrices = $this->channelPricingRepository->findByChannelAndProducts($channelCode, $products);
        $channelPrices->setMaxPerPage(30);
        $channelPrices->setCurrentPage($request->query->get('page', 1));

        //get all channels;
        $channels = $this->channelRepository->findAll();
        $channelCurrencies = [];
        foreach ($channels as $channel) {
            $channelCurrencies[$channel->getCode()] = $channel->getBaseCurrency()->getCode();
        }

        return $this->render('@ViniumSyliusManagePricePlugin/Admin/manage_price.html.twig', [
            'channelPrices' => $channelPrices,
            'channelCurrencies' => $channelCurrencies,
            'form' => $form->createView(),
        ]);
    }

    public function update(Request $request): Response
    {
        $record = $this->channelPricingRepository->find($request->get('id'));
        if (!$record){
            throw $this->createNotFoundException('Record not found');
        }
        if ($field = $request->get('field')) {
            $price = (int) round((float) str_replace(',', '.', $request->get('price')) * 100, 2);
            $record->{'set'.ucfirst($field)}($price);
            $this->entityManager->persist($record);
            $this->entityManager->flush();
        }

        return $this->json(['success' => true]);
    }
}
