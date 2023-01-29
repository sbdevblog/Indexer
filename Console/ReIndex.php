<?php

namespace SbDevBlog\Indexer\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use SbDevBlog\Indexer\Services\indexerService;

class ReIndex extends Command
{
    private const INDEXER_KEY = "indexerid";

    /**
     * @var indexerService
     */
    private indexerService $indexerService;

    public function __construct(
        indexerService $indexerService,
        string         $name = null
    )
    {
        $this->indexerService = $indexerService;
        parent::__construct($name);
    }

    /**
     * Configure command
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName("sbdevblog:reindex")
            ->addArgument(self::INDEXER_KEY, InputOption::VALUE_REQUIRED, "Indexer Key")
            ->setDescription("Re Index Based On Index Id");
        parent::configure();
    }

    /**
     * Resetting index by key
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $indexerId = $input->getArgument(self::INDEXER_KEY);
        if ($this->indexerService->reIndexById($indexerId)) {
            $output->writeln(__("Reindex %1 successfully", $indexerId));
            return;
        }
        $output->writeln(__("Something is wrong, Please check Indexer Id %1", $indexerId));
    }
}
