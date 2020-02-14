
<table class="table">
  <thead>    
    <tr>
      <th>uid</th>
      <th>姓名</th>
      <th>電話</th>
      <th>email</th>
    </tr>
  </thead>
  <tbody>
    <{foreach $rows as $row}>
      <tr>
        <td><{$row.name}></td>
        <td><{$row.tel}></td>
        <td><{$row.email}></td>
      </tr>
    <{foreachelse}>
      <tr colspan=3>
        目前沒有資料
      </tr>
    <{/foreach}>
  </tbody>
</table>