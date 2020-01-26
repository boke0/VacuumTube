<?php

namespace Boke0\Mechanism\Plugins\VacuumTube;
use \Boke0\Mechanism\Api\Plugin;

$plugin=new Plugin();

$plugin->endpoint(ArticleEndpoint::class);
$plugin->endpoint(DashEndpoint::class);
$plugin->endpoint(EditorEndpoint::class);
$plugin->endpoint(LoginEndpoint::class);
$plugin->endpoint(LogoutEndpoint::class);
$plugin->endpoint(InstallEndpoint::class);
$plugin->endpoint(SetupEndpoint::class);

return $plugin;
