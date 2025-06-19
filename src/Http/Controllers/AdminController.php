<?php

namespace Merlion\Http\Controllers;

use Merlion\Http\Controllers\Concerns\AsAdmin;
use Merlion\Http\Controllers\Concerns\UseForm;
use Merlion\Http\Controllers\Concerns\UseShow;
use Merlion\Http\Controllers\Concerns\UseTable;

abstract class AdminController
{
    use AsAdmin;
    use UseTable;
    use UseForm;
    use UseShow;
}
