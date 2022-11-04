@props(['route','method','btnClass'])

<div class="offcanvas offcanvas-start" tabindex="-1" id="deleteModal" aria-labelledby="deleteModalLabel">
  <div class="offcanvas-header">
    <h5 id="deleteModalLabel" class="offcanvas-title">هل تريد تأكيد الحذف ؟</h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body my-auto mx-0 flex-grow-0">
    <div class="text-center mb-2 text-danger">
      <me data-feather="trash-2" class="font-large-3"></me>
    </div>
    <p class="text-center" id="slot">
      في حالة حذف احد العناصر - يتم حذف جميع المعلومات المرتبطة بة
    </p>
    {!! Form::open(['url' => '','method'=>'DELETE','id'=> 'deleteFrom']) !!}
    <button type="submit" class="btn btn-{{ $btnClass ?? 'danger' }} mb-1 d-grid w-100  btn-page-block-custom">تأكيد</button>
    {!! Form::close() !!}
    <button type="button" class="btn btn-outline-secondary d-grid w-100" data-bs-dismiss="offcanvas">
      تراجع
    </button>
  </div>
</div>