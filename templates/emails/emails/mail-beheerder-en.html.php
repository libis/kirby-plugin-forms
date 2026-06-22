<p style="font-family: Arial, sans-serif; font-size: 16px;">
  Dear colleague,<br><br>
  A new form has just been submitted via the website. Below you will find the details the user has provided:<br><br>
</p>

<table cellpadding="0" cellspacing="0" border="0" width="100%" style="font-family: Arial, sans-serif; font-size: 14px;">
  <tr>
    <td style="font-size: 18px; font-weight: bold; padding-bottom: 10px;">Values</td>
  </tr>
  <tr>
    <td>
      <table cellpadding="5" cellspacing="0" border="0" width="100%" style="border-collapse: collapse;">
        <?php foreach ($data as $key => $value): ?>
            <tr>
                <td style="font-weight: bold; width: 30%;"><?= ucfirst($key) ?></td>
                <td><?= $value ?></td>
            </tr>
        <?php endforeach; ?>
      </table>
    </td>
  </tr>
</table>

<p style="font-family: Arial, sans-serif; font-size: 16px;">
  <br>
  If necessary, you can contact the user through the email address they entered above. Please do not reply to this email, it is not linked to the user's email address.<br><br>
  Kind regards,<br>
  ... team
</p>