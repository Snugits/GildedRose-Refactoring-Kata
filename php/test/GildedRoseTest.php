<?php

require_once __DIR__."/../vendor/autoload.php";
require_once __DIR__."/../src/gilded_rose.php";

class GildedRoseTest extends \PHPUnit\Framework\TestCase {

    const PASS = 'Backstage passes to a TAFKAL80ETC concert';
    const BRIE = 'Aged Brie';
    const SULFURAS = 'Sulfuras, Hand of Ragnaros';

//    public function testContentsEqual1day() {
//        ob_start();
//        $argv = ['', 1];
//        include __DIR__."/../src/texttest_fixture.php";
//        $result = ob_get_contents();
//        ob_end_clean();
//        $this::assertEquals(file_get_contents('testData/1_days_assert.txt'), $result);
//    }
//
//    public function testContentsEqual5day() {
//        ob_start();
//        $argv = ['', 5];
//        include __DIR__."/../src/texttest_fixture.php";
//        $result = ob_get_contents();
//        ob_end_clean();
//        $this::assertEquals(file_get_contents('testData/5_days_assert.txt'), $result);
//    }
//
//    public function testContentsEqual10day() {
//        ob_start();
//        $argv = ['', 10];
//        include __DIR__."/../src/texttest_fixture.php";
//        $result = ob_get_contents();
//        ob_end_clean();
//        $this::assertEquals(file_get_contents('testData/10_days_assert.txt'), $result);
//    }
//
//    public function testContentsEqual50day() {
//        ob_start();
//        $argv = ['', 50];
//        include __DIR__."/../src/texttest_fixture.php";
//        $result = ob_get_contents();
//        ob_end_clean();
//        $this::assertEquals(file_get_contents('testData/50_days_assert.txt'), $result);
//    }

    public function runtimeLoop($items, $days = 1)
    {
        $engine = new GildedRose($items);
        foreach (range(1, $days) as $day) {
            $engine->update_quality();
        }
    }

    public function testAgedBrie()
    {
        $items = array(new Item("Aged Brie", 2, 3));

        $this->runtimeLoop($items);
        $this->assertEquals("Aged Brie", $items[0]->name);
        $this->assertEquals(1, $items[0]->sell_in);
        $this->assertEquals(4, $items[0]->quality);

        $this->runtimeLoop($items);
        $this->assertEquals("Aged Brie", $items[0]->name);
        $this->assertEquals(0, $items[0]->sell_in);
        $this->assertEquals(5, $items[0]->quality);

        $this->runtimeLoop($items);
        $this->assertEquals("Aged Brie", $items[0]->name);
        $this->assertEquals(-1, $items[0]->sell_in);
        $this->assertEquals(7, $items[0]->quality);

        $this->runtimeLoop($items);
        $this->assertEquals("Aged Brie", $items[0]->name);
        $this->assertEquals(-2, $items[0]->sell_in);
        $this->assertEquals(9, $items[0]->quality);

        $items = array(new Item("Aged Brie", 10, 49));
        $this->runtimeLoop($items);
        $this->assertEquals(9, $items[0]->sell_in);
        $this->assertEquals(50, $items[0]->quality);

        $this->runtimeLoop($items);
        $this->assertEquals(50, $items[0]->quality);

        $items = array(new Item("Aged Brie", 10, 51));
        $this->runtimeLoop($items);
        $this->assertEquals(9, $items[0]->sell_in);
        $this->assertEquals(51, $items[0]->quality);
    }

    public function testSulfuras()
    {
        $items = array(new Item(self::SULFURAS, 4, 80));

        $this->runtimeLoop($items);
        $this->assertEquals(self::SULFURAS, $items[0]->name);
        $this->assertEquals(4, $items[0]->sell_in);
        $this->assertEquals(80, $items[0]->quality);

        $items = array(new Item(self::SULFURAS, -1, 80));

        $this->runtimeLoop($items);
        $this->assertEquals(self::SULFURAS, $items[0]->name);
        $this->assertEquals(-1, $items[0]->sell_in);
        $this->assertEquals(80, $items[0]->quality);


    }

}
