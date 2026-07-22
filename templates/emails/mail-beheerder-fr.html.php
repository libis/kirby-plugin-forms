<p style="font-family: Arial, sans-serif; font-size: 16px;">
  Cher collègue,<br><br>
  Un nouveau formulaire vient d'être soumis via le site web. Vous trouverez ci-dessous les détails fournis par l'utilisateur:<br><br>
</p>

<table cellpadding="0" cellspacing="0" border="0" width="100%" style="font-family: Arial, sans-serif; font-size: 14px;">
  <tr>
    <td style="font-size: 18px; font-weight: bold; padding-bottom: 10px;">Faits</td>
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
  Si nécessaire, vous pouvez contacter l'utilisateur via l'adresse e-mail indiquée ci-dessus. Veuillez ne pas répondre à cet e-mail, il n'est pas lié à l'adresse e-mail de l'utilisateur.<br><br>
  Cordialement,<br>
  ... team
</p>