<?php

namespace App\DataFixtures;

use App\Entity\Patient;
use App\Entity\Personnel;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private UserPasswordEncoderInterface $userPasswordEncoder;

    /**
     * AppFixtures constructor.
     * @param UserPasswordEncoderInterface $userPasswordEncoder
     */
    public function __construct(UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {

        $personnel = new Personnel();
        $personnel->setPassword($this->userPasswordEncoder->encodePassword($personnel, "dev"));
        $personnel->setName("Hamdi T.")
            ->setEmail("hamdi@gmail.com")
            ->setUsername("hamdi")
            ->setUuid(Uuid::uuid4())
        ;
        $manager->persist($personnel);

        $patient = new Patient();
        $patient->setPassword($this->userPasswordEncoder->encodePassword($patient, "dev"));
        $patient->setName("I. diallo")
            ->setEmail("idiallo@gmail.com")
            ->setUsername("idiallo")
            ->setUuid(Uuid::uuid4())
        ;
        $manager->persist($patient);
        $manager->flush();
    }
}