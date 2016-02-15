@if(!empty($scripts))
@foreach($scripts as $script)
    <script src={{$script}}></script>
    @endforeach
    @endif