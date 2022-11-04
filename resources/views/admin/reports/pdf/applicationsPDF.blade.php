<html>

<HEAD>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <style>
        @page {
            footer: page-footer;
        }

        body {
            font-family: xbriyaz;
        }

        table.blueTable {
            width: 100%;
            text-align: center;
            border-collapse: collapse;
            box-decoration-break: slice;
        }

        table.blueTable td,
        table.blueTable th {
            border: 1px dotted #F58936;
            padding: 6px 6px;
        }

        table.blueTable tbody td {
            font-size: 14px;
            color: black;
            font-weight: 400;
        }

        table.blueTable thead th {
            font-size: 14px;
            color: #000000;
            text-align: center;
            background: #e5e1d9;

        }

        table.blueTable tfoot td {
            font-size: 15px;
        }

        table.blueTable tfoot .links {
            text-align: center;
        }

        table.blueTable tfoot .links a {
            display: inline-block;
            background: #1C6EA4;
            color: #FFFFFF;
            padding: 2px 8px;
            border-radius: 5px;
        }

        .cat_title {
            font-family: cairo, sans-serif;
            text-align: center;
            width: 100%;
            background-color: #fe8529;
            color: white;
            font-size: 20px;
            padding: 2px 0 2px 0;
            margin: 0;
        }

        img {
            max-width: 210px;

        }

        span {
            color: red;
        }

        .info {
            text-align: right;
        }

        .title {
            font-family: cairo, sans-serif
        }
    </style>
</HEAD>

<body style="direction: rtl;">

    <head>
        <div style="width: 100%;">
            <img src="http://api.bion-advertising.com/public/assets/reportLogo.jpg"/>
        </div>
        <hr>
    </head>

    <br>

    <p class="title">حالة الطلب : <span class="red">{{  $data['status'] }}</span></p>
    <p class="title">خدمة النقل : <span class="red">{{ $data['transportation'] }}</span></p>
    <p class="title">التاريخ : <span class="red">{{ $data['date'] !== '' ? $data['date'] : 'غير محدد' }}</span></p>

    <table id="test" class="blueTable">
        <thead>
            <tr>
                <th class="title">كود</th>
                <th class="title">الاسم</th>
                <th class="title">الجوال</th>
                <th class="title">رقم الهوية</th>
                <th class="title">الصف</th>
                <th class="title">النقل</th>
                <th class="title">حالة الطلب</th>
                <th class="title">تاريخ الطلب</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($applications as $application)
            <tr>
                <td>{{ $application->id }}</td>
                <td>{{ $application->student_name }}</td>
                <td>{{ $application->phone }}</td>
                <td>{{ $application->national_id }}</td>
                <td>{{ $application->school_name }} - {{ $application->gender_name }} - {{ $application->grade_name }} - {{ $application->level_name }}</td>
                <td>{{ $application->transportation_type }}</td>
                <td><span class="badge bg-{{$application->color}}">{{ $application->status_name }}</span></td>
                <td>{{ $application->created_at->format('Y-m-d') }}</td>

            </tr>
            @endforeach
        </tbody>
    </table>
    <br>


    <htmlpagefooter name="page-footer">
        <hr>
        <table width="100%">
            <tr>
                <td width="33%">مدارس النبلاء الاهلية</td>
                <td width="33%" align="center">صفحة رقم {PAGENO} من {nbpg}</td>
                <td width="33%" style="text-align: left;">تم اصدار هذا الملف في {DATE j-m-Y}</td>
            </tr>
        </table>
    </htmlpagefooter>
</body>

</HTML>