<!DOCTYPE html>
<html style="font-size: 16px;" dir="rtl">

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="{{asset('/css/receipt.css')}}">

</head>

<body class="u-body u-xl-mode">
  <section class="u-clearfix u-section-1" id="sec-3e19">
    <div class="u-clearfix u-sheet u-sheet-1">
      <div class="u-expanded-width u-table u-table-responsive u-table-1">
        <table class="u-table-entity">
          <tbody>
            <tr style="height: 179px;">
              <td style="width: 33.33%;">
                <h3 class="u-align-center"> المملكة العربیة السعودیة <br>شركة مدارس النبلاء<br>الأهلية
                </h3>
                <h5 style="padding-bottom: 1000px;">التاريخ : {{ Carbon\Carbon::now()->format('d-m-Y') }}</h5>
              </td>
              <td class="u-align-center" tyle="width: 33.33%;">
                <h2 class="u-text mb mt">سند قبض</h2>
                <p class="u-text">{{ sprintf('رقم #%s للعام %s',$attempt->id,$attempt->year_name)}}</p>
              </td>
              <td style="width: 33.33%;" class="u-align-center u-table-cell">
                <img style="padding-bottom: 10px;" width="300px" height="300px" src="{{ public_path('/assets/alnoballaLogo.jpeg') }}">
                <h5 class="u-text u-text-1">الرقم الضريبي <br> : {{ env('VAT_NUMBER','301207898100003') }}
                </h5>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

  </section>

  <table style="width: 100%;">
    <tbody>
      <tr>
        <td style="width: 50%;">
          <table class="info-table">
            <tbody>
              <tr class="thr">
                <td class="head">
                  <h5>استلمنا من</h5>
                </td>
                <td class="title">
                  <p>{{ $attempt->guardian_name}}</p>

                </td>
              </tr>
              <tr class="thr">
                <td class="head">
                  <h5>الجنسية</h5>

                </td>
                <td class="title">
                  <p>{{ $attempt->nationality_name}}</p>

                </td>
              </tr>
              <tr class="thr mt">
                <td class="head">
                  <h5>مبلغ وقدره</h5>

                </td>
                <td class="title">
                  <p>{{ $attempt->received_ammount }} ر.س</p>

                </td>
              </tr>
              <tr class="thr">
                <td class="head">
                  <h5>عن طريق</h5>

                </td>
                <td class="title">
                  <p>{{ $attempt->method_name }} {{ $attempt->bank_name ? '('.$attempt->bank_name.')' : null }}</p>

                </td>
              </tr>
              <tr class="thr">
                <td class="head">
                  <h5>للطالب/ة</h5>

                </td>
                <td class="title">
                  <p>{{ $attempt->student_name }}</p>

                </td>
              </tr>
              <tr class="thr">
                <td class="head">
                  <h5>الصف</h5>
                </td>
                <td class="title">
                  <p>{{ sprintf('%s - %s - %s',$attempt->school_name,$attempt->grade_name,$attempt->level_name) }}</p>

                </td>
              </tr>
            </tbody>
          </table>
        </td>
        <td style="width: 50%;">
          <table class="info-table">
            <tbody>
              <tr>
                <td class="head">
                  <h5>رقم الهوية</h5>
                </td>
                <td class="title">
                  <p>{{ $attempt->guardian_national_id }}</p>

                </td>
              </tr>
              <tr class="thr">
                <td class="head">
                  <h5>بتاريخ</h5>

                </td>
                <td class="title">
                  <p>{{ $attempt->created_at->format('Y-m-d') }}</p>

                </td>
              </tr>
              <tr class="thr">
                <td class="head">
                  <h5>كجزء من</h5>

                </td>
                <td class="title">
                  <p>{{ $attempt->installment_name }}</p>

                </td>
              </tr>
              <tr class="thr">
                <td class="head">
                  <h5>رقم الهوية</h5>

                </td>
                <td class="title">
                  <p>{{ $attempt->national_id }}</p>

                </td>
              </tr>

              <tr class="thr">
                <td class="head">
                  <h5>الموظف المختص</h5>

                </td>
                <td class="title">
                  <p>{{ $attempt->admin_name ?? '--' }}</p>

                </td>
              </tr>
            </tbody>
          </table>
        </td>
      </tr>
    </tbody>
  </table>

  <table style="margin: 10mm 0 auto;">
    <tbody>
      <tr>
        <td>
          <table class="info-table">
            <tbody>

              <tr class="thr">
                <td class="head">
                  <h5>والمتبقي من</h5>
                </td>
                <td class="title">
                  <p>{{ $attempt->installment_name }}</p>

                </td>
                <td class="head">
                  <h5>الطالب/ة</h5>
                </td>
                <td class="title">
                  <p>{{ $attempt->residual_amount }}</p>

                </td>
                <td class="title">
                  <p>ريال سعودي</p>
                </td>


              </tr>
            </tbody>
          </table>
        </td>
      </tr>
    </tbody>
  </table>

@if(count($contracts->where('residual_amount','>=',1)))
  <section class="u-align-center u-clearfix u-section-2" id="sec-6170">
    <div class="u-clearfix u-sheet u-valign-middle u-sheet-1">
      <h2 class="u-text u-text-default u-text-1">تقرير الحالة المالية</h2>
      <div class="u-expanded-width u-table u-table-1">
        <table>
          <thead class="report-head">
            <tr style="background-color: #3850a2;">
              <th style="color:#fff; font-weight: bold;">الابن/ه</th>
              <th style="color:#fff; font-weight: bold;">عام</th>
              <th style="color:#fff; font-weight: bold;">رسوم الدراسية</th>
              <th style="color:#fff; font-weight: bold;">النقل</th>
              <th style="color:#fff; font-weight: bold;">الضرائب</th>
              <th style="color:#fff; font-weight: bold;">خصم</th>
              <th style="color:#fff; font-weight: bold;">مديونية</th>
              <th style="color:#fff; font-weight: bold;">الاجمالي</th>
              <th style="color:#fff; font-weight: bold;">مسدد</th>
              <th style="color:#fff; font-weight: bold;">مستحق</th>
            </tr>
          </thead>
          <tbody class="u-table-body">
            @foreach($contracts->where('residual_amount','>=',1) as $contract)
            <tr>
              <td class="u-border-1 u-table-cell">{{ $contract->student_name }}</td>
              <td class="u-border-1 u-table-cell">{{ $contract->year_name }}</td>
              <td class="u-border-1 u-table-cell">{{ $contract->tuition_fees }}</td>
              <td class="u-border-1 u-table-cell">{{ $contract->bus_fees > 0 ? $contract->bus_fees  :  'غير مشترك' }}</td>
              <td class="u-border-1 u-table-cell">{{ $contract->vat_amount >0 ? $contract->vat_amount : 'لا ينطبق' }}</td>
              <td class="u-border-1 u-table-cell">{{ $contract->period_discounts + $contract->coupon_discounts }}</td>
              <td class="u-border-1 u-table-cell">{{ $contract->debt }}</td>
              <td class="u-border-1 u-table-cell">{{ $contract->total_fees }}</td>
              <td class="u-border-1 u-table-cell">{{ $contract->total_paid }}</td>
              <td class="u-border-1 u-table-cell">{{ $contract->total_fees - $contract->total_paid }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </section>
@endif

</body>

</html>
