<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            background: #fff !important;
            font-family: "cairo", sans-serif;
            direction: rtl;
            font-size: 10pt;
        }
    </style>
</head>

<body>
    <table>
        <tbody>
            <tr>
                <td><img src="{{ public_path('/assets/reportLogo.png') }}" alt="ابنائي"></td>
                <td></td>
            </tr>
        </tbody>
    </table>

    <table>
        <thead>
            <tr>
                <th scope="row" style="background-color: yellow;">كود</th>
                <th scope="row" style="background-color: yellow;">اسم الطالب</th>
                <th scope="row" style="background-color: yellow;">هوية الطالب</th>
                <th scope="row" style="background-color: yellow;">ولي الأمر</th>
                <th scope="row" style="background-color: yellow;">هوية ولي الأمر</th>
                <th scope="row" style="background-color: yellow;">رقم الجوال</th>
                <th scope="row" style="background-color: yellow;">الجنسية</th>
                <th scope="row" style="background-color: yellow;">الفئة</th>
                @if(request('academic_year_id'))
                <th scope="row" style="background-color: yellow;">المدرسه</th>
                <th scope="row" style="background-color: yellow;">القسم</th>
                <th scope="row" style="background-color: yellow;">المسار</th>
                <th scope="row" style="background-color: yellow;">الصف</th>
                <th scope="row" style="background-color: yellow;">حالة التعاقد</th>
                <th scope="row" style="background-color: yellow;">الخطة</th>
                @can('accuonts-list')
                <th scope="row" style="background-color: yellow;">الرسوم السنوية</th>
                <th scope="row" style="background-color: yellow;">المستحق من الرسوم الدراسية</th>
                <th scope="row" style="background-color: yellow;">الفصول الدراسية</th>
                <th scope="row" style="background-color: yellow;">النقل</th>
                <th scope="row" style="background-color: yellow;">الضرائب</th>
                <th scope="row" style="background-color: yellow;">خصم الفترة</th>
                <th scope="row" style="background-color: yellow;">خصم القسائم</th>
                <th scope="row" style="background-color: yellow;">مديونيات سابقة</th>
                <th scope="row" style="background-color: yellow;">اجمالي المستحق</th>
                <th scope="row" style="background-color: yellow;">المدفوع</th>
                <th scope="row" style="background-color: yellow;">متبقي</th>
                <th scope="row" style="background-color: yellow;">حالة السداد</th>
                <th scope="row" style="background-color: yellow;"> السداد</th>
                @endcan
                <th scope="row" style="background-color: yellow;">حالة الطالب</th>
                <th scope="row" style="background-color: yellow;">مقدم الطلب</th>
                @endif
                <th scope="row" style="background-color: yellow;">نظام نور</th>
                <th scope="row" style="background-color: yellow;">الرعاية</th>
                <th scope="row" style="background-color: yellow;">التاريخ</th>
                <th scope="row" style="background-color: yellow;">الوقت</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($students as $key => $student)
            <tr>
                <th scope="row" style="width:100px;">
                    {{ $student->id }}
                </th>
                <td>{{ $student->student_name }}</td>
                <td>{{ $student->national_id }}</td>
                <td>{{ $student->guardian_name }}</td>
                <td>{{ $student->guardian_national_id }}</td>
                <td>{{ $student->phone }}</td>
                <td>{{ $student->nationality_name }}</td>
                <td><span class="badge bg-{{$student->color }}">{{ $student->category_name }}</span></td>
                @if($student->contract_id)

                <td>{{ $student->school_name }}</td>
                <td>{{ $student->gender_name }}</td>
                <td>{{ $student->grade_name }}</td>
                <td>{{ $student->level_name }}</td>
                <td>{!! $student->contract->getStatus() !!}</td>
                @can('accuonts-list')
                <td>{{ $student->plan_name }}</td>
                @if($student->contract)
                <td>{{ $student->level_tuition_fees }}</td>
                <td>{{ $student->contract->tuition_fees }}</td>
                <td>
                    @foreach( $student->contract->appliedSemesters() as $semester)
                        {{$semester->semester_name}} ,
                    @endforeach
                </td>
                <td>{{ $student->contract->bus_fees }}</td>
                <td>{{ $student->contract->vat_amount }}</td>
                <td>{{ $student->contract->period_discounts }}</td>
                <td>{{ $student->contract->coupon_discounts }}</td>
                <td>{{ $student->contract->debt }}</td>
                <td>{{ $student->contract->total_fees }}</td>
                <td>{{ $student->contract->total_paid }}</td>
                <td>{{ $student->contract->total_fees - $student->contract->total_paid }}</td>
                @if(! $student->contract->getContractPaidPersent())
                <td style="background-color: red; color:white;">لم يسدد</td>
                @elseif($student->contract->getContractPaidPersent() >= 100)
                <td style="background-color: green;">تم السداد</td>
                @else
                <td style="background-color:orange ;">سداد جزئي</td>
                @endif
                <td>{{ $student->contract->getContractPaidPersent()  }}</td>

                @else
                <td><span class="badge bg-danger">لم يسدد</td>
                @endif
                @endcan

                <td>{!! $student->contract->getStudentStatus($student->graduated) !!}</td>
                <td>{{ $student->sales_admin_name }}</td>
                @endif

                <td>{{ $student->student_care ? 'نعم' : 'لا' }}</td>
                <td>@if(null !== $student->last_noor_sync) نعم @else لا @endif</td>
                <td>{{ $student->created_at->format('Y-m-d') }}</td>
                <td>{{ $student->created_at->format('H:m A') }}</td>


            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
