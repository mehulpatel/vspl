mehulpatel/vspl
=============================
Yii2 audit record and database changes details 

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
composer require --prefer-dist mehulpatel/vspl:"dev-master"
```
or

```
php composer.phar require --prefer-dist mehulpatel/vspl:"dev-master"
```

or add

```
"mehulpatel/vspl": "dev-master"
```

to the require section of your `composer.json` file.

##### Migration

To run migration to create "tbl_audit_entry" table in your db.

```php
php yii migrate/up --migration-path "@vendor/mehulpatel/vspl/src/migrations/"
```
or
```
you can also import "tbl_audit_entry.sql" directly in your DB.
```

##### Module

Add Audit Entry module in your config file

```php
....
'modules' => [
    ......
    'auditlog' => [
                'class' => 'mehulpatel\mod\audit\AuditEntryModule'
    ],
    ......
],
....
```

##### Component

Add DateTimeHelper components in your config file

```php
....
'components' => [
    ......
    'dateTimeConversion' => [
                'class' => 'mehulpatel\mod\audit\components\DateTimeHelper'
    ],
    ......
],
....
```
Usage
-----

Use get audit log activities or records, attached "AuditEntryBehaviors" with your models as belows:

```php
use mehulpatel\mod\audit\behaviors\AuditEntryBehaviors;
use yii\db\ActiveRecord;

class User extends ActiveRecord {

    public function behaviors(){
        return [ 
            ....
            'auditEntryBehaviors' => [
                'class' => AuditEntryBehaviors::class
             ],
             ....
        ];
    }
}
```
