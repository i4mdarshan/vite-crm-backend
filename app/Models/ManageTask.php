<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManageTask extends Model
{
    use HasFactory;

    //get user details for task assigned by
    public function assigned_by()
    {
        return $this->belongsTo(User::class,'task_assigned_by');
    }

    //get user details for task assigned to
    public function assigned_to()
    {
        return $this->belongsTo(User::class,'task_assigned_to');
    }

    public function employee()
    {
        return $this->belongsTo(User::class,'employee_id');
    }
    //method to search task
    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        $query->where(function ($query) use($term){
            $query->where('task_title','LIKE',$term)
            ->orWhereHas('assigned_by',function($query) use($term){
                $query->where('full_name', 'LIKE', $term);
            })
            ->orWhereHas('assigned_to',function($query) use($term){
                $query->where('full_name', 'LIKE', $term);
            });
        });
    }
    
    public static function get_assigned_tasks($user_id)
    {
        return ManageTask::where('task_assigned_by',$user_id)->paginate(10)->onEachSide(1)->withQueryString();
    }

    public static function get_my_tasks($user_id)
    {
        return ManageTask::where('task_assigned_to',$user_id)->paginate(10)->onEachSide(1)->withQueryString();
    }

    public $timestamps = false;
    protected $table = 'task';

    //method to add annnouncement
    public static function addtask($request)
    {
        $task_info = new ManageTask();
        $task_info->task_title = $request->task_title;
        $task_info->task_description = htmlspecialchars($request->task_description);
        $task_info->task_assigned_by = $request->task_assigned_by;
        $task_info->task_assigned_to = $request->task_assigned_to;
        $task_info->task_status = $request->task_status;
        $task_info->created = date("Y-m-d h:i:s");
        $task_info->updated = date("Y-m-d h:i:s");
        $task_info->save();

        return $task_info;
    }

    public static function update_task($request, $id)
    {
        $task_info = ManageTask::findOrFail($id);
        $task_info->task_status = isset($request->task_status) ? $request->task_status : $task_info->task_status;
        $task_info->task_notes =isset($request->task_notes) ? $request->task_notes : $task_info->task_notes;
        $task_info->task_description =isset($request->task_description) ? $request->task_description : $task_info->task_description;
        $task_info->task_title =isset($request->task_title) ? $request->task_title : $task_info->task_title;
        $task_info->task_assigned_to =isset($request->task_assigned_to) ? $request->task_assigned_to : $task_info->task_assigned_to;


        $task_info->updated = date("Y-m-d h:i:s");
        $task_info->save();

        return $task_info;
    }

   
}
