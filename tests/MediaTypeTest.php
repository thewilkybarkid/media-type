<?php

declare(strict_types=1);

namespace tests\Libero\MediaType;

use Libero\MediaType\Exception\InvalidMediaType;
use Libero\MediaType\MediaType;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Finder\Finder;
use function is_array;
use function json_try_decode;

final class MediaTypeTest extends TestCase
{
    /**
     * @test
     * @dataProvider caseProvider
     */
    public function it_parses_strings(string $input, ?string $expected) : void
    {
        if (null === $expected) {
            $this->expectException(InvalidMediaType::class);
        }

        $this->assertSame($expected, (string) MediaType::fromString($input));
    }

    public function caseProvider() : iterable
    {
        $files = Finder::create()->files()->name('*.json')->in(__DIR__.'/cases');

        foreach ($files as $file) {
            foreach (json_try_decode($file->getContents(), true) as $case) {
                if (!is_array($case)) {
                    continue;
                }

                yield [$case['input'], $case['output']];
            }
        }
    }

    /**
     * @test
     */
    public function it_has_a_type() : void
    {
        $mediaType = MediaType::fromString('Text/HTML;Charset="utf-8"');

        $this->assertSame('text', $mediaType->getType());
    }

    /**
     * @test
     */
    public function it_has_a_sub_type() : void
    {
        $mediaType = MediaType::fromString('Text/HTML;Charset="utf-8"');

        $this->assertSame('html', $mediaType->getSubType());
    }

    /**
     * @test
     */
    public function it_has_an_essence() : void
    {
        $mediaType = MediaType::fromString('Text/HTML;Charset="utf-8"');

        $this->assertSame('text/html', $mediaType->getEssence());
    }

    /**
     * @test
     */
    public function it_may_have_parameters() : void
    {
        $with = MediaType::fromString('Text/HTML;Charset="utf-8"');
        $withOut = MediaType::fromString('Text/HTML');

        $this->assertSame(['charset' => 'utf-8'], $with->getParameters());
        $this->assertEmpty($withOut->getParameters());
    }
}
