<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\User;
use App\Entity\Bien;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Filesystem\Filesystem;

class AppFixtures extends Fixture
{
    private $NB_USERS = 50;
    private $NB_BIENS = 200;
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->encoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        // récupération de l'objet Faker pour faire des "jolies" fausses données
        $faker = Faker\Factory::create('fr_FR');
        $filesystem = new Filesystem();
        // On recupere les fichiers image de bases
        $finder = new Finder();
        $dossierFixture = __DIR__ . '/../../public/images/fixture/';
        $dossierUpload = __DIR__ . '/../../public/images/biens/';
        $finder->files()->in($dossierFixture);
        foreach ($finder as $file) {
            $fichiers[] = $file->getFilename();
        }
        // création d'un compte Admin
        $admin = new User();
        $admin
            ->setEmail('admin@admin.fr')
            ->setUsername('admin')
            ->setNom('admin')
            ->setPrenom('admin')
            ->setEnabled(1)
            ->setRoles(array('ROLE_ADMIN'))
            ->setPassword($this->encoder->encodePassword($admin, 'admin0'));
        $manager->persist($admin);

        // création d'un compte User pour test
        $user = new User();
        $user
            ->setEmail('user@user.fr')
            ->setUsername('user')
            ->setNom('user')
            ->setPrenom('user')
            ->setEnabled(1)
            ->setPassword($this->encoder->encodePassword($user, '000000'));
        $manager->persist($user);

        // création d'utilisateurs pour remplir la BDD
        for ($i = 1; $i <= $this->NB_USERS; $i++) {
            $user = new User();
            $user
                ->setUsername($faker->userName())
                ->setNom($faker->lastName())
                ->setPrenom($faker->firstName())
                ->setEmail($faker->email())
                ->setEnabled($faker->randomElement(0, 1))
                ->setPassword($this->encoder->encodePassword($user, $faker->password()));
            $manager->persist($user);
            $users[] = $user;
        }
        // création d'BIENs
        for ($i = 0; $i < $this->NB_BIENS; $i++) {
            $BIEN = new BIEN($users[rand(0, $this->NB_USERS - 1)]);

            $image = $fichiers[array_rand($fichiers)];
            // on genere le nouveau nom
            $newName = uniqid() . '.jpg';
            // On copy (en changant le nom)
            $filesystem->copy($dossierFixture . $image, $dossierUpload . $newName);
            $BIEN
                ->setImageName($newName)
                ->setTitre($faker->sentence($nbWords = 4, $variableNbWords = true))
                ->setDescription($faker->paragraph($nbSentences = 4, $variableNbSentences = true))
                ->setCategorie($faker->randomElement($array = array('vente', 'location'), $count = 1))
                ->setType($faker->randomElement($array = array('maison', 'appartement', 'villa'), $count = 1))
                ->setAdresse($faker->streetAddress())
                ->setPrix($faker->randomNumber(5))
                ->setProprietaire($users[array_rand($users)]);

            $manager->persist($BIEN);
        }

        $manager->flush();
    }
}
