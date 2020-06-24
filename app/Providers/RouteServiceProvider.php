<?php

namespace App\Providers;

use function App\Helpers\url_to_string;
use App\Subcategory;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use App\Category;
use App\Helpers\UrlHelper;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * @param Router $router
     * returns the category to the controller class that implements in his route {category} paramater
     */
    public function boot()
    {
        //

        parent::boot();

        /**
         * check if category parameter in web.php (routing) is valide
         */
        Route::bind('category', function ($name) {
            $name_in_db = str_replace('-', ' ', $name);
            $category = Category::where('name', '=', $name_in_db)->first();
            if (!$category) {
                //if category is not valide return 404 error page
                abort(404);
            }
            /**
             * if i need return something to categoryController, i should return it here
             * return $category->toArray();
             */
        });

        /**
         * check if subcategory parameter in web.php (routing) is valide
         */
        Route::bind('subcategory', function ($name) {
            $name_in_db = str_replace('-', ' ', $name);
            $subcategory = Subcategory::where('name', '=', $name_in_db)->first();
            //dd($subcategory->name);
            if (!$subcategory) {
                abort(404);
            }
            /**
             * if i need return something to categoryController, i should return it here
             * return $subcategory->toArray();
             */
        });
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }
}
