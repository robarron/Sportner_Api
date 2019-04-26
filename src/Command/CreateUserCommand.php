<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CreateUserCommand extends Command
{
    protected static $defaultName = 'app:create-user';

    private $entityManager;
    private $passwordEncoder;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->entityManager = $entityManager;
        $this->passwordEncoder = $passwordEncoder;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            // the short description shown while running "php bin/console list"
            ->setDescription('Creates a new user.')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command allows you to create a user...')
            ->addArgument('email', InputArgument::REQUIRED, 'The mail of the user.')
            ->addArgument('password', InputArgument::REQUIRED, 'User password')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->entityManager;
        $emailInput = $input->getArgument('email');

        $isEmailExist = $em->getRepository(User::class)->findOneBy(['email' => $emailInput]);

        if ($isEmailExist) {
            $output->writeln('User already exist the email: ' . $emailInput);
            return;
        }

        // outputs multiple lines to the console (adding "\n" at the end of each line)
        $output->writeln([
            'User Creator',
            '============',
            '',
        ]);



        $newUser = new User();

        $encodedPassword = $this->passwordEncoder->encodePassword(
            $newUser,
            $input->getArgument('password')
        );

        $newUser->setEmail($input->getArgument('email'));
        $newUser->setPassword($encodedPassword);

        $this->entityManager->persist($newUser);
        $this->entityManager->flush($newUser);
        // retrieve the argument value using getArgument()
        $output->writeln('User created for the email: '.$input->getArgument('email'));
    }
}
