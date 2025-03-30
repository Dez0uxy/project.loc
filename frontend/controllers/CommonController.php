<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use common\models\Category;

class CommonController extends Controller
{

    const RE_MOBILE = '/(nokia|iphone|android|motorola|^mot\-|softbank|foma|docomo|kddi|up\.browser|up\.link|htc|dopod|blazer|netfront|helio|hosin|huawei|novarra|CoolPad|webos|techfaith|palmsource|blackberry|alcatel|amoi|ktouch|nexian|samsung|^sam\-|s[cg]h|^lge|ericsson|philips|sagem|wellcom|bunjalloo|maui|symbian|smartphone|midp|wap|phone|windows ce|iemobile|^spice|^bird|^zte\-|longcos|pantech|gionee|^sie\-|portalmmm|jig\s browser|hiptop|^ucweb|^benq|haier|^lct|opera\s*mobi|opera\*mini|320x320|240x320|176x220)/i';

    private $_isMobile;
    public $session;

    public function init()
    {
        $this->session = Yii::$app->session;
        $this->session->open();

        if (!isset($_SESSION['viewed_items'])) {
            $_SESSION['viewed_items'] = [];
        }

        parent::init();
    }

    public function beforeAction($action)
    {
        \Yii::$app->view->registerLinkTag(['rel' => 'canonical', 'href' => Url::to('', true)]);

        return parent::beforeAction($action);
    }

    public function getIsMobile()
    {
        if ($this->_isMobile === null)
            $this->_isMobile = isset($_SERVER['HTTP_X_WAP_PROFILE']) || isset($_SERVER['HTTP_PROFILE']) ||
                preg_match(self::RE_MOBILE, $_SERVER['HTTP_USER_AGENT']);

        return $this->_isMobile;
    }
}
