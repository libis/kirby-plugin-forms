<p style="font-family: Arial, sans-serif; font-size: 16px;">
  Dear <?= $data['email'] ?>,<br><br>
  Thank you for completing the form on our website. We have received your message and will contact you as soon as possible.<br><br>
  Below you will find a copy of the information you provided:<br>
</p>

<table cellpadding="0" cellspacing="0" border="0" width="100%" style="font-family: Arial, sans-serif; font-size: 14px;">
  <tr>
    <td style="font-size: 18px; font-weight: bold; padding-bottom: 10px;">Gegevens</td>
  </tr>
  <tr>
    <td>
      <table cellpadding="5" cellspacing="0" border="0" width="100%" style="border-collapse: collapse;">
        <?php foreach ($data as $key => $value): ?>
          <?php if($key != 'GDPR'): ?>
            <tr>
              <td style="font-weight: bold; width: 30%;"><?= ucfirst($key) ?></td>
              <td><?= $value ?></td>
            </tr>
          <?php endif; ?>
        <?php endforeach; ?>
      </table>
    </td>
  </tr>
</table>

<p style="font-family: Arial, sans-serif; font-size: 16px;">
  <br>
  If something is incorrect or if you would like to add additional information, you can always reply to this email.<br><br>
  Kind regards,<br>
  ... team
</p>
