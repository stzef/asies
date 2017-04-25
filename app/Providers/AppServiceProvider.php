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
            Blade::directive('select', function($arreglo){
                dump($arreglo);exit();
                $select = "<select name =".'"'.'"'." id =".'"'.'"'.">";
                foreach ($arreglo as $options) {
                    $select = ($select . ' <option value = "' . $options->ctiactividad . '">' . $options->ntiactividad . '</option>');
                }
                $select = $select . " </select>";
               return '<?php echo $select ?>';
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
