<?php
namespace App\Service;

use Psr\Log\LoggerInterface;

class MessageGenerator 
{
    //Ctr+Alt+c Class Helper && PHP Inteliphense extensions
	public function __construct(private LoggerInterface $logger)
	{
        $this->logger->info("New MessageGenerator.php");

	}    
    public function getHappyMessage(): string
    {
        $messages = [
            'You did it! You updated the system! Amazing!',
            'That was one of the coolest updates I\'ve seen all day!',
            'Great work! Keep going!',
        ];

        $index = array_rand($messages);

        $cadena = $messages[$index];

        $this->logger->info('El logger del servicio muestra info: ' . $cadena);
        $this->logger->debug('El logger en servicio con debug: ' . $cadena);
        $this->logger->notice('El logger en servicio con notice: ' . $cadena);
        $this->logger->error('El logger en servicio con error: ' . $cadena);

        return $cadena;
    }
}
?>