<?php


namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * Class Patient
 * @package App\Entity
 * @ORM\Entity()
 */
class Patient extends User
{

    public const ROLE = "patient";

    /**
     * @inheritDoc
     */
    public function getRoles(): array
    {
        return ['ROLE_PATIENT'];
    }
}