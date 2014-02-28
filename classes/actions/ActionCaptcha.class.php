<?php
F::IncludeFile(Config::Get('path.dir.root') . 'common/plugins/funcpack/classes/kcaptcha/kcaptcha.php');

class PluginFuncpack_ActionCaptcha extends PluginFuncpack_Inherit_ActionCaptcha {
    /**
     * Инициализация
     *
     */
    public function Init() {
        //$this->Viewer_SetResponseAjax('json');
        $this->SetDefaultEvent('index');
    }

    protected function RegisterEvent() {
        $this->AddEvent('index', 'EventIndex');
    }

    public function EventIndex() {
        $oCaptcha = new KCAPTCHA();
        $this->Session_Set('captcha_keystring', $oCaptcha->getKeyString());
        exit;
    }
}
