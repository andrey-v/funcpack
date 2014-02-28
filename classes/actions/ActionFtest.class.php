<?php

class PluginFuncpack_ActionFtest extends Action
{
    /**
     * Инициализация
     *
     */
    public function Init()
    {
        $this->SetDefaultEvent('index');
    }

    protected function RegisterEvent()
    {
        $this->AddEvent('index', 'EventIndex');
    }

    public function EventIndex()
    {
        $this->SetTemplateAction('index');
        if ($sWord = getRequest('word', false, 'post')) {
            P::modules()->viewer->Assign("sWord", $sWord);
        }
    }
}
