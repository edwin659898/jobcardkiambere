<?php

namespace App\Imports;

use App\Models\ChildActivity;
use App\Models\ParentActivity;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportChildActivities implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $parent_id = ParentActivity::where('parent_number',$row['parent_number'])->first()->id;

        return new ChildActivity([
            'child_title'     => $row['child_title'],
            'child_number'    => $row['child_number'],
            'parent_activity_id' => $parent_id,
         ]);
    }
    
}
