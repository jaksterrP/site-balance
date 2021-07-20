<?php

namespace App\DataFixtures;

use App\Entity\BalanceHistory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($userId = 1; $userId < 25; $userId++) {
            $userBalance = 0;
            for ($numberOfOperation = 0; $numberOfOperation < 100; $numberOfOperation++) {
                $value = mt_rand(-10000, 10000) / 100;
                $userBalance += $value;
                $balanceHistory = new BalanceHistory;
                $balanceHistory->setUserId($userId);
                $balanceHistory->setValue($value);
                $balanceHistory->setBalance($userBalance);
                $manager->persist($balanceHistory);
            }
        }

        $manager->flush();
    }
}
