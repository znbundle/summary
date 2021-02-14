<?php

namespace Migrations;

use Illuminate\Database\Schema\Blueprint;
use ZnLib\Migration\Domain\Base\BaseCreateTableMigration;
use ZnLib\Migration\Domain\Enums\ForeignActionEnum;

class m_2021_01_19_053737_create_counter_table extends BaseCreateTableMigration
{

    protected $tableName = 'summary_counter';
    protected $tableComment = '';

    public function tableSchema()
    {
        return function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->comment('Идентификатор');
            $table->string('entity_name')->comment('');
            $table->integer('entity_id')->comment('');
            $table->string('type')->comment('');
            $table->integer('user_id')->nullable()->comment('');
            $table->integer('session_id')->nullable()->comment('');
            $table->string('rate')->nullable()->comment('');
            $table->dateTime('created_at')->comment('Время создания');

            $table
                ->foreign('user_id')
                ->references('id')
                ->on($this->encodeTableName('user_identity'))
                ->onDelete(ForeignActionEnum::CASCADE)
                ->onUpdate(ForeignActionEnum::CASCADE);
            $table
                ->foreign('session_id')
                ->references('id')
                ->on($this->encodeTableName('user_session'))
                ->onDelete(ForeignActionEnum::CASCADE)
                ->onUpdate(ForeignActionEnum::CASCADE);
        };
    }
}