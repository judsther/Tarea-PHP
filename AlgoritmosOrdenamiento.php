<?php
// Actividad 5

// Implementación de Algoritmos de Ordenamiento

//1. Problema de Ordenar Lista con Bubble Sort: Escribe un programa que ordene una lista de números de forma descendente utilizando el algoritmo Bubble Sort. La lista puede contener duplicados y valores negativos. Asegúrate de manejar estos casos y muestra la lista antes y después de aplicar el algoritmo.

function bubbleSort($array){
 
    $largor = count($array);

    for ($i = 0; $i < $largor; $i++ ){
        
        for($j = 0; $j < $largor-1; $j++){

            if ($array[$j]<$array[$j+1]){
                $tempo = $array[$j];
                $array[$j] = $array[$j+1];
                $array[$j+1] = $tempo;
                
            };  
        };
    }return $array;
};

print_r(bubbleSort(bubbleSort([5,3,8,-1,2,1,0,7,6]))); 

/*
Array
(
[0] => 8
[1] => 7
[2] => 6
[3] => 5
[4] => 3
[5] => 2
[6] => 1
[7] => 0
[8] => -1
)
*/

//2. Problema de Ordenar Lista con Merge Sort: Implementa una función que ordene una lista de palabras alfabéticamente utilizando el algoritmo Merge Sort. Muestra la lista antes y después de aplicar el algoritmo.


function mergeSort($lista){

    if(count($lista) <= 1 ) return $lista;
  
    $middle = count($lista)/2;
  
    $left = array_slice($lista,0,$middle);
    $right = array_slice($lista,$middle);
  
    $left = mergeSort($left);
    $right = mergeSort($right);
    return merge($left, $right);
  }


  function merge($left,$right){
    $result = [];
  
    while(count($left) > 0 && count($right) > 0){
     if($left[0] <= $right[0]){
      array_push($result,array_shift($left));
     }else{
      array_push($result,array_shift($right));
     }
    }
    return array_merge($result, $left, $right);
  }
  print_r(mergeSort(["joy", "hope", "anchor", "fight", "five", "bless"]));

// $lista = ["joy", "hope", "anchor", "fight", "five", "bless"];
/*
 ordenada: 
 Array
(
    [0] => anchor
    [1] => bless
    [2] => fight
    [3] => five
    [4] => hope
    [5] => joy
)
 */

//3. Problema de Ordenar Lista con Insertion Sort: Crea un script que ordene una lista de nombres en orden alfabético utilizando el algoritmo Insertion Sort. Muestra la lista antes y después de aplicar el algoritmo.

function insertionSort($nombres){

    //if porque para ordenar hay que tener mas de un dato en el arreglo
    if(count($nombres)<= 1) return $nombres;
    
    for($i = 1; $i < count($nombres); $i++){
       $key= $nombres[$i]; 
       $j = $i - 1; 

       while ($j >= 0 && $nombres[$j] > $key){ 
        $nombres[$j+1]=$nombres[$j]; 
        $j--; 
       }
       $nombres[$j+1] = $key;
    } return $nombres;
  };

print_r(insertionSort(insertionSort(["Zara", "Ana", "Carlos", "Beatriz", "Daniel"])));

/*
 ordenada: 
 Array
(
     [0] => Ana
    [1] => Beatriz
    [2] => Carlos
    [3] => Daniel
    [4] => Zara
)
 */



?>
