<?php

namespace Koen\AcademyBlogCli\Console\Command\Blog\Post;

use Koen\AcademyBlogCore\Api\Data\PostInterface;
use Koen\AcademyBlogCore\Api\Data\WriteablePostInterface;
use Koen\AcademyBlogCore\Repository\Blog\PostRepositoryInterface;
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

    public function configure()
    {
        $this->setName(PostCommandInterface::NAME . ':' . PostCommandInterface::CATEGORY . ':create')
            ->setDescription('Create a blog post')
            ->addOption(PostInterface::TITLE, 't', InputOption::VALUE_REQUIRED, 'The Blog Post Title')
            ->addOption(PostInterface::BODY, 'b', InputOption::VALUE_REQUIRED, 'The Blog Post Body')
            ->addOption(PostInterface::URL_KEY, 'u', InputOption::VALUE_OPTIONAL, 'The Blog Post Url Key');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var WriteablePostInterface $post */
        $post = $this->postRepository->create();
        $post->setTitle((string)$input->getOption(PostInterface::TITLE));
        $post->setBody((string)$input->getOption(PostInterface::BODY));

        // If empty UrlKey becomes Title
        $urlKey = $input->getOption(PostInterface::URL_KEY) ?? $input->getOption(PostInterface::TITLE);
        $post->setUrlKey($urlKey);
    }
}
