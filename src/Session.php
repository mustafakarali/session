<?php

  namespace Eskirex;

  class Session
  {

    public function start ()
    {
      if (session_start() === false)
      {
        return false;
      }
      else
      {
        return true;
      }
    }

    public function destroy ()
    {
      if (session_destroy() === false)
      {
        return false;
      }
      else
      {
        return true;
      }
    }

    public function renewID ($ID)
    {
      $this->destroy();
      $this->setID($ID);
      $this->init();
    }

    public function setID ($ID = false)
    {
      if ($ID === false || session_id($ID) === false)
      {
        return false;
      }
      else
      {
        return true;
      }
    }

    public function getID ()
    {
      if (session_id() === false)
      {
        return false;
      }
      else
      {
        return session_id();
      }
    }

    public function set ($name = false, $value = false)
    {
      if (strstr($name, '/'))
      {
        $keys  = explode('/', $name);
        $array = &$_SESSION;

        foreach ($keys as $key)
        {
          if (!isset($array[$key]))
          {
            $array[$key] = [];
          }
          $array = &$array[$key];

        }

        $array = $value;

        return true;
      }
      else
      {
        $_SESSION[$name] = $value;

        return true;
      }
    }

    public function get ($name)
    {
      if (strstr($name, '/'))
      {

        $keys  = explode('/', $name);
        $array = &$_SESSION;
        foreach ($keys as $key)
        {
          if (!$this->exists($array, $key))
          {
            return false;
          }
          $array = &$array[$key];
        }

        return $array;

      }
      else if (isset($_SESSION[$name]))
      {
        return $_SESSION[$name];
      }
      else
      {
        return false;
      }
    }

    public function unset ($name)
    {
      if (strstr($name, '/'))
      {
        $keys  = explode('/', $name);
        $array = &$_SESSION;
        $last  = array_pop($keys);
        foreach ($keys as $key)
        {
          if (!$this->exists($array, $key))
          {
            return false;
          }
          $array = &$array[$key];
        }
        unset($array[$last]);

        return true;
      }
      else
      {
        if (isset($_SESSION[$name]))
        {
          unset($_SESSION[$name]);

          return true;
        }
        else
        {
          return false;
        }
      }

    }

    public function exists ($array, $key)
    {
      if ($array instanceof ArrayAccess)
      {
        return isset($array[$key]);
      }

      return array_key_exists($key, $array);
    }
  }
