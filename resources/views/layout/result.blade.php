@if(session('success'))
<div class="alert alert-success" id="result_success">{{session('success')}}</div>
@elseif(session('error'))
<div class="alert alert-danger" id="result_error">{{session('error')}}</div>
@endif