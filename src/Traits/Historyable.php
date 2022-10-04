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
           /* $changes = $model->getChanges();

          

            $changes = $model->getWantedChangedColumns($model);
            
            foreach($changes as $change){
           
                $model->saveChange($change);
            }
            die();*/
            
            collect($model->getWantedChangedColumns($model))->each(function ($change) use($model){
                $model->saveChange($change);
                //$model->update($model->getChanges());
            });
            
        } );
    }

    public function saveChange(ColumnChange $change){
        
        $this->history()->create([
            'column_changed' => $change->column,
            'original_value' =>$this->valueToString($change->from),
            'new_value' => $this->valueToString($change->to),
            'edited_by' => auth()->check() ? auth()->id() : 'guest'
        ]);
    }

    protected function getWantedChangedColumns(Model $model){

        $changes = $model->getChanges();
        $ignored = $this->getIgnoredColumns($model);
        $toTrack = [];
        $original = $model->getOriginal();

        foreach($changes as $key => $val){
            if(! in_array($key, $ignored) ){
                $toTrack[] = new ColumnChange($key, $this->valueToString(Arr::get($original, $key)),  $this->valueToString($val) );
            }
        }
        return $toTrack;

        /*
        return 
            collect(
                array_diff(
                    Arr::except($model->getChanges(), $this->getIgnoredColumns($model) ), 
                    $original = $model->getOriginal()
                )
            )->map(function ($change, $column) use ($original) {
                
                return new ColumnChange($column, $this->valueToString(Arr::get($original, $column)),  $this->valueToString($change) );
            });
        */
    }

    public function history()
    {
        return $this->morphMany(EditHistory::class, 'historyable')->latest();
    }
    
    public function getIgnoredColumns($model)
    {
        return $model->ignoreHistoryColumns ?? ['updated_at'];
    }
    
    public function valueToString($value){
        $type = gettype($value);
        if($type == 'boolean'){
            $value = $value ? '1' : '0';
        }
        if( in_array($type, ['NULL', 'null'])){
            $value = '';
        }
        return (string) $value;
    }

}
