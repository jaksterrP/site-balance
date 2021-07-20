<?php

namespace App\Method;

use App\Entity\BalanceHistory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Constraints\Required;
use Yoanm\JsonRpcParamsSymfonyValidator\Domain\MethodWithValidatedParamsInterface;
use Yoanm\JsonRpcServer\Domain\JsonRpcMethodInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

class HistoryMethod implements JsonRpcMethodInterface, MethodWithValidatedParamsInterface
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    public function apply(array $paramList = null)
    {
        $limit = $paramList['limit'];
        $serializer = new Serializer([new ObjectNormalizer()], [new JsonEncoder()]);
        try {
            $history = $this->em
                ->getRepository(BalanceHistory::class)
                ->findBy([], ['id' => 'desc'], $limit);
            if ($history) {
                return $serializer->serialize($history, 'json');
            }
            return 'Empty';
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }

    public function getParamsConstraint() : Constraint
    {
        return new Collection(['fields' => [
            'limit' => new Required([
                                          new Positive()
                                   ]),
        ]]);
    }
}