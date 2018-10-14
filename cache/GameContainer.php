<?php

use ClanCats\Container\Container as ClanCatsContainere782a472586f7789fb67cdae0d016746;

class GameContainer extends ClanCatsContainere782a472586f7789fb67cdae0d016746 {

protected $parameters = array (
  'window.title' => 'PHP Deathmatch',
  'window.width' => 800,
  'window.height' => 600,
);

protected $metadata = array (
);
protected $metadataService = array (
);

protected $serviceResolverType = ['window' => 0, 'loop' => 0, 'camera.main_perspective' => 0, 'mesh_manager' => 0, 'shader_manager' => 0, 'shader.simple3D' => 0, 'scene.main' => 0, 'system.draw3D' => 0, 'system.camera' => 0];

protected $resolverMethods = ['window' => 'resolveWindow', 'loop' => 'resolveLoop', 'camera.main_perspective' => 'resolveCameraMainPerspective', 'mesh_manager' => 'resolveMeshManager', 'shader_manager' => 'resolveShaderManager', 'shader.simple3D' => 'resolveShaderSimple3D', 'scene.main' => 'resolveSceneMain', 'system.draw3D' => 'resolveSystemDraw3D', 'system.camera' => 'resolveSystemCamera'];

protected function resolveWindow() {
	$instance = new \PGF\Window();
	$this->resolvedSharedServices['window'] = $instance;
	return $instance;
}
protected function resolveLoop() {
	$instance = new \PD\MainLoop($this->resolvedSharedServices['window'] ?? $this->resolvedSharedServices['window'] = $this->resolveWindow(), $this->resolvedSharedServices['scene.main'] ?? $this->resolvedSharedServices['scene.main'] = $this->resolveSceneMain());
	$this->resolvedSharedServices['loop'] = $instance;
	return $instance;
}
protected function resolveCameraMainPerspective() {
	$instance = new \PGF\Camera\PerspectiveCamera();
	$this->resolvedSharedServices['camera.main_perspective'] = $instance;
	return $instance;
}
protected function resolveMeshManager() {
	$instance = new \PGF\Mesh\MeshManager();
	$this->resolvedSharedServices['mesh_manager'] = $instance;
	return $instance;
}
protected function resolveShaderManager() {
	$instance = new \PGF\Shader\Manager();
	$instance->set('simple3D', $this->resolvedSharedServices['shader.simple3D'] ?? $this->resolvedSharedServices['shader.simple3D'] = $this->resolveShaderSimple3D());
	$this->resolvedSharedServices['shader_manager'] = $instance;
	return $instance;
}
protected function resolveShaderSimple3D() {
	$instance = new \PGF\Shaders\Simple3DShader();
	$this->resolvedSharedServices['shader.simple3D'] = $instance;
	return $instance;
}
protected function resolveSceneMain() {
	$instance = new \PD\Scene\MainScene();
	$instance->addSystem($this->resolvedSharedServices['system.camera'] ?? $this->resolvedSharedServices['system.camera'] = $this->resolveSystemCamera());
	$instance->addSystem($this->resolvedSharedServices['system.draw3D'] ?? $this->resolvedSharedServices['system.draw3D'] = $this->resolveSystemDraw3D());
	$this->resolvedSharedServices['scene.main'] = $instance;
	return $instance;
}
protected function resolveSystemDraw3D() {
	$instance = new \PD\System\Draw3DSystem($this->resolvedSharedServices['shader.simple3D'] ?? $this->resolvedSharedServices['shader.simple3D'] = $this->resolveShaderSimple3D(), $this->resolvedSharedServices['camera.main_perspective'] ?? $this->resolvedSharedServices['camera.main_perspective'] = $this->resolveCameraMainPerspective(), $this->resolvedSharedServices['mesh_manager'] ?? $this->resolvedSharedServices['mesh_manager'] = $this->resolveMeshManager());
	$this->resolvedSharedServices['system.draw3D'] = $instance;
	return $instance;
}
protected function resolveSystemCamera() {
	$instance = new \PD\System\CameraSystem($this->resolvedSharedServices['camera.main_perspective'] ?? $this->resolvedSharedServices['camera.main_perspective'] = $this->resolveCameraMainPerspective(), $this->resolvedSharedServices['window'] ?? $this->resolvedSharedServices['window'] = $this->resolveWindow());
	$this->resolvedSharedServices['system.camera'] = $instance;
	return $instance;
}


}