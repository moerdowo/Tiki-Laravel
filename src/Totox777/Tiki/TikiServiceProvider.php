<?php namespace Totox777\Tiki;

use Illuminate\Support\ServiceProvider;

class TikiServiceProvider extends ServiceProvider {

	protected $defer = false;

	public function boot()
	{
		$this->package('totox777/tiki');
	}

	public function register()
	{
		$app = $this->app;

		$this->app['tiki'] = $this->app->share(function($app)
	    {
	        return new Tiki($app['config']->get('tiki::url'),$app['config']->get('tiki::url2'));
	    });
	}

	public function provides()
	{
		return array();
	}

}