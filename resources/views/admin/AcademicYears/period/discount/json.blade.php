@foreach($categories as $category)
<x-ui.divider color="{{$category->color}}">{{ $category->category_name }}</x-ui-divider>

<div class="row" id="table-striped">
  <div class="col-12">
    <div class="card">
      <div class="table-responsive">
        <table class="table table-hover">
          <thead class="table-light">
          <tr>
                <th scope="col">#</th>
                <th scope="col">الصف</th>
                @foreach($plans as $plan)
                <th scope="col">
                    {{ $plan->plan_name }}
                </th>
                @endforeach
                <th scope="col"></th>
            </tr>
          </thead>
          <tbody>
          @foreach($levels as $level)
            <tr>
                <th scope="row">{{ $level->id }}</th>
                <td>{{ $level->level_name }}</td>
                @foreach($plans as $plan)
                <td>
                    <div class="input-group">
                        
                        @php $rate = App\Models\Discount::filter($discounts, $plan->id, $level->id, $category->id,$period_id) @endphp
            <x-inputs.text.Input icon="percent" name="period_name" placeholder="نسبة الخصم %" value="{{ $rate }}" data-plan_id="{{ $plan->id }}" type="number" min="0" max="100" class="level-{{ $level->id }}-category-{{ $category->id }}" oninput="handelButton(this)"/>
                    </div>
                </td>
                @endforeach
                <td>
                    <button style="visibility: hidden;" onclick="UpdateLevel(this)" type="button" class="btn btn-success btn-sm" dtat-category_id="{{ $category->id }}" data-level_id="{{ $level->id }}"><i data-feather='save'></i> حفظ</button>
                </td>
            </tr>
                @endforeach
          </tbody>
        </table>

      </div>
    
    </div>
  </div>
</div>
    @endforeach
