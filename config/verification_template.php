<?php

function verificationEmailTemplate($verifyLink)
{
    return '
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Verifikasi Email</title>
</head>
<body style="margin:0;padding:0;background:#f4f6f9;font-family:Arial,sans-serif;">
<table width="100%" cellpadding="0" cellspacing="0">
<tr>
<td align="center" style="padding:30px 0">

<table width="600" cellpadding="0" cellspacing="0"
       style="background:#ffffff;border-radius:10px;overflow:hidden;
              box-shadow:0 4px 10px rgba(0,0,0,.08)">

<!-- HEADER -->
<tr>
<td align="center" style="background:#0d6efd;padding:25px">
<img src="cid:logo_undana" width="90" style="margin-bottom:10px">
<h2 style="color:#fff;margin:0;font-weight:500">
Universitas Nusa Cendana
</h2>
<p style="color:#e9ecef;margin:5px 0 0">
Sistem Izin Belajar Mahasiswa Asing
</p>
</td>
</tr>

<!-- CONTENT -->
<tr>
<td style="padding:30px;color:#333">
<h3 style="margin-top:0">Verifikasi Email Anda</h3>

<p>
Terima kasih telah melakukan pendaftaran akun.
Untuk mengaktifkan akun Anda, silahkan lakukan verifikasi email
dengan menekan tombol di bawah ini:
</p>

<div style="text-align:center;margin:30px 0">
<a href="' . $verifyLink . '"
   style="background:#0d6efd;
          color:#ffffff;
          padding:14px 30px;
          border-radius:6px;
          font-size:16px;
          text-decoration:none;
          display:inline-block">
VERIFIKASI EMAIL
</a>
</div>

<p>
Link verifikasi ini hanya berlaku selama:
<b>24 jam</b>.
</p>

<p>
Jika Anda tidak merasa melakukan pendaftaran,
silahkan abaikan email ini.
</p>

<hr style="border:none;border-top:1px solid #eee;margin:30px 0">

<p style="font-size:13px;color:#777">
Salam hormat,<br>
<b>Administrator Sistem Izin Belajar</b><br>
Universitas Nusa Cendana
</p>
</td>
</tr>

<!-- FOOTER -->
<tr>
<td align="center"
    style="background:#f1f3f5;padding:15px;
           font-size:12px;color:#6c757d">
© ' . date('Y') . ' Universitas Nusa Cendana. All rights reserved.
</td>
</tr>

</table>

</td>
</tr>
</table>
</body>
</html>';
}
