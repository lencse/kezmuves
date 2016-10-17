<?php

namespace Lencse\Blog\Component\Test\Content;


use Lencse\Blog\Component\Content\DateComparator;
use Lencse\Blog\Component\Content\Post;
use Lencse\Test\TestCase;

class DateComparatorTest extends TestCase
{

    public function testCompare()
    {
        $post1 = new Post();
        $post2 = new Post();
        $post3 = new Post();
        $formatStr = 'Y-m-d H:i:s';
        $post1->setPublicationDate(\DateTime::createFromFormat($formatStr, '2016-03-15 18:00:00'));
        $post2->setPublicationDate(\DateTime::createFromFormat($formatStr, '2016-03-15 19:00:00'));
        $post3->setPublicationDate(\DateTime::createFromFormat($formatStr, '2016-03-15 18:00:00'));
        $comparator = new DateComparator();
        $this->assertLessThan(0, $comparator->compare($post2, $post1));
        $this->assertGreaterThan(0, $comparator->compare($post1, $post2));
        $this->assertEquals(0, $comparator->compare($post1, $post3));
    }

}