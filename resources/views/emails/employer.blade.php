<!DOCTYPE html>
<html>
<head>

<h3>Hi You have successfully registered with us. Please find the below login details</h3>

<table width="100%">
  <tr>
    <th>User name</th>
    <td>{{ $details['email'] }}</td>
  </tr>
  <tr>
    <th>Password</th>
    <td>{{ $details['password'] }}</td>
  </tr>
  <tr>
    <th>Login Url</th>
    <td><a target="_blank" href="{{ $details['url'] }}">{{ $details['url'] }}</a></td>
  </tr>
  
  <tr>
    <td></td>
  </tr>
  <tr>
    <td></td>
  </tr>
  <tr>
    <td></td>
  </tr>
  
  <tr>
    <td>Thanks</td>
  </tr>
  <tr>
    <td colspan="2">Careefer Team</td>
  </tr>
</table>

</body>
</html>