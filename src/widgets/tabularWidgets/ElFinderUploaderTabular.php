<?php
/**
 * @author Donii Sergii <doniysa@gmail.com>
 */

namespace sonrac\tabularWidgets;

/**
 * Class Select2Tabular
 *
 * @package sonrac\tabularWidgets
 *
 * @author  Donii Sergii <doniysa@gmail.com>
 */
class ElFinderUploaderTabular extends BaseWidget implements ITabularWidget
{
    public $assetsBundles = 'mihaildev\elfinder\AssetsCallBack';
    /**
     * @inheritdoc
     */
    public function getInitScript(): string
    {

    }

}