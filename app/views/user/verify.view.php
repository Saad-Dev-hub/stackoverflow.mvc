<!--//fantacydesigns.com/-->
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- include verify.css file here -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />
    <link rel="stylesheet" href="/assets/css/verify.css" />
    <title>Verify Account</title>
  </head>
  <body>
    <div class="container">
      <h2>Verify Your Account</h2>
      <?php  if(isset($code_error)) { ?>
        <div class="alert alert-danger w-50 mx-auto" role="alert">
         <b><?php print_r($code_error); ?></b> 
        </div>
      <?php } ?>
      <form method="POST">
      <p>We emailed you the Five digit code to <?php  isset($email)? print_r($email):''; ?> <br/> Enter the code below to confirm your email address.</p>
      <div class="code-container">
        <input type="number" name=ver[] class="code" placeholder="0" min="0" max="9" required>
        <input type="number"name=ver[] class="code" placeholder="0" min="0" max="9" required>
        <input type="number"name=ver[] class="code" placeholder="0" min="0" max="9" required>
        <input type="number"name=ver[] class="code" placeholder="0" min="0" max="9" required>
        <input type="number"name=ver[] class="code" placeholder="0" min="0" max="9" required>
      </div>
      <input type="submit" class="btn btn-primary" name="submit" value="Verify" />
      </form>
    </div>
    <script src="/assets/js/verify.js"></script>
  </body>
</html>