<?php

namespace Koen\AcademyBlogCli\Console\Command\Blog\Post;

use Koen\AcademyBlogCore\Api\PostRepositoryInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class PostDeleteCommand extends Command
{
    /** @var PostRepositoryInterface */
    private $postRepository;

    public function __construct(
        PostRepositoryInterface $postRepository,
        string $name = null
    ) {
        $this->postRepository = $postRepository;
    }

    protected function configure()
    {
        $this->setName('blog:post:delete')
            ->setDescription('Delete a blog post')
            ->addOption('id', 'i', InputOption::VALUE_REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var PostRepositoryInterface $post */
        $post = $this->postRepository->create();

        $post->deleteById($input->getOption('id'));

        $output->writeln('Post with Id: ' . $input->getOption('id') . ' is deleted');
    }

}
