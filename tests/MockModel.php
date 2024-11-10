<?php

namespace Labrodev\Numberable\Tests;

use Illuminate\Database\Eloquent\Model;
use Labrodev\Numberable\ModelHasNumber;

class MockModel extends Model
{
    use ModelHasNumber;
}
