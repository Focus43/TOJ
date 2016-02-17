<?php

	class RedisPageCache extends Concrete5_Library_PageCache {
		
		const MD5_PEPPER = 'r3disPaGeCach3r';
		
		public function getRecord($mixed){
			$result = ConcreteRedis::db()->hget(md5(BASE_URL), $this->getCacheKey($mixed));
			if( !($result === null) ){
				$record = @unserialize($result);
				if( $record instanceof PageCacheRecord ){
					return $record;
				}
			}
		}
		
		public function getCacheKey($mixed){
			return md5( MD5_PEPPER . parent::getCacheKey($mixed) );
		}
		
		
		public function purgeByRecord(PageCacheRecord $rec){
			ConcreteRedis::db()->hdel( md5(BASE_URL), $this->getCacheKey($rec) );
		}
		
		public function flush(){
			ConcreteRedis::db()->del( md5(BASE_URL) );
		}
		
		public function purge(Page $c){
			ConcreteRedis::db()->hdel( md5(BASE_URL), $this->getCacheKey($c) );
		}
		
		public function set(Page $c, $content){
			$lifetime  = $c->getCollectionFullPageCachingLifetimeValue();
			$cacheData = new PageCacheRecord($c, $content, $lifetime);
			if( $content ){
				ConcreteRedis::db()->hset( md5(BASE_URL), $this->getCacheKey($c), serialize($cacheData) );
			}
		}
		
	}