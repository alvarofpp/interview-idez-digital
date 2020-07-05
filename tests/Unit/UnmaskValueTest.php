<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class UnmaskValueTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testDocuments()
    {
        $documents = [
            [
                'input' => '12557814750',
                'output' => '12557814750',
            ],
            [
                'input' => '+12 (34) 56789-0123',
                'output' => '1234567890123',
            ],
            [
                'input' => '96.197.757/0001-96',
                'output' => '96197757000196',
            ],
        ];

        foreach ($documents as $document) {
            $unmaskValue = unmaskValue($document['input']);
            $this->assertEquals($document['output'], $unmaskValue);
        }
    }
}
