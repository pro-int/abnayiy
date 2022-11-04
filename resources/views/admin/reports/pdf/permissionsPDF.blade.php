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
            <img src="http://api.bion-advertising.com/public/assets/reportLogo.jpg" />
        </div>
        <hr>
    </head>

    <br>

    <p class="title">اكواد الطلبات  : <span class="red">{{ !empty($data['students']) && is_array($data['students']) ? implode(' - ',$data['students']) : 'جميع الطلاب' }}</span></p>
    <p class="title">حالة الاذن : <span class="red">{{ is_array($data['caeses']) ? implode(' - ',$data['caeses']) : 'جميع الحالات' }}</span></p>
    <p class="title">التاريخ : <span class="red">{{ $data['date'] !== '' ? $data['date'] : 'غير محدد' }}</span></p>

    <table id="test" class="blueTable">
        <thead>
            <tr>
                <th class="title">كود</th>
                <th class="title">اسم الطالب</th>
                <th class="title">المرافق</th>
                <th class="title">الوقت</th>
                <th class="title">السبب</th>
                <th class="title">المدة</th>
                <th class="title">الحالة</th>
                <th class="title">التاريخ</th>
                <th class="title">المدير</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($permissions as $key => $permission)
            <tr>
                <td>{{ $permission->id }}</td>
                <td>#({{ $permission->student_id}}) {{ $permission->student_name }}</td>
                <td>{{ $permission->pickup_persion }}</td>
                <td>{{ $permission->pickup_time }}</td>
                <td>{{ $permission->permission_reson }}</td>
                <td>{{ $permission->permission_duration }}</td>
                <td><span class="badge bg-{{$permission->case_color}}">{{ $permission->case_name }}</span></td>
                <td>{{ $permission->created_at->format('Y-m-d') }}</td>
                <td>{{ $permission->admin_name }}</td>

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