<?php

if (!function_exists('checkTenantId')) {
  function checkTenantId()
  {
    return session()->has('tenant_id') && !is_null(session('tenant_id'));
  }
}

if (!function_exists('getTenantId')) {
  function getTenantId()
  {
    return session('tenant_id');
  }
}

if (!function_exists('setTenantId')) {
  function setTenantId($tenantId)
  {
    session()->put('tenant_id', $tenantId);
  }
}
