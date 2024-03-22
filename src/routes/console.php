<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('app:fetch-stock-data')->everyMinute();
