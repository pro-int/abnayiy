<!-- Add Role Modal -->
<div class="modal fade" id="addRoleModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered modal-add-new-role">
    <div class="modal-content">
      <div class="modal-header bg-transparent">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body px-5 pb-5">
        <div class="text-center mb-4">
          <h1 class="role-title">اضافة دور جديد</h1>
          <p>حدد صلاحيات الدور الجديد</p>
        </div>
        <!-- Add role form -->
        {{ Form::open(['route' => 'roles.store','method'=>'POST','id' => 'addRoleForm', 'class' => 'row','onsubmit' => 'return false']) }}

        <div class="row">

          <div class="col-md">
            <x-inputs.text.Input label="اسم الدور  انجليزي" name="name" placeholder="ادخل اسم الدور انجليزي" data-msg="رجاء ادخال اسم الدور انجليزي بشكل صحيح" />
          </div>

          <div class="col-md">
            <x-inputs.text.Input label="اسم الدور عربي" name="display_name" placeholder="ادخل اسم الدور عربي" data-msg="رجاء ادخال اسم الدور عربي بشكل صحيح" />
          </div>

          <div class="col-md">
            <x-inputs.text.Input label="اللون المميز" name="color" placeholder="ادخل اللون" data-msg="رجاء ادخال اللون المميز للدور" />
          </div>
        </div>
        <div class="col-12">
          <h4 class="mt-2 pt-50">صلاحيات الدور</h4>
          <!-- Permission table -->
          <div class="table-responsive">
            <table class="table table-flush-spacing">
              <tbody>
                <tr>
                  <td class="text-nowrap fw-bolder">
                    جميع الصلاحيات ؟
                    <span data-bs-toggle="tooltip" data-bs-placement="top" title="تحديد جميع الصلاحيات المتاحة بالنظام">
                      <em data-feather="info"></em></span>
                  </td>
                  <td>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="selectAll" />
                      <label class="form-check-label" for="selectAll"> تحديد الكل </label>
                    </div>
                  </td>
                </tr>
                @foreach($PermissionsCategory as $category)
                <tr>
                  <td class="text-nowrap fw-bolder">{{ $category->category_name }}</td>
                  <td>
                    <div class="d-flex">
                      @foreach($category->permissions as $permission)
                      <x-inputs.checkbox data-msg="رجاء تحديد صلاحية واحدة علي الاقل" divClass="form-check col-md" name="permission[]" :value="$permission->id" id="permission{{$permission->id}}">
                        {{$permission->display_name}}
                      </x-inputs.checkbox>
                      @endforeach

                    </div>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <!-- Permission table -->
        </div>
        <div class="col-12 text-center mt-2">
          <x-inputs.submit >اضافة</x-inputs.submit>
          <x-inputs.submit data-bs-dismiss="modal" aria-label="Close" type="reset" class="btn btn-outline-secondary">الغاء</x-inputs.submit>

        </div>
        {!! Form::close() !!}
        <!--/ Add role form -->
      </div>
    </div>
  </div>
</div>
<!--/ Add Role Modal -->