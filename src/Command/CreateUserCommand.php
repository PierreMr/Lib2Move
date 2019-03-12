<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class CreateUserCommand extends Command
{
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
	        // the name of the command (the part after "bin/console")
	        ->setName('app:create-admin')
	        // the short description shown while running "php bin/console list"
	        ->setDescription('Creates a new admin.')
	        // the full command description shown when running the command with
	        // the "--help" option
	        ->setHelp('This command allows you to create a admin...')
	    ;

	    $this
	        // configure an argument
	        ->addArgument('email', InputArgument::REQUIRED, 'The email of the admin.')
	        ->addArgument('password', InputArgument::REQUIRED, 'The password of the admin.')
	        ->addArgument('lastname', InputArgument::REQUIRED, 'The lastname of the admin.')
	        ->addArgument('firstname', InputArgument::REQUIRED, 'The firstname of the admin.')
	    ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
	    // outputs multiple lines to the console (adding "\n" at the end of each line)
	    $output->writeln([
	        'Admin Creator',
	        '============',
	        '',
	    ]);

	    // the value returned by someMethod() can be an iterator (https://secure.php.net/iterator)
	    // that generates and returns the messages with the 'yield' PHP keyword
	    // $output->writeln($this->someMethod());
	    // outputs a message followed by a "\n"

	    $output->writeln('Whoa!');

	    // outputs a message without adding a "\n" at the end of the line
	    $output->write('You are about to ');
	    $output->writeln('create a admin.');
	    
		// retrieve the argument value using getArgument()
		$output->writeln('Email: '.$input->getArgument('email'));
		$output->writeln('Password: '.$input->getArgument('password'));
		$output->writeln('Lastname: '.$input->getArgument('lastname'));
		$output->writeln('Firstname: '.$input->getArgument('firstname'));
		$email = $input->getArgument('email');
		$password = $input->getArgument('password');
		$lastname = $input->getArgument('lastname');
		$firstname = $input->getArgument('firstname');
		$user = new User();
		$user->setEmail($email);
		$password = $this->passwordEncoder->encodePassword($user, $password);
        $user->setPassword($password);
        $user->setLastname($lastname);
        $user->setFirstname($firstname);
        $user->setRoles(['ROLE_ADMIN']);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}
?>