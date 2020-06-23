<?php

use PHPUnit\Framework\TestCase;
use App\Utils\DataFiller;

class DataFillerTest extends TestCase
{
    public function testDataFillerMake()
    {
        $count = 5;
        $params = [];
        $params['name'] = 'name';

        $r = DataFiller::make('en_EN', $count, $params);

        $this->assertCount($count, $r);
        foreach ($r as $val) {
            $this->assertArrayHasKey('name', $val);
        }
    }

    public function testDataFillerMakeTemplate()
    {
        // Test simple value generation
        $template = [
          ['key'=>'name', 'val'=>'name'],
        ];
        $r = DataFiller::makeTemplate('en_EN', $template);
        $this->assertCount(1, $r);

        // Test array generation
        $template = [
          [
            'key'=>'items',
            'val'=>[
              ['key'=>'name', 'val'=>'name',]
            ],
            'count'=>5
          ],
        ];
        $r = DataFiller::makeTemplate('en_EN', $template);
        $this->assertIsArray($r);
        //echo print_r($r, true);
        $this->assertArrayHasKey('items', $r);
        $this->assertIsArray($r['items']);
        foreach ($r['items'] as $val) {
            $this->assertArrayHasKey('name', $val);
        }
    }
}
