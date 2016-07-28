<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace yii\db;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class StaleObjectException extends Exception
{
    /**
     * @return string the member-friendly name of this exception
     */
    public function getName()
    {
        return 'Stale Object Exception';
    }
}