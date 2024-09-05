<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManageCustomerNotes extends Model
{

    use HasFactory;

    //function to add note
    public static function add_note($employee_id, $customer_id, $request)
    {
        $note = new ManageCustomerNotes;
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
    protected $table = 'customer_notes';
}
