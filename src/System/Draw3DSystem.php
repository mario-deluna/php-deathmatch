<?php  

namespace PD\System;

use PGF\Shaders\Simple3DShader;

use PGF\Camera\PerspectiveCamera;

class Draw3DSystem extends System
{
	/**
	 * The shader program
	 *
	 * @var Program
	 */
	protected $shader;

	/**
	 * The drawers camera
	 *
	 * @var PerspectiveCamera
	 */
	protected $camera;

	/**
	 * Construct
	 */
	public function __construct(Simple3DShader $shader, PerspectiveCamera $camera)
	{
		$this->shader = $shader;
		$this->camera = $camera;
	}

	/**
	 * Update the given entities
	 *
	 * @param Registry 			$entities
	 */
	public function update(Registry $entities) {}

	/**
	 * Draw the given entities
	 *
	 * @param Registry 			$entities
	 */
	public function draw(Registry $entities)
	{
		$this->shader->use();

	    glUniformMatrix4fv(glGetUniformLocation($this->shader->id(), "view"), 1, false, \glm\value_ptr($this->camera->getViewMatrix()));
	    glUniformMatrix4fv(glGetUniformLocation($this->shader->id(), "projection"), 1, false, \glm\value_ptr($this->camera->getProjectionMatrx()));

		foreach($entities->fetch(Drawable3D::class, Transform3D::class) as $entity)
		{
			// set the tranformation uniform
    		glUniformMatrix4fv(glGetUniformLocation($this->shader->id(), "transform"), 1, false, $entity->transform->getMatrix());

    		// load the mesh
    		$this->tmpMesh->draw();
		}
	}
}