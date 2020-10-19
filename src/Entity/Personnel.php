<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Personnel
 * @package App\Entity
 * @ORM\Entity
 */
class Personnel extends User
{

    public const ROLE = "personnel";

    /**
     * @inheritDoc
     */
    public function getRoles(): array
    {
        return ['ROLE_PERSONNEL'];
    }
}