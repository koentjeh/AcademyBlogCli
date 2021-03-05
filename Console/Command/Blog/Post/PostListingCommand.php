<?php declare(strict_types=1);

namespace Koen\AcademyBlogCli\Console\Command\Blog\Post;

use Koen\AcademyBlogCore\Api\PostRepositoryInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PostListingCommand extends Command
{
    /** @var PostRepositoryInterface */
    protected $postRepository;

    public function __construct(
        PostRepositoryInterface $postRepository,
        string $name = null
    ) {
        parent::__construct($name);
        $this->postRepository = $postRepository;
    }

    protected function configure()
    {
        $this->setName('blog:post:list')
            ->setDescription('List all Blog Posts');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('___ALL BLOG POSTS___');

        $table = new Table($output);
        $table->setHeaders(['ID', 'Title', 'Url_Key', 'Body']);

        foreach ($this->postRepository->getItems() as $post) {
            $table->addRow([
                $post->getId(),
                $post->getTitle(),
                $post->getUrlKey(),
                $post->getBody()
            ]);
        }

        $table->render();
    }
}
