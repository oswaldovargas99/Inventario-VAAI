<?php

use App\Models\Inventarios\Movimiento;
use App\Observers\MovimientoObserver;

public function boot(): void
{
    Movimiento::observe(MovimientoObserver::class);
}
