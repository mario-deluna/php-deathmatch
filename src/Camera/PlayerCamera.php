<?php  

namespace PD\Camera;

use PGF\Camera\PerspectiveCamera;


class PlayerCamera extends PerspectiveCamera
{
	/**
	 * The current rendering mode
	 *
	 * @var int
	 */
	public $renderingMode = 0;

	
	public $timeOfDay = 0;
}