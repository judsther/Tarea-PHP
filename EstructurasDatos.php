<?php
// Ejercicios de lógica con estructuras de datos en PHP

//1. Problema de Lista Invertida: Escribe un programa que tome un array de números y devuelva una nueva lista que contenga los mismos elementos en orden inverso.
$array = [1,2,3,4,5,6,7];
function reverseArray($array){
    $result = [];
    $arrayLargor = count($array);
    
        for ($i = $arrayLargor -1; $i >= 0; $i--){
           $result[] = $array[$i];
        } 
        return $result;
};

print_r(reverseArray($array)); 

//2. Problema de Suma de Números Pares: Crea un script que sume todos los números pares en un array de números enteros.

$array2 = [1,2,3,4,5,6,7]; // suma de enteros debe dar = 12

function sumarPares($array2){
  $result2 = 0;
  $arraySize = count($array2);

for ($i = 0; $i <= $arraySize-1; $i++){

  if( $array2[$i] % 2 === 0 ){
    $result2 += $array2[$i]; 
  } 

}return $result2;

};

print_r( sumarPares($array2));

// 3. Problema de Frecuencia de Caracteres: Implementa una función que tome una cadena de texto y devuelva un array asociativo que muestre la frecuencia de cada carácter en la cadena.

$cadena = "abracadabra";

function frecuenciaCaracteres($cadena){
    $resultado = [];  
  
    for ($i = 0; $i < strlen($cadena); $i++) {
      $caracter = $cadena[$i]; 

      if (isset($resultado[$caracter])) {
        $resultado[$caracter]++; 
      } else {
        $resultado[$caracter] = 1;
      }
    }
    return $resultado; 
  }
  

  print_r(frecuenciaCaracteres($cadena));

  // 4.       Problema de Bucle Anidado: Escribe un programa que utilice bucles anidados para imprimir un patrón de asteriscos en forma de pirámide.


  function piramideAsteriscos($altura){
  
    for ($i = 1; $i <= $altura; $i++) {
  
      for ($j = $i; $j < $altura; $j++) {
        echo " ";
      }
  
      for ($k = 1; $k <= (2 * $i - 1); $k++) {
        echo "*"; 
      }
      echo "\n";  
    }
  }
  
  piramideAsteriscos(5);
  


