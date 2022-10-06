<?php


namespace MahmoudArafat\EditHistory\Traits;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

trait DatabaseConfig
{

    protected function configEditHistoryTable()
    {
        $check = Schema::hasTable('edit_histories');

        if (!$check) {

            Schema::defaultStringLength(191);

            Schema::create('edit_histories', function (Blueprint $table) {
                $table->increments('id');
                $table->string('historyable_type');
                $table->string('historyable_id');
                $table->string('column_changed');
                $table->longText('original_value')->nullable();
                $table->longText('new_value')->nullable();
                $table->string('edited_by')->nullable();
                $table->timestamps();
            });

        }

    }


}
