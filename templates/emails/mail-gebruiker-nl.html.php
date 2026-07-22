<p style="font-family: Arial, sans-serif; font-size: 16px;">
  Beste <?= $data['email'] ?>,<br><br>
  Bedankt voor het invullen van het formulier op onze website. We hebben je bericht goed ontvangen en nemen zo snel mogelijk contact met je op.<br><br>
  Hieronder vind je een kopie van de gegevens die je hebt doorgegeven:<br>
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
  Mocht er iets niet kloppen of wil je nog extra informatie toevoegen, dan kan je steeds reageren op deze e-mail.<br><br>
  Met vriendelijke groeten,<br>
  ... team
</p>
