<?php

namespace App\DataFixtures;

use App\Entity\File;
use App\Entity\Patient;
use App\Entity\Personnel;
use App\Entity\User;
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
        $personnel->setName("I. Personne");
        $personnel->setEmail("perso@gmail.com");
        $personnel->setUsername("person");
        $personnel->setRoles(['ROLE_PERSONNEL']);
        $personnel->setUuid(Uuid::uuid4());

        $file = new File;
        $file->setName('Passeport')
            ->setFileName('passeport.pdf')
            ->setFolderId("KJ8-EEE-C44");
        $personnel->addFile($file);
        $file = new File;
        $file->setName('carte grise')
            ->setFileName('carte-grise.pdf')
            ->setFolderId("KJ8-EEE-C44")
        ;
        $personnel->addFile($file);

        $manager->persist($personnel);
        $manager->flush();

        $patient = new Patient();
        $patient->setPassword($this->userPasswordEncoder->encodePassword($patient, "dev"));
        $patient->setName("I. Patient zero");
            $patient->setEmail("patient@gmail.com");
            $patient->setUsername("patient");
            $patient->setRoles(['ROLE_PATIENT'])
        ;
        $patient->setUuid(Uuid::uuid4());

        $file = new File;
        $file->setName('Devis')
            ->setFileName('devis.pdf')
            ->setFolderId("KJ8-VDV-09T");
        $patient->addFile($file);
        $file = new File;
        $file->setName('Radiographie')
            ->setFileName('radio-cardio.pdf')
            ->setFolderId("KJ8-VDV-09T");
        $patient->addFile($file);

        $manager->persist($patient);
        $manager->flush();

        $user = new User();
        $user->setPassword($this->userPasswordEncoder->encodePassword($user, "dev"));
        $user->setName("I. diallo");
        $user->setUsername("idiallo");
        $user->setEmail("idiallo@gmail.com");
        $user->setRoles(['ROLE_ADMIN']);
        $user->setUuid(Uuid::uuid4());
        $manager->persist($user);
        $manager->flush();

    }
}