<?php

namespace Tests\Feature\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CourseTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * @var \Parsedown|null
     */
    private $parser = null;

    /**
     * AssignmentTest constructor.
     *
     * @param  string|null  $name
     * @param  array        $data
     * @param  string       $dataName
     */
    public function __construct(
        ?string $name = null,
        array $data = [],
        string $dataName = ''
    ) {
        parent::__construct($name, $data, $dataName);
        $this->parser = new \Parsedown();
        $this->withHeader('Accept', 'application/json');
    }
}
