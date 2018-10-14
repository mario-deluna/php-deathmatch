<?php  

namespace PD\System;

use PGF\System\System;
use PGF\Entity\Registry;

use PGF\Window;
use PGF\Camera\PerspectiveCamera;


class CameraSystem extends System
{
	/**
	 * The camera to control
	 *
	 * @var PerspectiveCamera
	 */
	protected $camera;

	/**
	 * The window wichs input should be used
	 *
	 * @var Window
	 */
	protected $window;

	public $cameraSpeed = 0.2;
	public $cameraFriction = 0.8;

	protected $speedX = 0;
	protected $speedZ = 0;

	protected $lastCursorX = 0;
	protected $lastCursorY = 0;

	/**
	 * Construct
	 */
	public function __construct(PerspectiveCamera $camera, Window $window)
	{
		$this->camera = $camera;
		$this->window = $window;

		// disable the cursor
		glfwSetInputMode($window->getContext(), GLFW_CURSOR, GLFW_CURSOR_DISABLED);  
	}

	/**
	 * Update the given entities
	 *
	 * @param Registry 			$entities
	 */
	public function update(Registry $entities) 
	{
		// Update Camera Z
		if ($this->window->getKeyState(GLFW_KEY_W) === GLFW_PRESS) {
	        $this->speedZ += $this->cameraSpeed;
	    } elseif ($this->window->getKeyState(GLFW_KEY_S) === GLFW_PRESS) {
	        $this->speedZ -= $this->cameraSpeed;
	    }

	    $this->speedZ *= $this->cameraFriction;
	    $this->speedZ > 0 ? $this->camera->moveForward($this->speedZ) : $this->camera->moveBackward(-$this->speedZ);

	    // Update Camera X
	    if ($this->window->getKeyState(GLFW_KEY_A) === GLFW_PRESS) {
	        $this->speedX += $this->cameraSpeed;
	    } elseif ($this->window->getKeyState(GLFW_KEY_D) === GLFW_PRESS) {
	        $this->speedX -= $this->cameraSpeed;
	    }

	    $this->speedX *= $this->cameraFriction;
	    $this->speedX > 0 ? $this->camera->moveLeft($this->speedX) : $this->camera->moveRight(-$this->speedX);

	    // Update Camera angles
	    glfwGetCursorPos($this->window->getContext(), $x, $y);
	    $offx = ($x - $this->lastCursorX) * 0.2;
	    $offy = ($y - $this->lastCursorY) * -0.2;

	    $this->camera->updateAngel($offx, $offy);
	    $this->lastCursorX = $x; $this->lastCursorY = $y;
	}

	/**
	 * Draw the given entities
	 *
	 * @param Registry 			$entities
	 */
	public function draw(Registry $entities)
	{
	}
}