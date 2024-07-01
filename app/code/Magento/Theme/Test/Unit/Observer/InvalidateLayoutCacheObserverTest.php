<?php
/************************************************************************
 *
 * Copyright 2024 Adobe
 * All Rights Reserved.
 *
 * NOTICE: All information contained herein is, and remains
 * the property of Adobe and its suppliers, if any. The intellectual
 * and technical concepts contained herein are proprietary to Adobe
 * and its suppliers and are protected by all applicable intellectual
 * property laws, including trade secret and copyright laws.
 * Dissemination of this information or reproduction of this material
 * is strictly forbidden unless prior written permission is obtained
 * from Adobe.
 * ************************************************************************
 */
declare(strict_types=1);

namespace Magento\Theme\Test\Unit\Observer;

use Magento\Framework\App\Cache\Tag\Strategy\Factory;
use Magento\Framework\App\Cache\Tag\StrategyInterface;
use Magento\Theme\Observer\InvalidateLayoutCacheObserver;
use Magento\Framework\App\Cache\StateInterface as CacheState;
use Magento\Framework\App\Cache\Type\Layout as LayoutCache;
use Magento\Framework\DataObject;
use Magento\Framework\Event;
use Magento\Framework\Event\Observer;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class InvalidateLayoutCacheObserverTest extends TestCase
{
    /**
     * @var InvalidateLayoutCacheObserver
     */
    private $invalidateLayoutCacheObserver;

    /**
     * @var LayoutCache|MockObject
     */
    private $layoutCacheMock;

    /**
     * @var CacheState|MockObject
     */
    private $cacheStateMock;

    /**
     * @var Factory|MockObject
     */
    private $strategyFactory;

    /**
     * @var Observer|MockObject
     */
    private $observerMock;

    /**
     * @var Event|MockObject
     */
    private $eventMock;

    /**
     * @var DataObject|MockObject
     */
    private $objectMock;

    protected function setUp(): void
    {
        $this->cacheStateMock = $this
            ->getMockBuilder(CacheState::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->layoutCacheMock = $this
            ->getMockBuilder(LayoutCache::class)
            ->onlyMethods(['clean'])
            ->disableOriginalConstructor()
            ->getMock();
        $this->strategyFactory = $this
            ->getMockBuilder(Factory::class)
            ->onlyMethods(['getStrategy'])
            ->disableOriginalConstructor()
            ->getMock();
        $this->observerMock = $this
            ->getMockBuilder(Observer::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->eventMock = $this
            ->getMockBuilder(Event::class)
            ->addMethods(['getObject'])
            ->disableOriginalConstructor()
            ->getMock();
        $this->objectMock = $this
            ->getMockBuilder(DataObject::class)
            ->addMethods(
                [
                    'getIdentifier',
                    'dataHasChangedFor',
                    'isObjectNew'
                ]
            )
            ->disableOriginalConstructor()
            ->getMock();
        $this->invalidateLayoutCacheObserver = new InvalidateLayoutCacheObserver(
            $this->layoutCacheMock,
            $this->cacheStateMock,
            $this->strategyFactory
        );
    }

    /**
     * Test case for InvalidateLayoutCacheObserver test
     *
     * @param bool $cacheIsEnabled
     * @param bool $isDataChangedFor
     * @param bool $isObjectNew
     * @param array $tags
     * @throws RandomException
     * @dataProvider invalidateLayoutCacheDataProvider
     */
    public function testExecute(
        bool    $cacheIsEnabled,
        bool    $isDataChangedFor,
        bool    $isObjectNew,
        array   $tags
    ): void {
        $cacheStrategy = $this
            ->getMockBuilder(StrategyInterface::class)
            ->onlyMethods(['getTags'])
            ->disableOriginalConstructor()
            ->getMock();
        $this->observerMock
            ->expects($this->atLeastOnce())
            ->method('getEvent')
            ->willReturn($this->eventMock);
        $this->eventMock
            ->expects($this->atLeastOnce())
            ->method('getObject')
            ->willReturn($this->objectMock);
        $this->cacheStateMock
            ->expects($this->any())
            ->method('isEnabled')
            ->willReturn($cacheIsEnabled);
        $this->objectMock
            ->expects($this->any())
            ->method('dataHasChangedFor')
            ->willReturn($isDataChangedFor);
        $this->objectMock
            ->expects($this->any())
            ->method('isObjectNew')
            ->willReturn($isObjectNew);
        $this->objectMock
            ->expects($this->any())
            ->method('getIdentifier')
            ->willReturn(random_int(1, 100));
        $this->strategyFactory
            ->expects($this->any())
            ->method('getStrategy')
            ->willReturn($cacheStrategy);
        $cacheStrategy
            ->expects($this->any())
            ->method('getTags')
            ->with($this->objectMock)
            ->willReturn($tags);
        $this->layoutCacheMock
            ->expects($this->any())
            ->method('clean')
            ->willReturnSelf();
        $this->invalidateLayoutCacheObserver->execute($this->observerMock);
    }

    /**
     * Data provider for testcase
     *
     * @return array
     */
    public static function invalidateLayoutCacheDataProvider(): array
    {
        return [
            'when layout cache is not enabled' => [false, true, false, []],
            'when cache is not changed' => [true, false, false, []],
            'when object is new' => [true, true, false, []],
            'when tag is empty' => [true, true, false, []],
            'when tag is not empty' => [true, true, false, ['cms_p']],
        ];
    }
}
