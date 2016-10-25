<?php

namespace Lencse\Blog\Component\Content\Loader;


use Lencse\Blog\Component\Content\Post;

class FileParser
{

    /**
     * @var MarkdownParser
     */
    private $markdownParser;

    /**
     * @var YamlParser
     */
    private $yamlParser;

    /**
     * @param MarkdownParser $markdownParser
     * @param YamlParser $yamlParser
     */
    public function __construct(MarkdownParser $markdownParser, YamlParser $yamlParser)
    {
        $this->markdownParser = $markdownParser;
        $this->yamlParser = $yamlParser;
    }

    /**
     * @param SplFileInfo $file
     * @return Post
     */
    public function parse(\SplFileInfo $file)
    {
        $html = $this->markdownParser->parse(file_get_contents($file->getRealPath()));
        $dom = new PostDom($html);
        $meta = $this->yamlParser->parse($dom->getMetaYaml());
        foreach (['slug', 'category', 'tags', 'pubdate'] as $key) {
            if (!array_key_exists($key, $meta)) {
                throw new \RuntimeException(sprintf("Key '%s' missing from meta in %s", $key, $file->getFilename()));
            }
        }
        $post = new Post();
        $date = new \DateTime();
        $date->setTimezone(new \DateTimeZone('Europe/Budapest'));
        $date->setTimestamp($meta['pubdate']);
        $post->setSlug($meta['slug'])
            ->setCategory($meta['category'])
            ->setPublicationDate($date)
            ->setBody($dom->getHtml())
            ->setTitle($dom->getTitle())
            ->setFeaturedImage($dom->getFeaturedImage());
        foreach ($meta['tags'] as $tag) {
            $post->addTag($tag);
        }

        return $post;
    }

}