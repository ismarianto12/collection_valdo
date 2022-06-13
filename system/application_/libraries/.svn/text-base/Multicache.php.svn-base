<?php

	class Multicache {

		function Multicache()
		{
			$this->config['cache_type'] = "memcache";
			// $this->config['cache_type'] = "apc";

			
			$this->config['memcache_servers'][] = array(
												'host' => '127.0.0.1',
												'port' => 11211
											);
			/* For multiple memcache
			$this->config['memcache_servers'][] = array(
												'host' => '192.168.0.1',
												'port' => 11211
											);
			*/
		
			$this->expire = 600;
			$this->connected_servers = array();
		
			$this->_connect();
		}
		
		function _connect()
		{
			switch ( $this->config['cache_type'] )
			{
				case 'memcache':
					if ( function_exists('memcache_connect') )
					{
						$this->memcache = new Memcache;
						$this->_connect_memcache();
					}
				break;

				case 'apc':
					// Nothing needs to be done here :)
				break;
			}
		}
		
		function _connect_memcache()
		{
			if ( !empty($this->config['servers']) )
			{
				// must turn off error reporting.
				// so memcache can die silently if
				// it can't connect to a server.

				$error_display = ini_get('display_errors');
				$error_reporting = ini_get('error_reporting');

				ini_set('display_errors', "Off");
				ini_set('error_reporting', 0);

				foreach ( $this->config['memcache_servers'] as $server )
				{
					if ( $this->memcache->addServer($server['host'], $server['port']) )
					{
						$this->connected_servers[] = $server;
					}
				}

				// back on again!

				ini_set('display_errors', $error_display);
				ini_set('error_reporting', $error_reporting);
			}
		}
		
		function get($key)
		{
			switch ( $this->config['cache_type'] )
			{
				case 'memcache':
				
					if ( empty($this->connected_servers) )
					{
						return false;
					}
	
					return $this->memcache->get($key);
					
				break;
				
				case 'apc':
					return apc_fetch($key);
				break;
			}
		}
		
		function set($key, $data)
		{
			switch ( $this->config['cache_type'] )
			{
				case 'memcache':
					if ( empty($this->connected_servers) )
					{
						return false;
					}
	
					return $this->memcache->set($key, $data, 0, $this->expire);
				break;
				
				case 'apc':
					apc_store($key, $data, $this->expire); 
				break;
			}
		}
		
		function replace($key, $data)
		{
			switch ( $this->config['cache_type'] )
			{
				case 'memcache':
					if ( empty($this->connected_servers) )
					{
						return false;
					}

					return $this->memcache->replace($key, $data, 0, $this->expire);
				break;

				case 'apc':
					apc_delete($key);
					apc_store($key, $data, $this->expire); 
				break;
			}
		}
		
		function delete($key, $when = 0)
		{
			switch ( $this->config['cache_type'] )
			{
				case 'memcache':
					if ( empty($this->connected_servers) )
					{
						return false;
					}

					return $this->memcache->delete($key, $when);
				break;

				case 'apc':
					apc_delete($key); 
				break;
			}
		}
	}
?>