<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerLeadNotes extends Model
{
    use HasFactory;

    //method to search notes
    public function scopeSearch($query, $term,$customer_id)
    {
        $term = "%$term%";
        $query->where('customer_id',$customer_id)->where(function ($query) use($term){
            $query->where('notes_time','LIKE',$term);
        });
    }

    //function to add note
    public static function add_note($employee_id, $customer_id, $request)
    {
        $note = new CustomerLeadNotes;
        $note->employee_id = $employee_id;
        $note->customer_id = $customer_id;
        $note->notes_date = $request->notes_date;
        $note->notes_time = $request->notes_time;
        $note->notes_description = $request->notes_description;
        $note->created = date('Y-m-d h:i:s');
        $note->updated = date('Y-m-d h:i:s');
        $note->save();

        return $note;

    }

    public $timestamps = false;
    protected $table = 'customer_lead_notes';

}
