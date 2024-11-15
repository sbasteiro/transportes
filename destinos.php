<?php

$ejemploDestinos1 = [
  [
    "nombre" => "America", 
    "hijos" => [
      [
        "nombre" => "Argentina",
        "hijos" => [
          [
            "nombre" => "Buenos Aires", 
            "hijos" => [
              [
                "nombre" => "Pilar",
                "hijos" => [["nombre" => "Manzanares"]]
              ]
            ]
          ],
          ["nombre" => "Córdoba"]
        ],
      ],
      [
        "nombre" => "Venezuela",
        "hijos" => [
          ["nombre" => "Caracas"],
          ["nombre" => "Vargas"]
        ]
      ]
    ]
  ]
];

$ejemploDestinos2 = [
  [
    "nombre" => "America", 
    "hijos" => [
      [
        "nombre" => "Argentina",
        "hijos" => [
          ["nombre" => "Buenos Aires"],
          ["nombre" => "Córdoba"],
          ["nombre" => "Santa Fe"]
        ],
      ],
      [
        "nombre" => "EEUU",
        "hijos" => [
          ["nombre" => "Arizona"],
          ["nombre" => "Florida"]
        ]
      ]
    ]
  ],
  [
      "nombre" => "Europa",
      "hijos" => [
          ["nombre" => "España"],
          ["nombre" => "Italia"],
      ]
  ]
];

function buscarDestinos(array $destinos, string $substring) : array {
    $coincidencias = [];

    foreach ($destinos as $destino) {

        if (stripos($destino['nombre'], $substring) !== false) {
            $coincidencias[] = $destino['nombre'];
        }  

        if (isset($destino['hijos'])) {
            $coincidencias = array_merge($coincidencias, buscarDestinos($destino['hijos'], $substring));
        }
    }

    return $coincidencias;
}

// Ejemplo de búsqueda ingresando un texto
$coincidencias = buscarDestinos($ejemploDestinos2, "ar");
print_r($coincidencias); // Trae ARGENTINA Y ARIZONA

// Ejemplo para probar que no búsca solo por el comienzo del nombre de destino
$coincidencias = buscarDestinos($ejemploDestinos1, "ar");
print_r($coincidencias); // Trae ARGENTINA, PILAR, MANZANARES, CARACAS y VARGAS