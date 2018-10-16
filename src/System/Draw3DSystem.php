<?php  

namespace PD\System;

use PGF\System\System;
use PGF\Shaders\Simple3DShader;
use PGF\Camera\PerspectiveCamera;

use PGF\Entity\Registry;

use PGF\Entity\Traits\{Drawable3D, Transform3D};

use PGF\Mesh\MeshManager;

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
	 * The mesh manager
	 *
	 * @var MeshManager
	 */
	protected $meshes;

	/**
	 * Light position
	 *
	 * @var vec3
	 */
	public $lightPosition = null;

	/**
	 * Construct
	 */
	public function __construct(Simple3DShader $shader, PerspectiveCamera $camera, MeshManager $meshes)
	{
		$this->shader = $shader;
		$this->camera = $camera;
		$this->meshes = $meshes;

		// set inital light position
		$this->lightPosition = \glm\vec3(0, 1000, 0);
	}

	/**
	 * Update the given entities
	 *
	 * @param Registry 			$entities
	 */
	public function update(Registry $entities) 
	{
		//$this->camera->printDebug();
	}

	/**
	 * Draw the given entities
	 *
	 * @param Registry 			$entities
	 */
	public function draw(Registry $entities)
	{
		$this->shader->use();
		$this->shader->setProjectionMatrx(\glm\value_ptr($this->camera->getProjectionMatrx()));
		$this->shader->setViewMatrx(\glm\value_ptr($this->camera->getViewMatrix()));
		$this->shader->setViewPosition($this->camera->position);


		$this->lightPosition->x = cos($this->camera->timeOfDay / 100) * 3000;
		$this->lightPosition->y = sin($this->camera->timeOfDay / 100) * 3000;
		$this->lightPosition->z = 200;
		$this->shader->setLightPosition($this->lightPosition);

		$this->shader->uniform1i('mode', $this->camera->renderingMode);

		// // set the color 
		// $this->shader->uniform1i('has_diffuse_texture', 0);
		// $this->shader->uniform3f('diffuse_color', 0.91, 0.28, 0.22);

		foreach($entities->fetch(Drawable3D::class, Transform3D::class) as $entity)
		{
			// set the tranformation uniform
			$this->shader->setTransformationMatrix($entity->transform->getMatrix());

			// set the texture
			if ($entity->diffuseMap) {
				if ($entity->sepcularMap) {
					$this->shader->setTexture($entity->diffuseMap, $entity->sepcularMap);
				} else {
					$this->shader->setTexture($entity->diffuseMap);
				}
			}

			$this->shader->setTextureScale($entity->textureScaleX, $entity->textureScaleY);

    		// load the mesh
    		$this->meshes->get($entity->mesh)->draw();
		}
	}
}