<?php

namespace App\Method;

use App\Entity\BalanceHistory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Constraints\Required;
use Yoanm\JsonRpcParamsSymfonyValidator\Domain\MethodWithValidatedParamsInterface;
use Yoanm\JsonRpcServer\Domain\JsonRpcMethodInterface;

class UserBalanceMethod implements JsonRpcMethodInterface, MethodWithValidatedParamsInterface
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    public function apply(array $paramList = null)
    {
        $userId = $paramList['user_id'];
        try {
            $userBalance = $this->em
                ->getRepository(BalanceHistory::class)
                ->findOneBy(['user_id' => $userId], ['id' => 'desc']);
            if ($userBalance) {
                return $userBalance->getBalance();
            }
            return 'user not found';
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }

    public function getParamsConstraint() : Constraint
    {
        return new Collection(['fields' => [
            'user_id' => new Required([
                new Positive()
            ]),
        ]]);
    }
}