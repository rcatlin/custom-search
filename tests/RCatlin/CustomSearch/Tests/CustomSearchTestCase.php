<?php

namespace RCatlin\CustomSearch\Tests;

class CustomSearchTestCase extends \PHPUnit_Framework_TestCase
{
    protected function buildMock($class)
    {
        return $this->getMockBuilder($class)
            ->disableOriginalConstructor()
            ->getMock();
    }
}
