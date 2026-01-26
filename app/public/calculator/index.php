<!-- 

====================================================
=                                                  =
=       dP  a8888a                                 =
=       88 d8' ..8b                                =
= .d888b88 88 .P 88 d888888b    .d8888b. dP    dP  =
= 88'  `88 88 d' 88    .d8P'    88ooood8 88    88  =
= 88.  .88 Y8'' .8P  .Y8P       88.  ... 88.  .88  =
= `88888P8  Y8888P  d888888P 88 `88888P' `88888P'  =
=                                                  =
====================================================
=                 CASTEL Maxime                    =
====================================================
=           IPSSI - BTC 27.1 - 20250124            =
====================================================

-->

<?php

/**
 * Returns the result of the operation between two numbers using the specified operator
 * @param float|int $num1
 * @param float|int $num2
 * @param string $operator
 * @return float|int
 */
function calculator($num1, $num2, $operator)
{
  switch ($operator) {
    case '+':
      return $num1 + $num2;
    case '-':
      return $num1 - $num2;
    case '*':
      return $num1 * $num2;
    case '/':
      if ($num2 != 0) {
        return $num1 / $num2;
      } else {
        throw new Exception("Cannot divide by zero");
      }
    case '%':
      if ($num2 != 0) {
        return $num1 % $num2;
      } else {
        throw new Exception("Cannot calculate modulo with zero");
      }
    case '^':
      return pow($num1, $num2);
    default:
      throw new Exception("Invalid operation");
  }
}

/**
 * Check if a number is set and valide
 * @param mixed $number
 */
function validateNumberInput($number)
{
  if (!isset($number)) throw new Exception("First number not set", 1);
  if (!is_numeric($number)) throw new Exception("First number not a number", 1);
  return $number;
}

/**
 * Format the result in HTML
 * @param float|int $result
 */
function formatResult($num1, $num2, $operator, $result)
{
  echo "<div class=\"alert alert-dark alert-dismissible fade show\" role=\"alert\">
              {$num1} {$operator} {$num2} = {$result}
              <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
            </div>";
}

/**
 * Checks if the current request is a POST request, 
 * if so handles the form inputs
 */
function formHandler()
{
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {

      if (!isset($_POST['operator'])) throw new Exception("Operator not set", 1);

      $num1 = validateNumberInput($_POST['num1']);
      $num2 = validateNumberInput($_POST['num2']);

      $operator = $_POST['operator'];
      $result = calculator($num1, $num2, $operator);
      formatResult($num1, $num2, $operator, $result);
    } catch (\Throwable $e) {
      echo "<div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">
              Error: {$e->getMessage()}
              <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
            </div>";
    }
  }
}

?>


<!doctype html>
<html lang="fr" data-bs-theme="dark">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PHP Procédural</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>

  <header class="p-5 bg-primary text-white text-center">
    <h1 class="p-3">PHP Calculator</h1>
  </header>

  <div class="container p-3 mt-5">
    <div class="card p-3">
      <?php formHandler(); ?>
      <form method="post" action="">
        <div class="mb-3">
          <label for="num1" class="form-label">First number</label>
          <input class="form-control" id="num1" name="num1">
        </div>
        <div class="mb-3">
          <label for="operator" class="form-label">Operator</label>
          <select class="form-select" id="operator" name="operator">
            <option value="">Select the operator</option>
            <option value="+">Addition</option>
            <option value="-">Subtraction</option>
            <option value="*">Multiplication</option>
            <option value="/">Division</option>
            <option value="%">Modulo</option>
            <option value="^">Power</option>
          </select>
        </div>
        <div class="mb-3">
          <label for="num2" class="form-label">Second number</label>
          <input class="form-control" id="num2" name="num2">
        </div>
        <button type="submit" class="btn btn-outline-success">Calculate</button>
      </form>
    </div>
  </div>



  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>