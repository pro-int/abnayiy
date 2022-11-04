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
            <tr>
                <td style="background-color: yellow ;">السنة الدراسبة : </td>
                <td>{{ $year_name }}</td>
            </tr>
            <tr>
                <td style="background-color: yellow;">ابتداء من : </td>
                <td>{{ $date_from }}</td>
            </tr>
            <tr>
                <td style="background-color: yellow;">الي تاريخ : </td>
                <td>{{ $date_to }}</td>
            </tr>

        </tbody>
    </table>
    <!-- Codes by Quackit.com -->


    <table>
        <thead>
            <tr>
                <th scope="row" style="background-color: yellow;">م</th>
                <th scope="row" style="background-color: yellow;">الطالب</th>
                <th scope="row" style="background-color: yellow;">ولي الامر</th>
                <th scope="row" style="background-color: yellow;">هوية</th>
                <th scope="row" style="background-color: yellow;">النظام</th>
                <th scope="row" style="background-color: yellow;">النوع</th>
                <th scope="row" style="background-color: yellow;">المرحلة</th>
                <th scope="row" style="background-color: yellow;">الصف</th>
                <th scope="row" style="background-color: yellow;">خ.السداد</th>
                <th scope="row" style="background-color: yellow;">الدفعة</th>
                <th scope="row" style="background-color: yellow;">العام الدراسي</th>
                <th scope="row" style="background-color: yellow;">المبلغ</th>
                <th scope="row" style="background-color: yellow;">عن طريق</th>
                <th scope="row" style="background-color: yellow;">بواسطة</th>
                <th scope="row" style="background-color: yellow;">ت.الانشاء</th>
                <th scope="row" style="background-color: yellow;">ت.التحديث</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($PaymentAttempts as $key => $PaymentAttempt)
            <tr>
                <th scope="row">
                    {{ $PaymentAttempt->id }}
                </th>
                <td>{{ $PaymentAttempt->student_name }}</td>
                <td>{{ $PaymentAttempt->guardian_name }}</td>
                <td>{{ $PaymentAttempt->national_id }}</td>
                <td>{{ $PaymentAttempt->school_name }}</td>
                <td>{{ $PaymentAttempt->gender_name}}</td>
                <td>{{ $PaymentAttempt->grade_name}}</td>
                <td>{{ $PaymentAttempt->level_name }}</td>
                <td>{{ $PaymentAttempt->plan_name }}</td>
                <td>{{ $PaymentAttempt->installment_name }} </td>
                <td>{{ $PaymentAttempt->year_name }} </td>
                <td>{{ $PaymentAttempt->received_ammount }}</td>
                <td>{{ $PaymentAttempt->method_name }} {{ $PaymentAttempt->bank_name ? '(' .$PaymentAttempt->bank_name .')' : '' }} {{ $PaymentAttempt->network_name ? '(' .$PaymentAttempt->network_name .')' : '' }}</td>
                <td>{{ $PaymentAttempt->admin_name }}</td>
                <td>{{ $PaymentAttempt->created_at->format('m-d-Y') }}</td>
                <td>{{ $PaymentAttempt->updated_at->format('m-d-Y') }}</td>


            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>