<?php declare(strict_types=1);

namespace Koen\AcademyBlogCli\Console\Command\Blog\Post;

use Koen\AcademyBlogCore\Api\Data\PostInterface;
use Koen\AcademyBlogCore\Api\PostRepositoryInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class PostCreateCommand extends Command
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
        $this->setName('blog:post:create')
            ->setDescription('Create a blog post')
            ->addOption(PostInterface::TITLE, 't', InputOption::VALUE_REQUIRED, 'The Blog Post Title')
            ->addOption(PostInterface::BODY, 'b', InputOption::VALUE_REQUIRED, 'The Blog Post Body')
            ->addOption(PostInterface::URL_KEY, 'u', InputOption::VALUE_OPTIONAL, 'The Blog Post Url Key');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $post = $this->postRepository->create();

        $post->setTitle((string)$input->getOption(PostInterface::TITLE));
        $post->setBody((string)$input->getOption(PostInterface::BODY));

        // If empty UrlKey becomes Title
        $urlKey = $input->getOption(PostInterface::URL_KEY) ?? $input->getOption(PostInterface::TITLE);
        $post->setUrlKey($urlKey);

        $this->postRepository->save($post);

        $output->writeln('Successfully create new blog post');
    }
}
