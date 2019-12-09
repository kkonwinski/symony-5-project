<?php


namespace App\Service;


use Michelf\MarkdownInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Cache\Adapter\AdapterInterface;

class MarkdownHelper
{
    private $cache;
    private $markdown;
    private $logger;

    public function __construct(AdapterInterface $cache, MarkdownInterface $markdown, LoggerInterface $logger)
    {
        $this->markdown = $markdown;
        $this->cache = $cache;
        $this->logger = $logger;
    }

    public function parse(string $source): string
    {

        if (stripos($source, 'placerat') != false) {
            $this->logger->info('Coś tam!!!');
        }
        $item = $this->cache->getItem('markdown' . md5($source));
        if (!$item->isHit()) {
            $item->set($this->markdown->transform($source));
            $this->cache->save($item);
        }
        return $item->get();

    }
}