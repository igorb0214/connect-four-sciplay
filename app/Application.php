<?php

namespace app;

use app\models\Game;
use app\traits\Singleton;

class Application {

	use Singleton;

	public function run(): void {

		Game::getInstance()->start();

	}


}