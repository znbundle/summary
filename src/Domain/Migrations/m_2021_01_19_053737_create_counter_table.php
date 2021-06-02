<?php

namespace Migrations;

use Illuminate\Database\Schema\Blueprint;
use ZnLib\Migration\Domain\Base\BaseCreateTableMigration;
use ZnLib\Migration\Domain\Enums\ForeignActionEnum;

class m_2021_01_19_053737_create_counter_table extends BaseCreateTableMigration
{

    protected $tableName = 'summary_counter';
    protected $tableComment = 'Счетчик';

    public function tableSchema()
    {
        return function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->comment('Идентификатор');
            $table->string('entity_name')->comment('Имя сущности-источника');
            $table->integer('entity_id')->comment('ID сущности-источника');
            $table->string('type')->comment('Тип');
            $table->integer('user_id')->nullable()->comment('ID пользователя');
            $table->integer('session_id')->nullable()->comment('ID сессии');
            $table->string('rate')->nullable()->comment('Значение счетчика');
            $table->dateTime('created_at')->comment('Время создания');

            $this->addForeign($table, 'user_id', 'user_identity');

            /*$table
                ->foreign('user_id')
                ->references('id')
                ->on($this->encodeTableName('user_identity'))
                ->onDelete(ForeignActionEnum::CASCADE)
                ->onUpdate(ForeignActionEnum::CASCADE);*/
            /*$table
                ->foreign('session_id')
                ->references('id')
                ->on($this->encodeTableName('user_session'))
                ->onDelete(ForeignActionEnum::CASCADE)
                ->onUpdate(ForeignActionEnum::CASCADE);*/
        };
    }
}