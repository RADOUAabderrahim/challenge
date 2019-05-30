<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $objectManager)
    {
       $user = new User();
       $user->setEmail("admin@gmail.com");
       $user->setPassword($this->encoder->encodePassword($user,'admin'));
       $user->setRoles(implode(';',['ROLE_ADMIN']));

        $u = new User();
        $u->setEmail("test@gmail.com");
        $u->setPassword($this->encoder->encodePassword($user,'test'));
        $u->setRoles(implode(';',['ROLE_USER']));

       $objectManager->persist($user);
       $objectManager->persist($u);
       $objectManager->flush();
    }
}
