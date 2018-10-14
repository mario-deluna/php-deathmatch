<?php 
if (!defined('DS')) { define('DS', DIRECTORY_SEPARATOR); }

/**
 *---------------------------------------------------------------
 * Autoloader / Compser
 *---------------------------------------------------------------
 *
 * We need to access our dependencies & autloader..
 */
require __DIR__ . DS . 'vendor' . DS . 'autoload.php';

/**
 * Paths
 */
define('PATH_ROOT', __DIR__);
define('PATH_RESOURCES', __DIR__ . DS . 'resources');
define('PATH_CACHE', __DIR__ . DS . 'cache');
define('PATH_SHADER', PATH_RESOURCES . DS . 'shader');
define('PATH_TEXUTRE', PATH_RESOURCES . DS . 'textures');

/**
 *---------------------------------------------------------------
 * Setup the Container
 *---------------------------------------------------------------
 *
 * We need to access our dependencies & autloader..
 */
$factory = new \ClanCats\Container\ContainerFactory(PATH_CACHE);

$container = $factory->create('GameContainer', function($builder)
{
	$importPaths = [];

	// find available container files
	$rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(PATH_ROOT . '/game'));

	foreach ($rii as $file) 
	{
		// skip directories
	    if ($file->isDir()) continue;

	    // skip non ctn files
	    if (substr($file->getPathname(), -4) !== '.ctn') continue;

	    // get the import name
	    $importName = 'game' . substr($file->getPathname(), strlen(PATH_ROOT . '/game'), -4);

	    // add the file
	    $importPaths[$importName] = $file->getPathname();
	}

    // create a new container file namespace and parse our `app.container` file.
    $namespace = new \ClanCats\Container\ContainerNamespace($importPaths);
    $namespace->importFromVendor(PATH_ROOT . '/vendor');

    // start with hydrogen
    $namespace->parse(PATH_ROOT . '/game.ctn');

    // import the namespace data into the builder
    $builder->importNamespace($namespace);
});

/**
 * Add the constants also as container parameters
 */
foreach((get_defined_constants(true)['user'] ?? []) as $constKey => $constValue)
{
	$container->setParameter('const.' . $constKey, $constValue);
}

/**
 * Returns the games container
 */
return $container;