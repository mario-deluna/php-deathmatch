<?php  

namespace PD;

use PGF\Window;
use PGF\Scene;

class MainLoop
{
	protected $window;
	protected $scene;

	/**
	 * The current clear color
	 *
	 * @var array[double]
	 */
	protected $clearColor = [0, 0, 0];

	/**
	 * Construct
	 */
	public function __construct(Window $window, Scene $scene)
	{
		$this->window = $window;
		$this->scene = $scene;
	}

	/**
	 * Get current sceen
	 *
	 * @return Scene
	 */
	public function getCurrentScene() : Scene
	{
		return $this->scene;
	}

	/**
	 * Start the main loop 
	 */
	public function start()
	{
		// enable deph test
		glEnable(GL_DEPTH_TEST);

		while (!$this->window->shouldClose())
		{   
		    // poll window events
		    $this->window->pollEvents();

		    // update the scene
		    $this->scene->update();

		    // clear
		    $this->window->clearColor($this->clearColor[0], $this->clearColor[1], $this->clearColor[2], 1);
		    $this->window->clear(GL_COLOR_BUFFER_BIT | GL_DEPTH_BUFFER_BIT);

		    // draw the scene
		    $this->scene->draw();

		    // swap
		    $this->window->swapBuffers();
		}
	}
}