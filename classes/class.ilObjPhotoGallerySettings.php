<?php

/**
 * Class ilObjPhotoGallerySettings
 * @author Nadia Matuschek <nmatuschek@databay.de>
 */
class ilObjPhotoGallerySettings
{
	/**
	 * @var int
	 */
	protected $ref_id;
	/**
	 * @var bool
	 */
	protected $slideshow_enabled = false;
	/***
	 * @var int
	 */
	protected $slideshow_seconds = 1;
	/**
	 * @var bool
	 */
	protected $slideshow_repeat  = false;
	/**
	 * @var ilDB
	 */
	protected $db;
	
	/***
	 * ilObjPhotoGallerySettings constructor.
	 * @param $ref_id
	 */
	public function __construct($ref_id)
	{
		global $DIC;
		
		$this->db = $DIC->database();
		$this->ref_id = $ref_id;
		$this->readSettings();
	}

	public function readSettings()
	{
		$res = $this->db->queryF('SELECT * FROM rep_robj_xpho_settings WHERE ref_id = %s',
			array('integer'), array($this->ref_id));
		
		while($row = $this->db->fetchAssoc($res))
		{
			$this->slideshow_enabled = (bool)$row['slideshow_enabled'];
			$this->slideshow_seconds = (int)$row['slideshow_seconds'];
			$this->slideshow_repeat = (bool)$row['slideshow_repeat'];
		}
	}
	
	public function saveSettings()
	{
		$this->db->replace('rep_robj_xpho_settings',
			array('slideshow_enabled' => array('integer', (int)$this->isSlideshowEnabled()),
			      'slideshow_seconds' => array('integer', (int)$this->getSlideshowSeconds()),
			      'slideshow_repeat' => array('integer', (int)$this->isSlideshowRepeat())
			),
			array('ref_id' => array('integer', $this->getRefId())));
	}
	
	/**
	 * @return mixed
	 */
	public function getRefId()
	{
		return $this->ref_id;
	}
	
	/**
	 * @param mixed $ref_id
	 */
	public function setRefId($ref_id)
	{
		$this->ref_id = $ref_id;
	}
	
	/**
	 * @return bool
	 */
	public function isSlideshowEnabled()
	{
		return $this->slideshow_enabled;
	}
	
	/**
	 * @param bool $slideshow_enabled
	 */
	public function setSlideshowEnabled($slideshow_enabled)
	{
		$this->slideshow_enabled = $slideshow_enabled;
	}
	
	/**
	 * @return int
	 */
	public function getSlideshowSeconds()
	{
		return $this->slideshow_seconds;
	}
	
	/**
	 * @param int $slideshow_seconds
	 */
	public function setSlideshowSeconds($slideshow_seconds)
	{
		$this->slideshow_seconds = $slideshow_seconds;
	}
	
	/**
	 * @return bool
	 */
	public function isSlideshowRepeat()
	{
		return $this->slideshow_repeat;
	}
	
	/**
	 * @param bool $slideshow_repeat
	 */
	public function setSlideshowRepeat($slideshow_repeat)
	{
		$this->slideshow_repeat = $slideshow_repeat;
	}
}