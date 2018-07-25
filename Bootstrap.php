<?php
/**
 * Extension class file.
 */

namespace ijony\admin;

use Yii;
use yii\base\Application;
use yii\base\BootstrapInterface;

/**
 * This is the bootstrap class for the yii2-admin-asset extension.
 */
class Bootstrap implements BootstrapInterface
{
	/**
	 * @inheritdoc
	 */
	public function bootstrap($app)
	{
		Yii::setAlias('@yii2admin', __DIR__);
	}
}