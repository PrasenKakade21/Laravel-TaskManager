Dear {{$data->task_owner}},
<br>
Task {{$data->task_description}} {{$data->status == 0? " Has been added":" is completed!"}}
<br>

@if($data->status == 0)
kindly complete it befor {{$data->task_eta}}
@endif
<br>

Thank You.