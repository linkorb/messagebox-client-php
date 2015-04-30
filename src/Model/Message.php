<?php

namespace MessageBox\Client\Model;

class Message
{
    private $id;
    
    public function getId()
    {
        return $this->id;
    }
    
    public function setId($id)
    {
        $this->id = $id;
    }
    
    private $subject;
    
    public function getSubject()
    {
        return $this->subject;
    }
    
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }
    
    private $to_box;
    
    public function getToBox()
    {
        return $this->to_box;
    }
    
    public function setToBox($to_box)
    {
        $this->to_box = $to_box;
    }
    
    private $to_displayname;
    
    public function getToDisplayname()
    {
        return $this->to_displayname;
    }
    
    public function setToDisplayname($to_displayname)
    {
        $this->to_displayname = $to_displayname;
    }
    
    private $from_box;
    
    public function getFromBox()
    {
        return $this->from_box;
    }
    
    public function setFromBox($from_box)
    {
        $this->from_box = $from_box;
    }
    
    private $from_displayname;
    
    public function getFromDisplayname()
    {
        return $this->from_displayname;
    }
    
    public function setFromDisplayname($from_displayname)
    {
        $this->from_displayname = $from_displayname;
    }
    
    private $created_at;
    
    public function getCreatedAt()
    {
        return $this->created_at;
    }
    
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }
    
    
    private $deleted_at;
    
    public function getDeletedAt()
    {
        return $this->deleted_at;
    }
    
    public function setDeletedAt($deleted_at)
    {
        $this->deleted_at = $deleted_at;
    }
    
    private $seen_at;
    
    public function getSeenAt()
    {
        return $this->seen_at;
    }
    
    public function setSeenAt($seen_at)
    {
        $this->seen_at = $seen_at;
    }
    
    
    private $content_type = 'text/plain';
    
    public function getContentType()
    {
        return $this->content_type;
    }
    
    public function setContentType($content_type)
    {
        $this->content_type = $content_type;
    }
    
    
    private $content;
    
    public function getContent()
    {
        return $this->content;
    }
    
    public function setContent($content)
    {
        $this->content = $content;
    }
}
