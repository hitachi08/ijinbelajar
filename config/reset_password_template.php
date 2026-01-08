<?php
function resetPasswordEmailTemplate($resetLink)
{
    return '
<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"></head>
<body style="background:#f4f6f9;font-family:Arial">
<table width="100%">
<tr>
<td align="center" style="padding:30px">

<table width="600" style="background:#fff;border-radius:10px">
<tr>
<td style="background:#0d6efd;padding:25px;text-align:center">
<img src="cid:logo_undana" width="90"><br>
<h2 style="color:#fff;margin:0">Universitas Nusa Cendana</h2>
<p style="color:#e9ecef;margin:5px 0 0">
Sistem Izin Belajar Mahasiswa Asing
</p>
</td>
</tr>

<tr>
<td style="padding:30px">
<h3>Reset Password</h3>
<p>
Kami menerima permintaan reset password akun Anda.
Silahkan klik tombol di bawah ini:
</p>

<div style="text-align:center;margin:30px 0">
<a href="' . $resetLink . '"
style="background:#0d6efd;color:#fff;
padding:14px 30px;border-radius:6px;
text-decoration:none">
RESET PASSWORD
</a>
</div>

<p><b>Link berlaku 30 menit.</b></p>

<p>
Jika Anda tidak merasa melakukan permintaan ini,
silahkan abaikan email ini.
</p>

<hr>
<p style="font-size:13px;color:#777">
Administrator Sistem Izin Belajar UNDANA
</p>
</td>
</tr>

<tr>
<td style="background:#f1f3f5;text-align:center;font-size:12px;padding:15px">
© ' . date('Y') . ' Universitas Nusa Cendana
</td>
</tr>
</table>

</td>
</tr>
</table>
</body>
</html>';
}
