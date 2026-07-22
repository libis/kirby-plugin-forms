<p style="font-family: Arial, sans-serif; font-size: 16px;">
  Cher/Chère <?= $data['email'] ?>,<br><br>
  Merci d'avoir rempli le formulaire sur notre site web. Nous avons bien reçu votre message et nous vous contacterons dès que possible.<br><br>
  Vous trouverez ci-dessous une copie des informations que vous avez fournies :<br>
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
  Si quelque chose n'est pas correct ou si vous souhaitez ajouter des informations supplémentaires, vous pouvez toujours répondre à cet e-mail.<br><br>
  Cordialement,<br>
  ... team
</p>
