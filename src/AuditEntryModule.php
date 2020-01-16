<?php
    
    namespace mehulpatel\mod\audit;
    
    use yii\base\Module;
    
    class AuditEntryModule extends Module
    {
        /**
         * @inheritdoc
         */
        public $controllerNamespace = 'mehulpatel\mod\audit\controllers';
        
        /**
         * @inheritdoc
         */
        public function init()
        {
            parent::init();
        }
        
        
    }