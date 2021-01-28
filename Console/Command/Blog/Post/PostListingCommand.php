<?php declare(strict_types=1);

namespace Koen\AcademyBlogCli\Console\Command\Blog\Post;

use Koen\AcademyBlogCore\Repository\Blog\PostCollectionRepositoryInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PostListingCommand extends Command
{
    /** @var PostCollectionRepositoryInterface */
    protected $postCollectionRepository;

    public function __construct(
        PostCollectionRepositoryInterface $postCollectionRepository,
        string $name = null
    ) {
        parent::__construct($name);
        $this->postCollectionRepository = $postCollectionRepository;
    }

    protected function configure()
    {
        $this->setName('blog:post:list')
            ->setDescription('List all Blog Posts');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        foreach ($this->postCollectionRepository->getItems() as $post) {
            $output->writeln($post->getTitle());
        }
    }
}
