<?php
use PHPUnit\Framework\TestCase;
use App\Classes\WeatherApi;

class WeatherApiTest extends TestCase
{
    /**
     * Test quand il fait chaud (>= 30°C)
     */
    public function testIsHotReturnsTrueWhenTemperatureIs30OrMore()
    {
        $weatherApi = $this->createMock(WeatherApi::class);
        
        $weatherApi->method('getTemperature')
            ->with('Paris')
            ->willReturn(30.0);
        
        $this->assertTrue($weatherApi->isHot('Paris'));
    }

    /**
     * Test quand il ne fait pas chaud (< 30°C)
     */
    public function testIsHotReturnsFalseWhenTemperatureIsBelow30()
    {
        $weatherApi = $this->createMock(WeatherApi::class);
        
        $weatherApi->method('getTemperature')
            ->with('Paris')
            ->willReturn(20.0);
        
        $this->assertFalse($weatherApi->isHot('Paris'));
    }

    /**
     * Test avec plusieurs villes
     */
    public function testIsHotWithDifferentCities()
    {
        $weatherApi = $this->createMock(WeatherApi::class);
        
        $weatherApi->method('getTemperature')
            ->willReturnMap([
                ['Marseille', 35.0],
                ['Lille', 15.0],
                ['Lyon', 30.0],
            ]);
        
        $this->assertTrue($weatherApi->isHot('Marseille'));
        $this->assertFalse($weatherApi->isHot('Lille'));
        $this->assertTrue($weatherApi->isHot('Lyon'));
    }

    /**
     * Test avec une ville inconnue (l'API lance une exception)
     */
    public function testIsHotThrowsExceptionWhenCityNotFound()
    {
        $weatherApi = $this->createMock(WeatherApi::class);
        
        $weatherApi->method('getTemperature')
            ->with('Inconnue')
            ->will($this->throwException(new \Exception("Ville non trouvée")));
        
        $this->expectException(\Exception::class);
        
        $weatherApi->isHot('Inconnue');
    }
}