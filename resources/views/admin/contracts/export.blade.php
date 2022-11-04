<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <table>
        <thead>
            <tr>

                <th scope="row" style="color: white; background-color: gray;">كود</th>
                <th  scope="row" style="color: white; background-color: gray;">اسم الطالب</th>
                <th  scope="row" style="color: white; background-color: gray;">اسم ولى الامر</th>
                <th  scope="row" style="color: white; background-color: gray;">هوية الطالب</th>
                <th  scope="row" style="color: white; background-color: gray;">هوية ولى الأمر</th>
                <th  scope="row" style="color: white; background-color: gray;">رقم الجوال</th>
                <th  scope="row" style="color: white; background-color: gray;">الفصول المسجلة</th>
                <th  scope="row" style="color: white; background-color: gray;">السنة الدراسية</th>
                <th  scope="row" style="color: white; background-color: gray;">الشروط و الاحكام</th>

            </tr>
        </thead>
        <tbody>
        @foreach ($contracts as $key => $contract)
            <tr>
                <th>{{ $contract->id }}</th>
                <td>{{ $contract->student_name }} - (#{{ $contract->studentCode }})</td>
                <td>{{ $contract->guardianName }} (#{{ $contract->guardianCode }})</td>
                <td>{{ $contract->guardianNationalId }}</td>
                <td>{{ $contract->studentNationalId }}</td>
                <td>{{ $contract->phone}} </td>
                <td>{{ count($contract->applied_semesters) }}</td>
                <td>{{ $contract->year_name }}</td>
                <td>{{ $contract->terms_id }}</td>

            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>