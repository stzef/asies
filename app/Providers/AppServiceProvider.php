<?php

namespace asies\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
            Blade::directive('ucfirst', function($string) {
            return "<?php echo ucfirst($string); ?>";
            });
            Blade::directive('select', function($expression){
               return '<?php echo gettype($expression); ?><?php echo count($expression); ?><?php echo $expression['.'"model"'.']; ?>';
            });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
