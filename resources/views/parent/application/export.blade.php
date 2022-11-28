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
                <td style="background-color: yellow;">ابتداء من : </td>
                <td>{{ $date_from }}</td>
            </tr>
            <tr>
                <td style="background-color: yellow;">الي تاريخ : </td>
                <td>{{ $date_to }}</td>
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
                <th scope="row" style="background-color: yellow;">النظام</th>
                <th scope="row" style="background-color: yellow;">النوع</th>
                <th scope="row" style="background-color: yellow;">المرحلة</th>
                <th scope="row" style="background-color: yellow;">الصف</th>
                <th scope="row" style="background-color: yellow;">النقل</th>
                <th scope="row" style="background-color: yellow;">العام</th>
                <th scope="row" style="background-color: yellow;">حالة الطلب</th>
                <th scope="row" style="background-color: yellow;">التاريخ</th>
                <th scope="row" style="background-color: yellow;">الوقت</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($applications as $key => $application)
            <tr>
                <th scope="row" style="width:100px;">
                    {{ $application->id }}
                </th>
                <td>{{ $application->student_name }}</td>
                <td>{{ $application->national_id }}</td>
                <td>{{ $application->guardian_name }}</td>
                <td>{{ $application->guardian_national_id }}</td>
                <td>{{ $application->phone }}</td>
                <td>{{ $application->school_name }}</td>
                <td>{{ $application->gender_name }}</td>
                <td>{{ $application->grade_name }}</td>
                <td>{{ $application->level_name }}</td>
                <td>{{ $application->transportation_type ?? 'لا يرغب' }}</td>
                <td>{{ $application->year_name }}</td>
                <td>{{ $application->status_name }}</td>
                <td>{{ $application->created_at->format('Y-m-d') }}</td>
                <td>{{ $application->created_at->format('H:m A') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>