<?

class ElementController extends ConfigContainer {
	
	// List of subordinate classes
	protected $listSC = array(
		'Col',
		'Content',
		'InputField',
		'PanelBody',
		'PanelHeading',
		'PanelPrimary',
		'Row',
	);
	
	protected $storage;
	protected $senior;
	protected $primary;
	protected $col;
	
	public function __construct()
	{
		$this->storage = new Container();
	}
	
	
	public function configAllElements( $configs )
	{
		for( $i = 0; $i < count( $configs->objNames ); $i++ )	
			$this->createClass( $configs->objNames[$i] );
		
		for( $i = 0; $i < $this->storage->size(); $i++ ){
			$obj = $this->storage->pop($i);
			$properties[$i] = $obj->getProperty( 'requiredFields' );			
		}
		for( $i = 0; $i < count( $properties ); $i++ ){
			for( $j = 0; $j < count( $properties[$i] ); $j++ ){
				$key[$j] = $properties[$i][$j];
			}
			for( $j = 0; $j < count( $properties[$i] ); $j++ ){
				$value[$j] = $configs->objProperties[$i][$j];
			}
			for( $j = 0; $j < count( $properties[$i] ); $j++ ){
				$vip = array( $key[$j]=>$value[$j] );
				$this->storage->pop( $i )->setVIP( $vip );
			}
		}
	}
	
	
	protected function setHTMLCode( $arr )
	{
		$junior = $arr[0];
		$senior = $arr[1];
		$content = $junior->getHTMLCode();
		$config = array(
			'content' => $content
		);
		$senior->pushVIP( $config );
		return $senior;
	}	
	
	
	protected function conformity($seniorName)
	{
		$st = $this->storage;
		for($i = 0; $i < $st->size(); $i++ ){
			$value = $st->pop($i);
			$name = $value->getProperty('name');
			if( $seniorName == $name ){
				$result = $value;
				$this->rewriteStorage($i);
				break;
			} else $result = $this->senior;
		}
		
		return $result;
	}
	
	
	protected function rewriteStorage( $index )
	{
		$cash 	= new Container();
		$st 	= $this->storage;
		
		for( $i = 0; $i < $st->size(); $i++ ){
			if( $i != $index ){
				$cash->push( $st->pop($i) );
			}
		}
		
		$this->storage = $cash;
	}
	
	
	public function hierarchy( $junior )
	{
		$this->hierarchyRecovery( $junior );
		$this->rewriteStorage(0);
		
/*		////////////////////////////////////////////
		foreach( $this->storage->getC() as $value )
			echo $value->getProperty( 'name' ) . ' ';
		echo '<br>';	
*/		////////////////////////////////////////////
		
		if( $this->senior != null && 
			$this->senior->getProperty('name') != 'PanelPrimary' &&
			$this->senior->getProperty('name') != 'Col'
		){
			echo 'ATATA   ' . $this->senior->getProperty('name');
			$seniorName = $this->senior->getProperty('name');
			$senior = $this->conformity($seniorName);
			$attachment = array( $junior, $this->senior );
			$senior = $this->setHTMLCode( $attachment );
			$this->senior = $senior;
			$this->storage->push( $this->senior );
		
		// далее будет рекурсия
	//		$this->hierarchy( $this->storage->pop(0) );
		
		} elseif ( $this->senior->getProperty('name') == 'PanelPrimary'){
/*			////////////////////////////////////////////
			echo $this->primary->getHTMLCode();
*/			////////////////////////////////////////////
			$attachment = array( $junior, $this->primary );
			$senior = $this->setHTMLCode( $attachment );
			$this->primary = $senior;

			////////////////////////////////////////////
			echo $this->primary->getHTMLCode();
			////////////////////////////////////////////
		} elseif ( $this->senior->getProperty('name') == 'Col' &&
			$this->storage->size() == 0
		){
			echo 'Сделал еще один фильтр';
		}
		
/*		////////////////////////////////////////////
		echo $junior->		getHTMLCode();
		echo $this->senior->getHTMLCode();
		echo '<br>';
*/		////////////////////////////////////////////
		
		
	}
	
	protected function hierarchyRecovery( $obj )
	{
		$senior = $obj->getProperty( 'seniorObj' );
		if( $senior != null ){
			$this->createSenior($senior);
		} else $this->senior = null;
	}
	
	protected function createClass( $name )
	{
		$obj = new $name();
		$this->storage->push( $obj );
	}

	protected function createSenior( $name )
	{
		$obj = new $name();
		$this->senior = $obj;
	}
	
	
	protected function searchPrimary()
	{
		$st = $this->storage;
		for( $i = 0; $i < $st->size(); $i++ ){
			if( $st->pop($i)->getProperty('name') == 'PanelPrimary' ){
				$this->primary = $st->pop($i);
				$this->rewriteStorage($i);
				break;
			} else $this->primary = new PanelPrimary();
		}
/*		////////////////////////////////////////////
		echo $this->primary->getProperty('seniorObj') . 'Это работает<br>';
*/		////////////////////////////////////////////
	}
	
	
	protected function searchCol()
	{
		$st = $this->storage;
		for( $i = 0; $i < $st->size(); $i++ ){
			if( $st->pop($i)->getProperty('name') == 'Col' ){
				$this->col = $st->pop($i);
				$this->rewriteStorage($i);
				break;
			}
		}
		////////////////////////////////////////////
		echo $this->col->getProperty('width') . '<br>';
		////////////////////////////////////////////
	}
	
	
	// receives an array of names
	public function processing( $configs )
	{
		$this->configAllElements( $configs );
		$this->searchPrimary();
		$this->searchCol();
		// вынести col аналогично primary в отдельное свойство
		// далее выставить правила вызова иерархии 
/*		////////////////////////////////////////////
			echo $this->primary->getHTMLCode();
*/		////////////////////////////////////////////
		$this->hierarchy( $this->storage->pop(0) );
		$this->hierarchy( $this->storage->pop(0) );
		$this->hierarchy( $this->storage->pop(0) );
	
	
		////////////////////////////////////////////
		if( $this->storage->size() != 0 ){
			foreach( $this->storage->getC() as $value )
				echo  '\|/' . $value ->getProperty('name') . ' ';
		
			echo '<br>';	
		} else 'Хранилище пустует <br>';
		////////////////////////////////////////////
	//	$this->hierarchy( $this->storage->pop(0) );
	}
	
}

?>