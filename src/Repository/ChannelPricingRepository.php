<?php

declare(strict_types=1);

namespace Vinium\SyliusManagePricePlugin\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

class ChannelPricingRepository extends EntityRepository implements RepositoryInterface
{
    public function findByChannelAndProducts(?ResourceInterface $channel, ?array $products): iterable
    {
        $queryBuilder = $this->createQueryBuilder('o');
        if ($channel) {
            $queryBuilder
                ->andWhere('o.channelCode = :channelCode')
                ->setParameter('channelCode', $channel->getCode());
        }
        if ($products) {
            $queryBuilder
                ->innerJoin('o.productVariant', 'pv')
                ->innerJoin('pv.product', 'p')
                ->andWhere('p.code IN (:products)')
                ->setParameter('products', $products);
        }

        return $this->getPaginator($queryBuilder);
    }
}
