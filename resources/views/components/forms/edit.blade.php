@props(['method' => 'POST','model','route'])


{{ Form::model($model,$attributes->getAttributes() + ['url' => $route,'method'=>$method , 'class' => 'row','onsubmit' => 'return false']) }}
@method('PUT')
{{ $slot }}

{!! Form::close() !!}