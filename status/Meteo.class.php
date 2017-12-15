<?php
class Meteo
{
	private $temperatura='';
	private $wilgotnosc='';
	private $cisnienie='';
	private $szerokosc='';
	private $wysokosc='';
	private $idtmp='';
	private $idpre='';
	private $idhum='';
	private $sila_grawitacji=''; //si³a grawitacji
	private $temp_znormalizowana=''; //temperatura znormalizowana K
	private $tz=''; //temperatura znormalizowana C
	private $cz=''; //ciœnienie znormalizowane
	private $tpr=''; //temperatura punktu rosy
	private $cisnienie_pary_nasyconej=''; //ciœnienie pary nasyconej
	private $cisnienie_pary=''; //ciœnienie pary wodnej
	private $wb=''; //wilgotnoœæ bezwzglêdna
	
    protected $sql = array(
	'getOnOff' => "SELECT onoff FROM meteo WHERE id= :id",
	'getDataById' => 'SELECT * FROM meteo  WHERE id = :id'
	);
	
	function __construct()
	{
		$this->get_data();
		$this->meteo();
	}
	
	function get_data()
	{
		$root=$_SERVER["DOCUMENT_ROOT"];
		$db = new PDO("sqlite:$root/dbf/nettemp.db") or die("cannot open the database");
		$met1 = $db->prepare("SELECT * FROM meteo WHERE id='1'");
		$met1->execute();
		$resultmet1 = $met1->fetchAll();
		foreach ($resultmet1 as $me) { 
			$this->szerokosc=$me['latitude'];
			$this->wysokosc=$me['height'];
			$this->idtmp=$me['temp'];
			$this->idpre=$me['pressure'];
			$this->idhum=$me['humid'];
		}

		$sth = $db->prepare("select tmp from sensors where id='$this->idtmp'");
		$sth->execute();
		$result = $sth->fetchAll();
		foreach ($result as $a) {
		$this->temperatura=$a['tmp'];
		}

		$sth = $db->prepare("select tmp from sensors where id='$this->idpre'");
		$sth->execute();
		$result = $sth->fetchAll();
		foreach ($result as $a) {
		$this->cisnienie=$a['tmp'];
		}

		$sth = $db->prepare("select tmp from sensors where id='$this->idhum'");
		$sth->execute();
		$result = $sth->fetchAll();
		foreach ($result as $a) {
		$this->wilgotnosc=$a['tmp'];
		}
	}
	
	function meteo(){
		//$meteo_status = new _View('status_meteo.phtml');
		//$this->model_sensors = new model_Sensors;
		
		//$display = $this->getOnOff(array('id' => 1))[0]->onoff;
		//if ($display == "on") {

		$this->sila_grawitacji=9.780313*(pow(1+0.005324*SIN(1*$this->szerokosc),2)-0.0000058*pow(SIN(2*$this->szerokosc),2)-0.000003085*$this->wysokosc);
		$this->temp_znormalizowana=((2*($this->temperatura+273.15))+((0.6*$this->wysokosc)/100))/2;
		$this->tz=$this->temp_znormalizowana-273.15;
		$this->cz=($this->cisnienie*(EXP(($this->sila_grawitacji*$this->wysokosc)/(287.05*$this->temp_znormalizowana)))*10)/10;
		$this->tpr=243.12*(((LOG10($this->wilgotnosc)-2)/0.4343)+(17.5*$this->temperatura)/(243.12+$this->temperatura))/(17.62-(((LOG10($this->wilgotnosc)-2)/0.4343)+(17.5*$this->temperatura)/(243.12+$this->temperatura)));
		$this->cisnienie_pary_nasyconej=6.112*EXP((17.67*$this->temperatura)/($this->temperatura+243.5));
		$this->cisnienie_pary=$this->wilgotnosc/(1/$this->cisnienie_pary_nasyconej)/100;
		$this->wb=2165*(($this->cisnienie_pary/10)/(273.15+$this->temperatura));
		
		return true;
	}
	
	function getSilaGrawitacji()
	{
		return $this->sila_grawitacji;
	}
	
	function getTemperaturaZnormalizowana()
	{
		return $this->temp_znormalizowana;
	}
	
	function getCisnienieZnormalizowane()
	{
		return $this->cz;
	}
	
	function getTpr()
	{
		return $this->tpr;
	}
	
	function getCisnienieParyNasyconej()
	{
		return $this->cisnienie_pary_nasyconej;
	}
	
	function getCisnieniePary()
	{
		return $this->cisnienie_pary;
	}
	function getWb()
	{
		return $this->wb;
	}
}
