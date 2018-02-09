<?php
/**
 * @author: RunnerLee
 * @email: runnerleer@gmail.com
 * @time: 2018-02
 */

namespace Runner\Pocache\Command;

use FastD\Http\Request;
use FastD\Http\Response;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Clear extends Command
{
    public function configure()
    {
        $this->setName('opcache:clear');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $request = new Request('POST', config()->get('app_url').'/flush_opcache');

        $response = $request->send([
            'token' => config()->get('opcache.flush_token'),
        ]);

        if (Response::HTTP_OK === $response->getStatusCode()) {
            $output->writeln('<info>opcode cache cleared.</info>');
        } else {
            $output->writeln('<error>Clear opcode cache failed.</error>');
        }
    }
}
