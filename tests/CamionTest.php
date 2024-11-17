<?php
use PHPUnit\Framework\TestCase;

//Incluyo el archivo donde están todas las clases
require_once __DIR__ . '/../index.php'; 

/**
 * Clase de prueba
 */
class CamionTest extends TestCase {

    /** @var Camion Instancia de la clase Camion. */
    private $camion;

    /** @var HojaDeRuta Instancia de la clase HojaDeRuta. */
    private $hojaDeRuta;

    /** @var ViajeNormal Instancia de la clase ViajeNormal. */
    private $viajeNormal;

    /** @var ViajePrioritario Instancia de la clase ViajePrioritario. */
    private $viajePrioritario;


    /** @var Coordenada Coordenada de origen. */
    private $origen;

    /** @var Coordenada Coordenada de destino. */
    private $destino;

    protected function setUp(): void {
        // Inicialización de las coordenadas
        $this->origen = new Coordenada(-34.6037, -58.3816); // Buenos Aires
        $this->destino = new Coordenada(-32.9468, -60.6393); // Rosario

        // Creación de viajes
        $this->viajeNormal = new ViajeNormal(5000, 20, $this->origen, $this->destino);
        $this->viajePrioritario = new ViajePrioritario(4000, 15, $this->origen, $this->destino);

        // Creación de hoja de ruta 
        $this->hojaDeRuta = new HojaDeRuta();
        $this->hojaDeRuta->agregarViaje($this->viajeNormal);
        $this->hojaDeRuta->agregarViaje($this->viajePrioritario);

        // Aignación de la hoja de ruta
        $this->camion = new Camion("Modelo X", "AB123CD", 10000, 50);
        $this->camion->asignarHojaDeRuta($this->hojaDeRuta);
    }

    public function testCalcularCostoHojaDeRuta(): void {
        // Calcular el costo total de la hoja de ruta
        $costoTotal = $this->hojaDeRuta->calcularCosto();

        // Verificar que el costo total es el esperado
        $this->assertGreaterThan(0, $costoTotal, 'El costo total de la hoja de ruta debe ser mayor que 0');
    }

    public function testAsignarHojaDeRuta() {
        $camion = new Camion("Volvo", "AB100", "100", 30.5);
        $hojaDeRuta = new HojaDeRuta();
        
        $camion->asignarHojaDeRuta($hojaDeRuta);
        
        // Usamos el getter para verificar la propiedad, para no cambiar a publica la variable
        $this->assertSame($hojaDeRuta, $camion->getHojaDeRutaAsignada());
    }

    public function testCalcularDistancia(): void {
        // Calcular la distancia entre el origen y el destino
        $distancia = $this->viajeNormal->calcularDistancia();

        // Verificar que la distancia calculada es mayor que 0
        $this->assertGreaterThan(0, $distancia, 'La distancia calculada debe ser mayor que 0');
    }

    public function testExcepcionSiExcedeCapacidadesDelCamion(): void {
        // Crear una hoja de ruta que excede las capacidades del camión
        $hojaDeRutaExcedida = new HojaDeRuta();
        $viajeExcedido = new ViajeNormal(15000, 60, $this->origen, $this->destino); // Excede el peso y volumen
        $hojaDeRutaExcedida->agregarViaje($viajeExcedido);

        // Verificar que se lanza una excepción al intentar asignar esta hoja de ruta al camión
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('La hoja de ruta excede las capacidades del camión.');
        $this->camion->asignarHojaDeRuta($hojaDeRutaExcedida);
    }
}
