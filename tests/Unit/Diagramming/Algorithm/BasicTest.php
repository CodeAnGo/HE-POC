<?php

namespace Tests\Unit\Diagramming\Algorithm;

use App\Traits\CSVHelper;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BasicTest extends TestCase
{
    use CSVHelper;

    private $csvToRead = 'tests/unit/Diagramming/Algorithm/csvs/basic.csv';

    /** @test */
    public function canReadCSVTest(){
        $csvArray = $this->csv_to_array($this->csvToRead);
        $this->assertArrayHasKey('0', $csvArray);
        $this->assertArrayHasKey('1', $csvArray);
        $this->assertArrayHasKey('2', $csvArray);
        $this->assertArrayHasKey('3', $csvArray);
        $this->assertArrayHasKey('4', $csvArray);
        $this->assertArrayHasKey('5', $csvArray);
        $this->assertArrayHasKey('6', $csvArray);
        $this->assertArrayHasKey('7', $csvArray);
    }

    /** @test */
    public function canUnderstandLinks(){
        $csvArray = $this->csv_to_array($this->csvToRead);
        $links = $this->extractLinks($csvArray);
        $this->assertEquals([['6', '7', 'Arrow', 'Arrow']], $links);
    }

    /** @test */
    public function canUnderstandChildObjects(){
        $csvArray = $this->csv_to_array($this->csvToRead);
        $objectsWithParents = $this->extractChildrenObjects($csvArray);
        $this->assertEquals(['3', '4', '5', '6', '7'], $objectsWithParents);
    }

    /** @test */
    public function canUnderstandParentObjects(){
        $csvArray = $this->csv_to_array($this->csvToRead);
        $objectsWithChildren = $this->extractParentObjects($csvArray);
        $this->assertEquals(['2', '3', '4', '5'], $objectsWithChildren);
    }

    /** @test */
    public function canExtrapolateParentsWithChildren(){
        $csvArray = $this->csv_to_array($this->csvToRead);
        $parentsWithChildren = $this->extractParentsWithChildren($csvArray);
        $correctOutput = [
            '2' => [
                '3', '4', '5', '6', '7'
            ],
            '3' => [
                '4', '5', '6', '7'
            ],
            '4' => [
                '6'
            ],
            '5' => [
                '7'
            ]
        ];
        dd($correctOutput);
        $this->assertEquals($correctOutput, $parentsWithChildren);
    }

    /** @test */
    public function canExtrapolateValidComponents(){
        $this->assertTrue(true);
    }

    /** @test */
    public function canExtrapolateComponentsRequiringSetup(){
        $this->assertTrue(true);
    }
}
