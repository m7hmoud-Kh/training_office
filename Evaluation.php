<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <link href="css/Evaluation.css" rel="stylesheet" />
    <title>Evaluation</title>
  </head>
  <body dir="rtl">
    <div id="mother">
      <form name="Evaluation" class="form">
        <aside>
          <div>
            <h3>لوحة التقييم</h3>
            <br />
            <label>اسم الطالب </label><br />
            <input type="text" name="اسم الطالب" /><br />
            <label> الرقم القومي </label><br />
            <input type="number" name="الرقم القومي" /><br />
            <label>رقم المجموعة </label><br />
            <input type="number" name="رقم المجموعة" /><br />
            <label>الشعبة</label><br />
            <input type="text" name="الشعبة" /><br />
            <label>الفرقة </label><br />
            <input type="text" name="الفرقة" /><br />
            <label>عدد ايام الغياب </label><br />
            <input type="text" name="عدد ايام الغياب" /><br />
            <label>تقييم أول </label><br />
            <input type="number" name="تقييم أول" /><br />
            <label>تقييم ثاني </label><br />
            <input type="number" name="تقييم ثاني" /><br />
            <label>اسم المدرس المشرف</label><br />
            <input type="text" name="اسم المدرس المشرف" /><br />
            <button name="add">أضافة طالب</button>
            <button name="edit">تعديل طالب</button><br /><br />
          </div>
        </aside>
        <main>
          <table id="tbl">
            <tr>
              <th>اسم الطالب</th>
              <th>الرقم القومي</th>
              <th>رقم المجموعة</th>
              <th>الشعبة</th>
              <th>الفرقة</th>
              <th>عدد ايام الغياب</th>
              <th>تقييم أول</th>
              <th>تقييم ثاني</th>
              <th>اسم المدرس المشرف</th>
            </tr>
          </table>
        </main>
      </form>
    </div>
  </body>
</html>
