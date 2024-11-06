<?php
//Judith Esther Arévalo Guardaddo

// EJERCICIO 1: Problema de la serie Fibonacci
function generarFibonacci($n) {
    $serie = [0, 1]; // Inicializa la serie con los dos primeros números

    // Genera la serie hasta obtener n términos
    for ($i = 2; $i < $n; $i++) {
        $serie[] = $serie[$i - 1] + $serie[$i - 2]; // Cada número es la suma de los dos anteriores
    }

    return array_slice($serie, 0, $n); // Retornamos solo los primeros n términos
}
$n = 10;
echo "Serie Fibonacci de los primeros $n términos: ";
print_r(generarFibonacci($n));


// EJERCICO 2: Problema de números primos
function esPrimo($numero) {
    if ($numero <= 1) { // Si el número que recibe la función es menor o igual a 1 no es primo
        return false; 

    // Se va a dividir por los números hasta la raíz cuadrada del número ingresado
    for ($i = 2; $i <= sqrt($numero); $i++) {
        if ($numero % $i == 0) {
            return false; // Si es divisible por algún número, no es primo
        }
    }
    return true; // Si no fue divisible por ningún número, es primo
}
}
$numero = 17;
echo "\nEl número $numero" . (esPrimo($numero) ? " es primo" : "no es primo");


// EJERCICIO 3: Problema de Palíndromos
function esPalindromo($cadena) {
    $cadena = strtolower(preg_replace("/[^A-Za-z0-9]/", '', $cadena)); // preg_replace es una funcion de php que busca (en este caso con "/[^A-Za-z0-9]/") todos los elementos que no sean una letra o un numero y los reemplaza con el string vacío.
    $reversa = strrev($cadena); // Invertimos la cadena para comparar

    return $cadena === $reversa; // Si son iguales, es palíndromo
}


$texto = "Anita lava la tina";
echo "\n¿La cadena \"$texto\" es un palíndromo? " . (esPalindromo($texto) ? "Sí" : "No");

?>
