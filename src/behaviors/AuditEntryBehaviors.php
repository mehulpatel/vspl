<?php
    
    namespace mehulpatel\mod\audit\behaviors;
    
    use mehulpatel\mod\audit\models\AuditEntry;
    use Yii;
    use yii\base\Behavior;
    use yii\base\Exception;
    use yii\db\ActiveRecord;
    use yii\db\Expression;
    
    /**
     * Class AuditEntryBehaviour
     *
     * @package mehulpatel\mod\audit\behaviours
     */
    class AuditEntryBehaviors extends Behavior
    {
        /**
         * string
         */
        const NO_USER_ID = "NO_USER_ID";
        
        /**
         * @param $class
         * @param $attribute
         *
         * @return string
         */
        public static function getLabel($class, $attribute)
        {
            $labels = $class::attributeLabels();
            if (isset($labels[$attribute])) {
                return $labels[$attribute];
            } else {
                return ucwords(str_replace('_', ' ', $attribute));
            }
        }
        
        /**
         * @return array
         */
        public function events()
        {
            return [
                ActiveRecord::EVENT_AFTER_UPDATE => 'afterSave',
                ActiveRecord::EVENT_AFTER_INSERT => 'afterSave',
                ActiveRecord::EVENT_AFTER_DELETE => 'afterDelete',
            ];
        }
        
        /**
         * @param      $event
         *
         * @param null $attributes
         *
         * @return mixed
         */
        public function afterSave($event, $attributes = null)
        {
            try {
                $userId = Yii::$app->user->identity->getId();
                $userIpAddress = Yii::$app->request->getUserIP();
                
            } catch (Exception $e) {
                $userId = self::NO_USER_ID;
            }
            
            $newAttributes = $this->owner->getAttributes();
            $oldAttributes = $event->changedAttributes;
            
            $action = Yii::$app->controller->action->id;
            
            if (!$this->owner->isNewRecord) {
                // compare old and new
                foreach ($oldAttributes as $name => $oldValue) {
                    if (!empty($newAttributes)) {
                        $newValue = $newAttributes[$name];
                    } else {
                        $newValue = 'NA';
                    }
                    if ($oldValue != $newValue) {
                        $log = new AuditEntry();
                        $log->old_value = $oldValue;
                        $log->new_value = $newValue;
                        $log->operation = 'UPDATE';
                        $log->model_name = substr(get_class($this->owner), strrpos(get_class($this->owner), '\\') + 1);
                        $log->field_name = $name;
                        $log->timestamp = new Expression('unix_timestamp(NOW())');
                        $log->user_id = $userId;
                        $log->ip = $userIpAddress;
                        
                        $log->save(false);
                    }
                }
            } else {
                foreach ($newAttributes as $name => $value) {
                    $log = new AuditEntry();
                    $log->old_value = 'NA';
                    $log->new_value = $value;
                    $log->operation = 'INSERT';
                    $log->model_name = substr(get_class($this->owner), strrpos(get_class($this->owner), '\\') + 1);
                    $log->field_name = $name;
                    $log->timestamp = new Expression('unix_timestamp(NOW())');
                    $log->user_id = $userId;
                    $log->ip = $userIpAddress;
                    
                    $log->save();
                }
            }
            return true;
        }
        
        /**
         * This function is fo save data to Audit Trail after the delete action.
         *
         * @return bool
         */
        public function afterDelete()
        {
            
            try {
                $userId = Yii::$app->user->identity->getId();
                $userIpAddress = Yii::$app->request->getUserIP();
                
            } catch (Exception $e) { //If we have no user object, this must be a command line program
                $userId = self::NO_USER_ID;
            }
            
            $log = new AuditEntry();
            $log->old_value = 'NA';
            $log->new_value = 'NA';
            $log->operation = 'DELETE';
            $log->model_name = substr(get_class($this->owner), strrpos(get_class($this->owner), '\\') + 1);
            $log->field_name = 'N/A';
            $log->timestamp = new Expression('unix_timestamp(NOW())');
            $log->user_id = $userId;
            $log->ip = $userIpAddress;
            
            $log->save();
            
            return true;
        }
        
    }