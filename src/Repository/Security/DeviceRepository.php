<?php

declare(strict_types=1);

namespace App\Repository\Security;

use App\Entity\Security\Device;
use App\Repository\Security\Device\DeviceWriteStorage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

class DeviceRepository extends ServiceEntityRepository implements DeviceReadStorage, DeviceWriteStorage
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Device::class);
    }

    public function findById(string $id): ?Device
    {
        return $this->findOneBy(['user' => $id]);
    }

    /**
     * @param Device $device
     * @throws ORMException
     */
    public function add(Device $device): void
    {
        $this->_em->persist($device);
        $this->_em->flush();
    }
}