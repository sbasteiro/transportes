<?php

/**
 * Representa un camión que transporta cargas con hojas de ruta.
 */
class Camion {

    /** @var string Modelo del camión. */
    private string $modelo;

    /** @var string Patente del camión. */
    private string $patente;

    /** @var float Peso máximo soportado por el camión en kg. */
    private float $pesoMaximo;

    /** @var float Volumen máximo soportado por el camión en metros cúbicos. */
    private float $volumenMaximo; 

    /** @var HojaDeRuta|null Hoja de ruta asignada al camión. */
    private ?HojaDeRuta $hojaDeRutaAsignada = null;

    // Método para acceder al valor de la propiedad privada
    public function getHojaDeRutaAsignada() {
        return $this->hojaDeRutaAsignada;
    }


    /**
     * Constructor del camión.
     *
     * @param string $modelo Modelo del camión.
     * @param string $patente Patente del camión.
     * @param float $pesoMaximo Peso máximo en kilogramos.
     * @param float $volumenMaximo Volumen máximo en metros cúbicos.
     */
    public function __construct(string $modelo, string $patente, float $pesoMaximo, float $volumenMaximo) {
        $this->modelo = $modelo;
        $this->patente = $patente;
        $this->pesoMaximo = $pesoMaximo;
        $this->volumenMaximo = $volumenMaximo;
    }

     /**
     * Asigna una hoja de ruta al camión.
     *
     * @param HojaDeRuta $hojaDeRuta Hoja de ruta a asignar.
     * @throws Exception Si la hoja de ruta excede las capacidades del camión.
     */
    public function asignarHojaDeRuta(HojaDeRuta $hojaDeRuta): void {
        $pesoTotal = $hojaDeRuta->calcularPesoTotal();
        $volumenTotal = $hojaDeRuta->calcularVolumenTotal();

        if ($pesoTotal > $this->pesoMaximo || $volumenTotal > $this->volumenMaximo) {
            throw new Exception('La hoja de ruta excede las capacidades del camión.');
        }

        $this->hojaDeRutaAsignada = $hojaDeRuta;
    }
}

/**
 * Representa una hoja de ruta que contiene viajes y otras hojas de ruta.
 */
class HojaDeRuta {

     /** @var Viaje[] Lista de viajes en la hoja de ruta. */
    private array $viajes = [];

    /** @var HojaDeRuta[] Lista de hojas de ruta anidadas. */
    private array $hojasDeRuta = [];

    /**
     * Agrega un viaje a la hoja de ruta.
     *
     * @param Viaje $viaje Viaje a agregar.
     */
    public function agregarViaje(Viaje $viaje): void {
        $this->viajes[] = $viaje;
    }

    /**
     * Agrega una hoja de ruta anidada.
     *
     * @param HojaDeRuta $hojaDeRuta Hoja de ruta a agregar.
     */
    public function agregarHojaDeRuta(HojaDeRuta $hojaDeRuta): void {
        $this->hojasDeRuta[] = $hojaDeRuta;
    }

    /**
     * Calcula el costo total de la hoja de ruta.
     *
     * @return float Costo total en pesos.
     */
    public function calcularCosto(): float {
        $costoTotal = 0;

        foreach ($this->viajes as $viaje) {
            $costoTotal += $viaje->calcularCosto();
        }

        foreach ($this->hojasDeRuta as $hoja) {
            $costoTotal += $hoja->calcularCosto();
        }

        return $costoTotal;
    }

    /**
     * Calcula el peso total de todos los viajes y hojas de ruta.
     *
     * @return float Peso total en kilogramos.
     */
    public function calcularPesoTotal(): float {
        $pesoTotal = 0;

        foreach ($this->viajes as $viaje) {
            $pesoTotal += $viaje->calcularPesoTotal();
        }

        foreach ($this->hojasDeRuta as $hoja) {
            $pesoTotal += $hoja->calcularPesoTotal();
        }

        return $pesoTotal;
    }

    /**
     * Calcula el peso total de todos los viajes y hojas de ruta.
     *
     * @return float Peso total en kilogramos.
     */
    public function calcularVolumenTotal(): float {
        $volumenTotal = 0;

        foreach ($this->viajes as $viaje) {
            $volumenTotal += $viaje->calcularVolumenTotal();
        }

        foreach ($this->hojasDeRuta as $hoja) {
            $volumenTotal += $hoja->calcularVolumenTotal();
        }

        return $volumenTotal;
    }
}


/**
 * Calcula el peso total de todos los viajes y hojas de ruta.
 *
 * @return float Peso total en kilogramos.
 */
abstract class Viaje {

    /** @var float Peso total del viaje en kilogramos. */
    protected float $pesoTotal;

    /** @var float Volumen total del viaje en metros cúbicos. */
    protected float $volumenTotal;

    /** @var Coordenada Origen del viaje. */
    protected Coordenada $origen;

     /** @var Coordenada Destino del viaje. */
    protected Coordenada $destino;

    /**
     * Constructor del viaje.
     *
     * @param float $pesoTotal Peso total en kilogramos.
     * @param float $volumenTotal Volumen total en metros cúbicos.
     * @param Coordenada $origen Coordenada de origen.
     * @param Coordenada $destino Coordenada de destino.
     */
    public function __construct(float $pesoTotal, float $volumenTotal, Coordenada $origen, Coordenada $destino) {
        $this->pesoTotal = $pesoTotal;
        $this->volumenTotal = $volumenTotal;
        $this->origen = $origen;
        $this->destino = $destino;
    }

    /**
     * Calcula el costo del viaje.
     *
     * @return float Costo del viaje.
     */
    abstract public function calcularCosto(): float;

    /**
     * Calcula la distancia entre el origen y el destino del viaje.
     *
     * @return float Distancia en kilómetros.
     */
    public function calcularDistancia(): float {
        return self::calcularDistanciaEntrePuntos(
            $this->origen->getLatitud(),
            $this->origen->getLongitud(),
            $this->destino->getLatitud(),
            $this->destino->getLongitud()
        );
    }
    
    /**
     * Calcula la distancia en kilómetros entre dos puntos geográficos.
     *
     * @param float $latitude1 Latitud del punto 1.
     * @param float $longitude1 Longitud del punto 1.
     * @param float $latitude2 Latitud del punto 2.
     * @param float $longitude2 Longitud del punto 2.
     * @return float Distancia en kilómetros.
     */
    public static function calcularDistanciaEntrePuntos(
        float $latitude1,
        float $longitude1,
        float $latitude2,
        float $longitude2
    ): float {
        $theta = $longitude1 - $longitude2; 
        $distance = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + 
                    (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta))); 
        $distance = acos($distance); 
        $distance = rad2deg($distance); 
        $distance = $distance * 60 * 1.1515; 
        $distance = $distance * 1.609344;
        return round($distance, 2); 
    }
    
    
    /**
     * Obtiene el peso total del viaje.
     *
     * @return float Peso total en kilogramos.
     */
    public function calcularPesoTotal(): float {
        return $this->pesoTotal;
    }

      /**
     * Obtiene el volumen total del viaje.
     *
     * @return float Volumen total en metros cúbicos.
     */
    public function calcularVolumenTotal(): float {
        return $this->volumenTotal;
    }
}

/**
 * Representa un viaje normal con un costo basado en el peso y la distancia.
 */
class ViajeNormal extends Viaje {

    /**
     * Calcula el costo del viaje normal.
     *
     * @return float Costo del viaje basado en el peso y la distancia.
     */
    public function calcularCosto(): float {
        $km = $this->calcularDistancia();
        return 2 * $this->pesoTotal * $km;
    }
}

/**
 * Representa un viaje prioritario con un costo mayor basado en peso o volumen.
 */
class ViajePrioritario extends Viaje {

    /**
     * Calcula el costo del viaje prioritario.
     *
     * @return float Costo del viaje basado en el mayor valor entre peso y volumen.
     */
    public function calcularCosto(): float {
        $km = $this->calcularDistancia();
        $costoPeso = 4 * $this->pesoTotal * $km;
        $costoVolumen = 10 * $this->volumenTotal * $km;
        return max($costoPeso, $costoVolumen);
    }
}

/**
 * Representa un viaje de devolución con un costo fijo.
 */
class ViajeDevolucion extends Viaje {

    /**
     * Calcula el costo del viaje de devolución.
     *
     * @return float Costo fijo del viaje de devolución.
     */
    public function calcularCosto(): float {
        return 1000; 
    }
}

/**
 * Representa una coordenada geográfica.
 */
class Coordenada {

     /** @var float Latitud de la coordenada. */
    private float $latitud;

    /** @var float Longitud de la coordenada. */
    private float $longitud;

    /**
     * Constructor de una coordenada.
     *
     * @param float $latitud Latitud de la coordenada.
     * @param float $longitud Longitud de la coordenada.
     */
    public function __construct(float $latitud, float $longitud) {
        $this->latitud = $latitud;
        $this->longitud = $longitud;
    }

    /**
     * Obtiene la latitud de la coordenada.
     *
     * @return float Latitud.
     */
    public function getLatitud(): float {
        return $this->latitud;
    }

    /**
     * Obtiene la longitud de la coordenada.
     *
     * @return float Longitud.
     */
    public function getLongitud(): float {
        return $this->longitud;
    }
}

// Ejemplo de uso:

// Coordenadas de origen y destino.
$origen = new Coordenada(-34.6037, -58.3816); //PRUEBA BUENOS AIRES
$destino = new Coordenada(-32.9468, -60.6393); //PRUEBA ROSARIO

// Creación de viajes.
$viaje1 = new ViajeNormal(5000, 20, $origen, $destino);
$viaje2 = new ViajePrioritario(4000, 15, $origen, $destino);

// Creación de la hoja de ruta.
$hojaDeRuta = new HojaDeRuta();
$hojaDeRuta->agregarViaje($viaje1);
$hojaDeRuta->agregarViaje($viaje2);

// Asignación de la hoja de ruta a un camión.
$camion = new Camion("Modelo X", "AB123CD", 10000, 50);
$camion->asignarHojaDeRuta($hojaDeRuta);

// Cálculo del costo total de la hoja de ruta.
echo "Costo total de la hoja de ruta: $" . $hojaDeRuta->calcularCosto();