<html>

<head>
  <style>
    body {
      background: #fff !important;
      font-family: "cairo", sans-serif;
      direction: rtl;
      font-size: 10pt;
    }

    p {
      margin: 0pt;
    }

    table.items {
      border: 0.1mm solid #000000;
    }

    .items td {
      border-left: 0.1mm solid #000000;
      border-right: 0.1mm solid #000000;
      text-align: center;
      border: 1px solid #ddd;
    }

    table {
      width: 100%;
    }

    table th {
      width: 40px;
      border: 1px solid #ddd;
      text-align: center;

    }

    ol li {
      font-size: 12px;
    }
  </style>
</head>

<body>
  <table width="100%">
    <tr>
      <td style="width:15%;"><img src="{{ asset($logo_url) }}" style="margin-top:0;right:0;width:175px;" alt="logo" /></td>

    </tr>
  </table>
  <div style="padding: 9px 61px;background: linear-gradient(45deg, #b97015, #7e1a1a);border-radius: 40px;width: 180px; margin-right: 32%;text-align: center;margin-top: -60px; margin-bottom: 16px;">
    <p style="margin: 0;font-size: 14px;color: #fff;">عقد اتفاق تسجيل طالبـ/ـة ({{ $contract->id }})</p>
  </div>
  <div style="width: 100%;text-align: center;">
    <div style="width: 150px;margin: 0;padding: 7px 30px;background: linear-gradient(45deg, #f9c81a, #9d7d0c);border-radius: 40px; margin-right: 37%;">
      <p style="font-size: 14px;color: #fff;text-align: center;">
        البيانات الشخصيـه</p>
    </div>
  </div>
  <div class="table" style="position: relative;padding-top: 10px;">

    <table class="items" style="font-size: 9pt; border-collapse: collapse; ">
      <tr>
        <th style="width:10%" rowspan="2"><strong> <strong> الطالب</strong></th>
        <td style="width:25%;"><strong> الاسم (وفقا للهويه) </strong></td>
        <td style="width:10%;"><strong> نوع الدراسه </strong></td>

        <td style="width:15%;"><strong> الصف الدراسي </strong></td>
        <td style="width:15%;"><strong> رقم الهويه </strong></td>

        <td style="width:10%;"><strong> تاريخ الميلاد </strong></td>
        <td style="width:15%;"><strong> مكان الميلاد </strong></td>
      </tr>

      <tr>

        <td>{{ $student->student_name }}</td>
        <td>{{ $contract->school_name }}</td>

        <td>{{ $contract->level_name }}</td>
        <td>{{ $student->national_id }}</td>

        <td>{{ $student->birth_place ?? 'غير مجدد' }}</td>
        <td>{{ $student->birth_date }}</td>
      </tr>


    </table>

    <table class="items" style="font-size: 9pt; border-collapse: collapse;">
      <tr>
        <th style="width:10%" rowspan="2"><strong> <strong> ولي الأمر </strong></th>
        <td style="width:25%;"><strong>
            الاسم (وفقا للهويه)
          </strong></td>
        <td style="width:10%;"><strong>الجنسية </strong></td>

        <td style="width:15%;"><strong>رقم الهويه </strong></td>

        <td style="width:15%;"><strong>مكان الميلاد </strong></td>
        <td style="width:25%;"><strong>العنوان </strong></td>
      </tr>

      <tr>

        <td>{{ $guardian->first_name }} {{ $guardian->last_name }}</td>
        <td>{{ $guardian->nationality_name }}</td>

        <td>{{ $guardian->national_id }}</td>

        <td>{{ $guardian->city_name }}</td>
        <td>{{ $guardian->address }}</td>

      </tr>
    </table>

    <table class="items" style="font-size: 9pt; border-collapse: collapse; ">
      <tr>
        <th style="width:10%;" rowspan="2"><strong> وسائل التواصل</strong> </th>
        <td style="width:25%;" colspan="2"><strong> رقم جوال ويل الأمر </strong></td>
        <td style="width:20%;" colspan="2"><strong> رقم جوال الأم </strong></td>
        <td style="width:20%;" colspan="2"><strong> جوال أخر</strong></td>
        <td style="width:25%;" colspan="2"><strong> البريد الألكتروني </strong></td>
      </tr>

      <tr>
        <td colspan="2">{{ $guardian->phone }}</td>
        <td colspan="2"></td>

        <td colspan="2"></td>
        <td colspan="2">{{ $guardian->email }}</td>

      </tr>
    </table>


    <div class="data-dasheed" style="margin-top: 30px; margin-bottom: 15px;">
      <div style="width: 33%;float: right;">
        <div style="margin-bottom: 15px;">
          <strong style="font-size: 12px;">العام الدراسي : </strong>
          <span> {{$contract->year_name }} </span>
        </div>
        <div>
          <strong style="font-size: 12px;">أسم المسؤول: </strong>
          <span> {{$contract->admin_name }}</span>
        </div>

      </div>
      <div style="width: 33%;float: right;">
        <div style="margin-bottom: 15px;">
          <strong style="font-size: 12px;">تاريخ التسجيل: </strong>
          <span> {{$contract->created_at->format('d-m-Y') }}</span>
        </div>
        <div>
        </div>
      </div>
      <div style="width: 33%;float: right;">
        <div style="margin-bottom: 15px;">
          <strong style="font-size: 12px;">تاريخ الطباعه: </strong>
          <span> {{carbon\Carbon::now()->format('d-m-Y')}}</span>
        </div>
      </div>
      <div style="clear: both;"></div>
    </div>
    <div class="rules" style="padding: 15px;">
      {!! $terms !!}

      <div>
        <div style="width: 50%;float: right;text-align: center;">
          <div style="margin-bottom: 15px;">
            <p style="font-size: 12px;">اسم ولي الأمر : </b>
              <span>.........................................</span>
          </div>
          <div>
            <p style="font-size: 12px;">الـتـوقـيــع: </b>
              <span>.........................................</span>
          </div>

        </div>
        <div style="width: 50%;float: right;text-align: center;">
          <div style="margin-bottom: 15px;">
            <p style="font-size: 12px;">اسم الـطـالـب: </b>
              <span>.........................................</span>
          </div>
          <div>
            <p style="font-size: 12px;">الـتـوقـيــع: </b>
              <span>.........................................</span>
          </div>
        </div>
        <div style="clear: both;"></div>
      </div>
    </div>
</body>

</html>