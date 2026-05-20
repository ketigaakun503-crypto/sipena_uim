<?php

namespace App\Providers;

use App\Repositories\Interfaces\UnitKerjaRepositoryInterface;
use App\Repositories\UnitKerjaRepository;
use App\Repositories\Interfaces\JabatanRepositoryInterface;
use App\Repositories\JabatanRepository;
use App\Repositories\Interfaces\PegawaiRepositoryInterface;
use App\Repositories\PegawaiRepository;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
   public function register(): void
{
    $this->app->bind(UnitKerjaRepositoryInterface::class, UnitKerjaRepository::class);
    $this->app->bind(JabatanRepositoryInterface::class, JabatanRepository::class);
    $this->app->bind(PegawaiRepositoryInterface::class, PegawaiRepository::class);
}

    public function boot(): void
    {
        if (config('app.env') === 'production') {
            URL::forceScheme('https')
          }
    }
}