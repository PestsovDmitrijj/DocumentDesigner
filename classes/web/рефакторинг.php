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
	protected $seniors;
	
	public function __construct()
	{
		$this->storage = new Container();
		$this->seniors = new Container();
	}
	
	public function configAllElements( $configs )
	{
		for( $i = 0; $i < count( $configs->objNames ); $i++ )	
			$this->createClass( $configs->objNames[$i] );
		
		for( $i = 0; $i < $this->storage->size(); $i++ ){
			
			$obj = $this->storage->pop($i);
			
			print_r( $obj->getProperty( 'requiredFields' ) );
			$properties[$i] = $obj->getProperty( 'requiredFields' );
			echo '<br>';
			
		}
		for( $i = 0; $i < count( $properties ); $i++ ){
			for( $j = 0; $j < count( $properties[$i] ); $j++ ){
				echo $properties[$i][$j] . ' ';
				$key[$j] = $properties[$i][$j];
			}
			echo ' Values: ';
			for( $j = 0; $j < count( $properties[$i] ); $j++ ){
				echo $configs->objProperties[$i][$j] . ' ';
				$value[$j] = $configs->objProperties[$i][$j];
			}
			echo '<br>';
			for( $j = 0; $j < count( $properties[$i] ); $j++ ){
				$vip = array( $key[$j]=>$value[$j] );
				$this->storage->pop( $i )->setVIP( $vip );
				echo '=!=' . $this->storage->pop( $i )->getProperty( $key[$j] ) . ' ';
			}
			echo '<br>';
		}
	}
	
	protected function setHTMLCode( $arr )
	{
		$junior = $arr[0];
		$senior = $arr[1];
		$content = $junior->getHTMLCode();
		echo $content;
		$config = array(
			'content',
			$content
		);
		$senior->setVIP( $config );
		echo '!!!' . $senior->getHTMLCode();
		return $senior;
	}	
	
	public function hierarchy( $arrObjs )
	{
		foreach( $arrObjs as $value ){
			$this->hierarchyRecovery( $value );
		}
		$newElts = new Container();
		foreach( $arrObjs as $value ){
			$name = $value->getProperty( 'seniorObj' );
			$obj = $this->conformity( $name );
			$name1 = $value->getProperty( 'name' );
			$name2 = $obj->getProperty( 'name' );
			echo $value->getProperty( 'name' ) . ' -> ' . $obj->getProperty( 'name' );
			if( $name1 != $name2 ){
				$arr = array(
					$value, 
					$obj
				);
				$newElts->push( $this->setHTMLCode( $arr ) );
			}		
			
		}
		$this->storage = null;
		$this->storage = new Container();
		for( $i = 0; $i < $newElts->size(); $i++ ){
			$this->storage->push( $newElts->pop($i) );	
		}
		
		echo '<br>';
		foreach( $this->storage->getC() as $value ){
			echo $value->getProperty('name') . '!#!#!#!#!#!#!#';
		}
		
			$this->senior = null;
			$this->senior = new Container();
		
	}
	
	protected function conformity( $name )
	{
		foreach( $this->seniors->getC() as $value ){
			$senior = $value->getProperty('name');
			if( $name == $senior ){
				return $value;
			} else {
				foreach( $this->seniors->getC() as $value ){
					if( $value->getProperty( 'seniorObj' ) == null ){
						return $value;
					}
				}
			}
		}
	}
	
	protected function hierarchyRecovery( $obj )
	{
		$senior = $obj->getProperty( 'seniorObj' );
		if( $senior != null ){
			$this->createSeniors($senior);
		}
	}
	
	protected function createClass( $name )
	{
		$obj = new $name();
		$this->storage->push( $obj );
	}

	protected function createSeniors( $name )
	{
		$obj = new $name();
		$this->seniors->push( $obj );
	}
	
	// receives an array of names
	public function processing( $configs )
	{
		$this->configAllElements( $configs );
		foreach( $this->storage->getC() as $value ){
			echo $value->getHTMLCode();
		}
		$this->hierarchy( $this->storage->getC() );
		foreach( $this->storage->getC() as $value ){
			echo $value->getHTMLCode();
		}
		$this->hierarchy( $this->storage->getC() );
		foreach( $this->storage->getC() as $value ){
			echo 'debug';
			echo $value->getHTMLCode();
		}
		
	}
	
}

?>