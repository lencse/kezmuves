<?php

namespace Lencse\Blog\Symfony\BlogBundle\Twig;


use Lencse\Date\DateFormatter;

class DateExtension extends \Twig_Extension
{

    /**
     * @var DateFormatter
     */
    private $formatter;

    /**
     * @param DateFormatter $formatter
     */
    public function __construct(DateFormatter $formatter)
    {
        $this->formatter = $formatter;
    }

    /**
     * @return \Twig_SimpleFilter[]
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('prettyDate', [$this->formatter, 'prettyDate'])
        ];
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'lencse_date';
    }

}