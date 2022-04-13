<?php

namespace MahmoudArafat\EditHistory\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use MahmoudArafat\EditHistory\Classes\ColumnChange;
use MahmoudArafat\EditHistory\Models\EditHistory;

trait Historyable 
{

    public static function bootHistoryable(){
        static::updated( function(Model $model){
            collect($model->getWantedChangedColumns($model))->each(function ($change) use($model){
                $model->saveChange($change);
                //$model->update($model->getChanges());
            });
        } );
    }

    public function saveChange(ColumnChange $change){
        $this->history()->create([
            'column_changed' => $change->column,
            'original_value' =>$change->from,
            'new_value' => $change->to,
        ]);
    }

    protected function getWantedChangedColumns(Model $model){
        return 
            collect(
                array_diff(
                    Arr::except($model->getChanges(), $this->getIgnoredColumns($model) ), 
                    $original = $model->getOriginal()
                )
            )->map(function ($change, $column) use ($original) {
                return new ColumnChange($column, Arr::get($original, $column), $change);
            });
    
    }

    public function history()
    {
        return $this->morphMany(EditHistory::class, 'historyable')->latest();
    }
    
    public function getIgnoredColumns($model)
    {
        return $model->ignoreHistoryColumns ?? ['updated_at'];
    }

}
